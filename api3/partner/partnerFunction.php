<?php
//special functins of the admin
//create for all:
//1. update_by_role->
//update for all
// delete for all
// read all
// include_once('userFunction.php');
function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}

function createPartner($userInput, $fileInput)
{
    global $conn;

    // Sanitize user inputs
    $short_name = mysqli_real_escape_string($conn, $userInput['short_name']);
    $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
    $address = mysqli_real_escape_string($conn, $userInput['address']);

    // Validate required fields
    if (empty(trim($short_name))) return error422('Enter the short name');
    if (empty(trim($fullname))) return error422('Enter the full name');
    if (empty(trim($address))) return error422('Enter the address');

    // Handle file upload for logo
    $uploadDir = __DIR__ . "/../uploads/partners/"; // Absolute path to the uploads/partners directory

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return error422('Failed to create upload directory.');
        }
    }

    // Validate and move the uploaded file
    if (!empty($fileInput['logo']['tmp_name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileInput['logo']['type'], $allowedTypes)) {
            return error422('Invalid file type. Only JPG, PNG, and GIF are allowed.');
        }

        if ($fileInput['logo']['size'] > 2 * 1024 * 1024) { // Limit to 2MB
            return error422('File size exceeds 2MB.');
        }

        // Sanitize and generate a unique name for the file
        $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', basename($fileInput['logo']['name']));
        $uniqueName = uniqid() . "_" . $fileName;
        $targetFile = $uploadDir . $uniqueName;

        // Check if the temporary file exists
        if (!file_exists($fileInput['logo']['tmp_name'])) {
            return error422('Temporary file does not exist.');
        }

        // Move the uploaded file
        if (!move_uploaded_file($fileInput['logo']['tmp_name'], $targetFile)) {
            error_log("Failed to move uploaded file. Temp file: " . $fileInput['logo']['tmp_name'] . " Target file: " . $targetFile);
            return error422('Failed to upload logo. Check file permissions or path.');
        }
    } else {
        return error422('Logo file is required.');
    }

    // Save the relative path of the logo to the database
    $logoPath = "uploads/partners/" . $uniqueName;

    // Insert partner data into the database
    try {
        $insertQuery = "INSERT INTO partner (short_name, fullname, address, logo) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            die("Prepare failed: " . $conn->error); // Debug prepare error
        }

        $insertStmt->bind_param("ssss", $short_name, $fullname, $address, $logoPath);

        if (!$insertStmt->execute()) {
            die("Execute failed: " . $insertStmt->error); // Debug execution error
        }

        // Retrieve last inserted partner ID
        $partner_id = mysqli_insert_id($conn);
        if (!$partner_id) {
            die("Failed to get partner ID: " . mysqli_error($conn));
        }

        $data = [
            'status' => 201,
            'message' => 'Partner Created Successfully',
            'partner_id' => $partner_id,
            'logo_path' => $logoPath,
        ];

        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage()); // Debug exceptions
    }
}

function update_project_director_user($userInput)
{
    // print_r($userInput);
    if (!$userInput['operator_role'] == "admin") {
    }

    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);

    if (empty(trim($role))) {
        return error422('Enter your role');
    } elseif (empty(trim($project_director_id))) {
        return error422('Enter a valid project director id ');
    } else {

        // Role permission

        $query = "SELECT * FROM users WHERE id= '$operator_id' and role = '$operator_role' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $query = "UPDATE users SET project_director = '$project_director_id', role ='$role' WHERE id = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $description = "$operator_email updated project director";
                $query = "INSERT INTO users_activity_log (description, project_director) VALUES ('$description', '$project_director_id')";
                mysqli_query($conn, $query);

                $data = [
                    'status' => 201,
                    'message' => 'project director updated Successfully',

                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 400,
                'message' => "Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}

function update_project_manager_user($userInput)
{
    // print_r($userInput);
    // if(!$userInput['operator_role'] == "admin") {}

    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);

    if (empty(trim($role))) {
        return error422('Enter your role');
    } elseif (empty(trim($project_manager_id))) {
        return error422('Enter a valid project manager id ');
    } else {

        // Role permission

        $query = "SELECT * FROM users WHERE id= '$operator_id' and role = '$operator_role' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $query = "UPDATE users SET project_manager = '$project_manager_id', role ='$role' WHERE id = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $description = "$operator_email updated project manager";
                $query = "INSERT INTO users_activity_log (description, project_manager) VALUES ('$description', '$project_manager_id')";
                mysqli_query($conn, $query);

                $data = [
                    'status' => 201,
                    'message' => 'project manager updated Successfully',

                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 400,
                'message' => "Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}

function update_supervisor_user($userInput)
{
    // print_r($userInput);
    // if(!$userInput['operator_role'] == "admin") {}

    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);

    if (empty(trim($role))) {
        return error422('Enter your role');
    } elseif (empty(trim($supervisor_id))) {
        return error422('Enter a valid supervisor id ');
    } else {

        // Role permission

        $query = "SELECT * FROM users WHERE id= '$operator_id' and role = '$operator_role' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $query = "UPDATE users SET supervisor = '$supervisor_id', role ='$role' WHERE id = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $description = "$operator_email updated supervisor";
                $query = "INSERT INTO users_activity_log (description, supervisor) VALUES ('$description', '$supervisor_id')";
                mysqli_query($conn, $query);

                $data = [
                    'status' => 201,
                    'message' => 'supervisor updated Successfully',

                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 400,
                'message' => "Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}

function update_field_officer_user($userInput)
{
    // print_r($userInput);
    // if(!$userInput['operator_role'] == "admin") {}

    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    $field_officer_id = mysqli_real_escape_string($conn, $userInput['field_officer_id']);

    if (empty(trim($role))) {
        return error422('Enter your role');
    } elseif (empty(trim($field_officer_id))) {
        return error422('Enter a valid field officer id ');
    } else {

        // Role permission

        $query = "SELECT * FROM users WHERE id= '$operator_id' and role = '$operator_role' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $query = "UPDATE users SET field_officer = '$field_officer_id', role ='$role' WHERE id = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $description = "$operator_email updated field officer";
                $query = "INSERT INTO users_activity_log (description, field_officer) VALUES ('$description', '$field_officer_id')";
                mysqli_query($conn, $query);

                $data = [
                    'status' => 201,
                    'message' => 'field officer updated Successfully',

                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 400,
                'message' => "Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}

function update_mobilizer_user($userInput)
{
    // print_r($userInput);
    // if(!$userInput['operator_role'] == "admin") {}

    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    $mobilizer_id = mysqli_real_escape_string($conn, $userInput['mobilizer_id']);

    if (empty(trim($role))) {
        return error422('Enter your role');
    } elseif (empty(trim($mobilizer_id))) {
        return error422('Enter a valid mobilizer id ');
    } else {

        // Role permission

        $query = "SELECT * FROM users WHERE id= '$operator_id' and role = '$operator_role' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $query = "UPDATE users SET mobilizer = '$mobilizer_id', role ='$role' WHERE id = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $description = "$operator_email updated mobilizer";
                $query = "INSERT INTO users_activity_log (description, mobilizer) VALUES ('$description', '$mobilizer_id')";
                mysqli_query($conn, $query);

                $data = [
                    'status' => 201,
                    'message' => 'mobilizer updated Successfully',

                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 400,
                'message' => "Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}


function getRecord($userParams)
{
    global $conn;

    if ($userParams['email'] == null) {
        return error422('Enter your user email');
    }

    $user_email = mysqli_real_escape_string($conn, $userParams['email']);

    $query = "SELECT id, email, phone, date_created FROM users WHERE email= '$user_email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();
            // Use JOIN to get the role-specific data in one query
            $query = "
            SELECT 
                users.id as user_id, users.email, users.phone, users.role, 
                {$res['role']}.* 
            FROM 
                users 
            LEFT JOIN 
                {$res['role']} 
            ON 
                users.{$res['role']} = {$res['role']}.id 
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
                        "{$res['role']}_data" => [
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
                    'message' => ucfirst($res['role']) . ' Data Not Found',
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

function getRecordByRole($userParams)
{
    global $conn;
    if ($userParams['role'] == null) {
        return error422('Enter your user role');
    }

    $user_role = mysqli_real_escape_string($conn, $userParams['role']);


    $query = "
            SELECT 
                users.id as user_id, users.email, users.phone, users.role, 
                $user_role.* 
            FROM 
                users 
            LEFT JOIN 
                $user_role 
            ON 
                users.$user_role = $user_role.id 
            WHERE 
                users.role = {$userParams['role']}
            ";
    $query_run = mysqli_query($conn, $query);



    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $users = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'User List Fetched Successfully',
                'data' => $users,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Users Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getRecordList()
{
    global $conn;

    $query = "SELECT id, email, phone, date_created FROM users";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'User List Fetched Successfully',
                'data' => $res,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
