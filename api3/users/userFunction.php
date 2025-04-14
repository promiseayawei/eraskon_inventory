<?php
// Start the session
session_start();
?>

<?php

use OpenApi\Annotations as OA;

include_once('helper/initiate_bvn_lookup.php');
require_once __DIR__ . '/../helper/phpMailer.php';

function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}


function login($userInput)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    if (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return error422('Enter a valid email address');
    } elseif (empty(trim($password))) {
        return error422('Enter a password');
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) if ($result) {
            if ($result->num_rows > 0) {
                $res = $result->fetch_assoc();

                if (password_verify($password, $res['password'])) {

                    // Use JOIN to get the role-specific data in one query
                    $query = "
                        SELECT 
                            users.id as user_id, users.email, users.phone, users.role, 
                            users.first_name, users.last_name, users.state, users.account_type,
                            users.mobilizer as mobilizer_id, users.field_officer as field_officer_id, 
                            users.supervisor as supervisor_id, users.project_manager as project_manager_id, 
                            users.project_director as project_director_id,
                            mobilizer.first_name as mobilizer_first_name, mobilizer.last_name as mobilizer_last_name, 
                            field_officer.first_name as field_officer_first_name, field_officer.last_name as field_officer_last_name,
                            supervisor.first_name as supervisor_first_name, supervisor.last_name as supervisor_last_name, 
                            project_manager.first_name as project_manager_first_name, project_manager.last_name as project_manager_last_name, 
                            project_director.first_name as project_director_first_name, project_director.last_name as project_director_last_name 
                        FROM 
                            users 
                        LEFT JOIN 
                            mobilizer ON users.mobilizer = mobilizer.id 
                        LEFT JOIN 
                            field_officer ON users.field_officer = field_officer.id 
                        LEFT JOIN 
                            supervisor ON users.supervisor = supervisor.id 
                        LEFT JOIN 
                            project_manager ON users.project_manager = project_manager.id 
                        LEFT JOIN 
                            project_director ON users.project_director = project_director.id 
                        WHERE 
                            users.id = ?
                    ";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $res['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userData = $result->fetch_assoc();

                        $data = [
                            'status' => 200,
                            'message' => 'Login Successful',
                            'data' => [
                                'id' => $userData['user_id'],
                                'email' => $userData['email'],
                                'phone' => $userData['phone'],
                                'role' => $userData['role'],
                                'first_name' => $userData['first_name'],
                                'last_name' => $userData['last_name'],
                                'state' => $userData['state'],
                                'account_type' => $userData['account_type'],
                                'mobilizer_id' => $userData['mobilizer_id'],
                                'field_officer_id' => $userData['field_officer_id'],
                                'supervisor_id' => $userData['supervisor_id'],
                                'project_manager_id' => $userData['project_manager_id'],
                                'project_director_id' => $userData['project_director_id'],
                                'mobilizer' => [
                                    'first_name' => $userData['mobilizer_first_name'],
                                    'last_name' => $userData['mobilizer_last_name']
                                ],
                                'field_officer' => [
                                    'first_name' => $userData['field_officer_first_name'],
                                    'last_name' => $userData['field_officer_last_name']
                                ],
                                'supervisor' => [
                                    'first_name' => $userData['supervisor_first_name'],
                                    'last_name' => $userData['supervisor_last_name']
                                ],
                                'project_manager' => [
                                    'first_name' => $userData['project_manager_first_name'],
                                    'last_name' => $userData['project_manager_last_name']
                                ],
                                'project_director' => [
                                    'first_name' => $userData['project_director_first_name'],
                                    'last_name' => $userData['project_director_last_name']
                                ]
                            ],
                            'token' => generateJWT(['email' => $email]),
                        ];

                        header("HTTP/1.0 200 OK");
                        return json_encode($data);
                    } else {
                        $data = [
                            'status' => 404,
                            'message' => ucfirst($res['role']) . ' Data Not Found',
                        ];
                        header("HTTP/1.0 404 Not Found");
                        return json_encode($data);
                    }
                } else {
                    $data = [
                        'status' => 401,
                        'message' => 'Invalid Password',
                    ];
                    header("HTTP/1.0 401 Unauthorized");
                    return json_encode($data);
                }
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'User Not Found',
                ];
                header("HTTP/1.0 404 Not Found");
                return json_encode($data);
            }
        }
    }
}

function logUserLogin($userId)
{
    global $conn;

    // Get device name
    $device = getDeviceName();

    // Get IP address
    $ip = getUserIpAddress();

    // Get current location (requires external API or service)
    $location = getCurrentLocation($ip);

    // Prepare SQL statement
    $query = "INSERT INTO users_login_log (device, location, ip, users) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssi", $device, $location, $ip, $userId);
        $stmt->execute();

        // if ($stmt->affected_rows > 0) {
        //     echo "User login logged successfully.";
        // } else {
        //     echo "Failed to log user login.";
        // }

        $stmt->close();
    } else {
        echo "Failed to prepare statement: " . $conn->error;
    }
}

// Helper function to get the device name
function getDeviceName()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    // Simplified detection
    if (stripos($userAgent, 'Windows') !== false) {
        return 'Windows';
    } elseif (stripos($userAgent, 'Mac') !== false) {
        return 'Mac';
    } elseif (stripos($userAgent, 'Linux') !== false) {
        return 'Linux';
    } elseif (stripos($userAgent, 'Android') !== false) {
        return 'Android';
    } elseif (stripos($userAgent, 'iPhone') !== false) {
        return 'iPhone';
    }
    return 'Unknown Device';
}

// Helper function to get the user's IP address
function getUserIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Helper function to get current location using IP
function getCurrentLocation($ip)
{
    $location = 'Unknown';

    // Use an external API for IP geolocation (e.g., ip-api.com, ipstack, etc.)
    $apiUrl = "http://ip-api.com/json/$ip";
    $response = @file_get_contents($apiUrl);

    if ($response) {
        $data = json_decode($response, true);
        if ($data['status'] == 'success') {
            $location = $data['city'] . ', ' . $data['country'];
        }
    }

    return $location;
}



function signUp($userInput)
{
    global $conn;
    session_start(); // Ensure session is started

    $bvnno = mysqli_real_escape_string($conn, $userInput['bvnno']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $phone = mysqli_real_escape_string($conn, $userInput['phone']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $nin = mysqli_real_escape_string($conn, $userInput['nin']);
    $account_type = mysqli_real_escape_string($conn, $userInput['account_type']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    if (empty(trim($bvnno))) return error422('Enter your bvn');
    if (empty(trim($email))) return error422('Enter your email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return error422('Enter a valid email address');
    if (empty(trim($phone))) return error422('Enter your phone');
    if (empty(trim($first_name))) return error422('Enter your first name');
    if (empty(trim($last_name))) return error422('Enter your last name');
    if (empty(trim($account_type))) return error422('Enter your account type');
    if (empty(trim($nin))) return error422('Enter your nin');
    if (empty(trim($state))) return error422('Enter your state');
    if (empty(trim($password))) return error422('Enter your password');

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $status_info = "bvn verified";

    try {
        $insertQuery = "INSERT INTO users (bvn, email, phone, first_name, last_name, nin, account_type, state, status, password) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            die("Prepare failed: " . $conn->error);  // Debug prepare error
        }

        $insertStmt->bind_param("ssssssssss", $bvnno, $email, $phone, $first_name, $last_name, $nin, $account_type, $state, $status_info, $hashedPassword);

        if (!$insertStmt->execute()) {
            die("Execute failed: " . $insertStmt->error);  // Debug execution error
        }

        // Retrieve last inserted user ID
        $user_id = mysqli_insert_id($conn);
        if (!$user_id) {
            die("Failed to get user ID: " . mysqli_error($conn));
        }

        $_SESSION['user_id'] = $user_id;  // Store in session

        echo "User successfully created. User ID: " . $_SESSION['user_id'];

        $body = "<p>Dear Agent,</p><p>Thank you for registering for the E-Networks partners agency platform</p>";
        sendEmail($email, "User", $body);

        $token = generateJWT(['email' => $email]);

        $data = [
            'status' => 201,
            'message' => 'User Created Successfully',
            'user_id' => $user_id,
            'token' => $token,
        ];

        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage()); // Debug exceptions
    }
}



// function sendUserDataToExternalAPI
// function sendUserDataToExternalAPI($payload)
// {
//     $apiUrl = "localhost/kalpep-api-test/users/signUp"; // Replace with actual API URL

//     $ch = curl_init($apiUrl);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Content-Type: application/json',
//         'Accept: application/json',
//         'Authorization: Bearer your_api_key_here' // If authentication is required
//     ]);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

//     $response = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     if ($httpCode == 200) {
//         $responseData = json_decode($response, true);
//         return $responseData['account_number'] ?? 'N/A';
//     } else {
//         return 'N/A'; // Return 'N/A' if the API request fails
//     }
// }

// function generateApiKey()
// {
//     return bin2hex(random_bytes(32)); // Generates a 64-character secure API key
// }

// $apiKey = generateApiKey();
// echo "Your API Key: " . $apiKey;


// function for forgetPassword
function forgetPassword($userInput)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $userInput['email']);

    if (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return error422('Enter a valid email address');
    } else {
        // Check if the user exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Generate reset token and expiry
            $token = bin2hex(random_bytes(32));
            $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Store token in password_reset table
            $insertQuery = "INSERT INTO password_reset (email, token, expires_at) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sss", $email, $token, $expiresAt);
            $insertStmt->execute();

            // Send reset email
            $resetLink = "https://enetworkstechnologiesltd.com/api/resetPassword?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $resetLink\nThis link will expire in 1 hour.";
            sendEmail($email, $subject, $message);

            $data = [
                'status' => 200,
                'message' => 'Password reset link sent to your email',
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No user found with this email',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    }
}

// Function for resetPassword
function resetPassword($userInput)
{
    global $conn;

    $token = mysqli_real_escape_string($conn, $userInput['token']);
    $newPassword = mysqli_real_escape_string($conn, $userInput['new_password']);

    if (empty(trim($token)) || empty(trim($newPassword))) {
        return error422('Token and new password are required');
    }

    // Validate token
    $query = "SELECT email, expires_at FROM password_reset WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        if (strtotime($reset['expires_at']) > time()) {
            // Update user's password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $hashedPassword, $reset['email']);
            $updateStmt->execute();

            // Delete the used reset token
            $deleteQuery = "DELETE FROM password_reset WHERE token = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("s", $token);
            $deleteStmt->execute();

            $data = [
                'status' => 200,
                'message' => 'Password reset successfully',
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 400,
                'message' => 'Invalid or expired token',
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 400,
            'message' => 'Invalid or expired token',
        ];
        header("HTTP/1.0 400 Bad Request");
        return json_encode($data);
    }
}


function getUserAss($userParams)
{
    global $conn;

    // Validate input
    if (empty($userParams) || !isset($userParams['id']) || !is_numeric($userParams['id'])) {
        return json_encode([
            'status' => 422,
            'message' => 'A valid User ID is required',
        ]);
    }

    $user_id = $userParams['id'];

    // Step 1: Get current user details
    $query = "SELECT id, role FROM users WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        return json_encode([
            'status' => 500,
            'message' => 'Database error: Failed to prepare user check. ' . $conn->error,
        ]);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return json_encode([
            'status' => 404,
            'message' => 'User not found',
        ]);
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    // Step 2: If role is "field_officer", fetch their assignees
    if ($user['role'] === 'field_officer') {
        $query = "
            SELECT 
                u.id AS user_id,
                u.date_created,
                u.first_name,
                u.last_name,
                u.phone,
                u.email,
                u.account_type,
                u.state
        
            FROM users u
            LEFT JOIN mobilizer m ON u.id = m.id
            WHERE u.field_officer = ?
        ";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            return json_encode([
                'status' => 500,
                'message' => 'Database error: Failed to prepare assignees query. ' . $conn->error,
            ]);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $assignees = [];
        while ($row = $result->fetch_assoc()) {
            $assignees[] = $row;
        }

        return json_encode([
            'status' => 200,
            'message' => 'Assigned users fetched successfully',
            'data' => $assignees
        ]);
    } else {
        return json_encode([
            'status' => 403,
            'message' => 'Access denied: User is not a field officer'
        ]);
    }
}


function getUserProfile($user_email)
{
    global $conn;

    if (empty($user_email)) {
        return json_encode([
            'status' => 422,
            'message' => 'email is required',
        ]);
    }

    $user_email = mysqli_real_escape_string($conn, $user_email);


    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) if ($result) {
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();

            $profile_role = $res['role'];

            // Validate the role against a whitelist of allowed table names to prevent SQL injection
            $validRoles = ['admin', 'manager', 'editor']; // Add other valid roles as needed
            if (!in_array($profile_role, $validRoles)) {
                die(json_encode([
                    'status' => 400,
                    'message' => 'Invalid role specified',
                ]));
            }

            // Prepare the query dynamically based on the role
            $query = "
                    SELECT 
                        users.id as user_id, users.email, users.phone, users.role, 
                        $profile_role.* 
                    FROM 
                        users 
                    LEFT JOIN 
                        $profile_role 
                    ON 
                        users.role = $profile_role.id 
                    WHERE 
                        users.id = ?
                ";


            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $res['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();

                $data = [
                    'status' => 200,
                    'message' => 'Login Successful',
                    'data' => [
                        'id' => $userData['user_id'],
                        'email' => $userData['email'],
                        'phone' => $userData['phone'],
                        'role' => $userData['role'],
                        'admin_data' => [
                            'first_name' => $userData['first_name'],
                            'last_name' => $userData['last_name'],
                            'state' => $userData['state'],
                            'lga' => $userData['lga'],
                            'town' => $userData['town'],
                            'date_created' => $userData['date_created'],
                            'date_updated' => $userData['date_updated']
                        ]
                    ],

                ];
                header("HTTP/1.0 200 OK");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'Admin Data Not Found',
                ];
                header("HTTP/1.0 404 Not Found");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 404,
                'message' => 'User Not Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    }
}
// Function to get a single user by ID and role-specific data
function getUserById($userId)
{
    global $conn;

    if (empty($userId)) {
        return json_encode([
            'status' => 422,
            'message' => 'User ID is required',
        ]);
    }

    $userId = mysqli_real_escape_string($conn, $userId);

    // Use JOIN to get the role-specific data in one query
    $query = "
        SELECT 
            users.id as user_id, users.email, users.phone, users.role, 
            users.first_name, users.last_name, users.state, users.account_type,
            users.mobilizer as mobilizer_id, users.field_officer as field_officer_id, 
            users.supervisor as supervisor_id, users.project_manager as project_manager_id, 
            users.project_director as project_director_id,
            mobilizer.first_name as mobilizer_first_name, mobilizer.last_name as mobilizer_last_name, 
            field_officer.first_name as field_officer_first_name, field_officer.last_name as field_officer_last_name,
            supervisor.first_name as supervisor_first_name, supervisor.last_name as supervisor_last_name, 
            project_manager.first_name as project_manager_first_name, project_manager.last_name as project_manager_last_name, 
            project_director.first_name as project_director_first_name, project_director.last_name as project_director_last_name 
        FROM 
            users 
        LEFT JOIN 
            mobilizer ON users.mobilizer = mobilizer.id 
        LEFT JOIN 
            field_officer ON users.field_officer = field_officer.id 
        LEFT JOIN 
            supervisor ON users.supervisor = supervisor.id 
        LEFT JOIN 
            project_manager ON users.project_manager = project_manager.id 
        LEFT JOIN 
            project_director ON users.project_director = project_director.id 
        WHERE 
            users.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        $data = [
            'status' => 200,
            'message' => 'User found',
            'data' => [
                'id' => $userData['user_id'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'role' => $userData['role'],
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'state' => $userData['state'],
                'account_type' => $userData['account_type'],
                'mobilizer_id' => $userData['mobilizer_id'],
                'field_officer_id' => $userData['field_officer_id'],
                'supervisor_id' => $userData['supervisor_id'],
                'project_manager_id' => $userData['project_manager_id'],
                'project_director_id' => $userData['project_director_id'],
                'mobilizer' => [
                    'first_name' => $userData['mobilizer_first_name'],
                    'last_name' => $userData['mobilizer_last_name']
                ],
                'field_officer' => [
                    'first_name' => $userData['field_officer_first_name'],
                    'last_name' => $userData['field_officer_last_name']
                ],
                'supervisor' => [
                    'first_name' => $userData['supervisor_first_name'],
                    'last_name' => $userData['supervisor_last_name']
                ],
                'project_manager' => [
                    'first_name' => $userData['project_manager_first_name'],
                    'last_name' => $userData['project_manager_last_name']
                ],
                'project_director' => [
                    'first_name' => $userData['project_director_first_name'],
                    'last_name' => $userData['project_director_last_name']
                ]
            ],
            'token' => generateJWT(['email' => $userData['email']]),
        ];

        header("HTTP/1.0 200 OK");
        return json_encode($data);
    } else {
        $data = [
            'status' => 404,
            'message' => 'User Data Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}
// Function to get user referral data by ID (unprotected endpoint)
function refUserById($referral_id) {
    global $conn;

    // Validate the input
    if (empty($referral_id)) {
        return json_encode([
            'status' => 422,
            'message' => 'Referral ID is required',
        ]);
    }

    // Prepare and execute the query to fetch a single user by ID
    $query = "
        SELECT 
            users.id as user_id, users.email, users.phone, users.role, 
            users.first_name, users.last_name, users.state, users.account_type,
            users.mobilizer as mobilizer_id, users.field_officer as field_officer_id, 
            users.supervisor as supervisor_id, users.project_manager as project_manager_id, 
            users.project_director as project_director_id,
            mobilizer.first_name as mobilizer_first_name, mobilizer.last_name as mobilizer_last_name, 
            field_officer.first_name as field_officer_first_name, field_officer.last_name as field_officer_last_name,
            supervisor.first_name as supervisor_first_name, supervisor.last_name as supervisor_last_name, 
            project_manager.first_name as project_manager_first_name, project_manager.last_name as project_manager_last_name, 
            project_director.first_name as project_director_first_name, project_director.last_name as project_director_last_name 
        FROM 
            users 
        LEFT JOIN 
            mobilizer ON users.mobilizer = mobilizer.id 
        LEFT JOIN 
            field_officer ON users.field_officer = field_officer.id 
        LEFT JOIN 
            supervisor ON users.supervisor = supervisor.id 
        LEFT JOIN 
            project_manager ON users.project_manager = project_manager.id 
        LEFT JOIN 
            project_director ON users.project_director = project_director.id 
        WHERE 
            users.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $referral_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        // Format the response as a single user object
        $data = [
            'status' => 200,
            'message' => 'Referral User Found',
            'data' => [
                'id' => $userData['user_id'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'role' => $userData['role'],
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'state' => $userData['state'],
                'account_type' => $userData['account_type'],
                'mobilizer_id' => $userData['mobilizer_id'],
                'field_officer_id' => $userData['field_officer_id'],
                'supervisor_id' => $userData['supervisor_id'],
                'project_manager_id' => $userData['project_manager_id'],
                'project_director_id' => $userData['project_director_id'],
                'mobilizer' => [
                    'first_name' => $userData['mobilizer_first_name'],
                    'last_name' => $userData['mobilizer_last_name']
                ],
                'field_officer' => [
                    'first_name' => $userData['field_officer_first_name'],
                    'last_name' => $userData['field_officer_last_name']
                ],
                'supervisor' => [
                    'first_name' => $userData['supervisor_first_name'],
                    'last_name' => $userData['supervisor_last_name']
                ],
                'project_manager' => [
                    'first_name' => $userData['project_manager_first_name'],
                    'last_name' => $userData['project_manager_last_name']
                ],
                'project_director' => [
                    'first_name' => $userData['project_director_first_name'],
                    'last_name' => $userData['project_director_last_name']
                ]
            ],
        ];

        return json_encode($data);
    } else {
        // If no referral user is found
        $data = [
            'status' => 404,
            'message' => 'Referral User Not Found',
        ];
        return json_encode($data);
    }
}


// Function to get users by role
function getUserByRole($role)
{
    global $conn;

    if (empty($role)) {
        return json_encode([
            'status' => 422,
            'message' => 'Role is required',
        ]);
    }

    $role = mysqli_real_escape_string($conn, $role);

    // Get the role data dynamically
    $query = "SELECT users.id, users.email, users.phone, users.role FROM users WHERE role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $users = [];
        while ($user = $result->fetch_assoc()) {
            $users[] = $user;
        }

        return json_encode([
            'status' => 200,
            'message' => 'Users found',
            'data' => $users
        ]);
    } else {
        return json_encode([
            'status' => 404,
            'message' => 'No users found with the specified role',
        ]);
    }
}

// Function to get all users
function getUserList()
{
    global $conn;

    $query = "SELECT id, email, phone, role FROM users";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $users = [];
        while ($user = $result->fetch_assoc()) {
            $users[] = $user;
        }

        return json_encode([
            'status' => 200,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ]);
    } else {
        return json_encode([
            'status' => 404,
            'message' => 'No users found',
        ]);
    }
}

// function getUserByRole($userParams)
// {
//     global $conn;
//     if ($userParams['role'] == null) {
//         return error422('Enter your user role');
//     }

//     $user_role = mysqli_real_escape_string($conn, $userParams['role']);


//     $query = "
//             SELECT 
//                 users.id as user_id, users.email, users.phone, users.role, 
//                 $user_role.* 
//             FROM 
//                 users 
//             LEFT JOIN 
//                 $user_role 
//             ON 
//                 users.$user_role = $user_role.id 
//             WHERE 
//                 users.role = {$userParams['role']}
//             ";
//     $query_run = mysqli_query($conn, $query);



//     if ($query_run) {
//         if (mysqli_num_rows($query_run) > 0) {
//             $users = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

//             $data = [
//                 'status' => 200,
//                 'message' => 'User List Fetched Successfully',
//                 'data' => $users,
//             ];
//             header("HTTP/1.0 200 OK");
//             return json_encode($data);
//         } else {
//             $data = [
//                 'status' => 404,
//                 'message' => 'No Users Found',
//             ];
//             header("HTTP/1.0 404 Not Found");
//             return json_encode($data);
//         }
//     } else {
//         $data = [
//             'status' => 500,
//             'message' => 'Internal Server Error',
//         ];
//         header("HTTP/1.0 500 Internal Server Error");
//         return json_encode($data);
//     }
// }

// function getUserList()
// {
//     global $conn;

//     $usersQuery = "SELECT id, email, phone, date_created, role FROM users";
//     $usersResult = mysqli_query($conn, $usersQuery);

//     if ($usersResult) {
//         if (mysqli_num_rows($usersResult) > 0) {
//             $users = mysqli_fetch_all($usersResult, MYSQLI_ASSOC);
//             $finalData = [];

//             foreach ($users as $user) {
//                 $roleTable = mysqli_real_escape_string($conn, $user['role']); // Sanitize table name

//                 // Dynamic SQL to join with the table matching the role name
//                 $joinQuery = "SELECT * FROM `$roleTable` WHERE id = ?";
//                 $stmt = $conn->prepare($joinQuery);

//                 if ($stmt) {
//                     $stmt->bind_param("i", $user['id']);
//                     $stmt->execute();
//                     $roleData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//                     $stmt->close();

//                     // Add role data to the user record
//                     $user['role_data'] = $roleData;
//                 } else {
//                     $user['role_data'] = [];
//                 }

//                 $finalData[] = $user;
//             }

//             $data = [
//                 'status' => 200,
//                 'message' => 'User List Fetched Successfully',
//                 'data' => $finalData,
//             ];
//             header("HTTP/1.0 200 OK");
//             return json_encode($data);
//         } else {
//             $data = [
//                 'status' => 404,
//                 'message' => 'No Users Found',
//             ];
//             header("HTTP/1.0 404 Not Found");
//             return json_encode($data);
//         }
//     } else {
//         $data = [
//             'status' => 500,
//             'message' => 'Internal Server Error',
//         ];
//         header("HTTP/1.0 500 Internal Server Error");
//         return json_encode($data);
//     }
// }
