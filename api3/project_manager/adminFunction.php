<?php
//special functins of the admin
//create for all:
    //1. update_by_role->
//update for all
// delete for all
// read all
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

        if ($result) {
            if ($result->num_rows > 0) {
                $res = $result->fetch_assoc();
                if (password_verify($password, $res['password'])) {
                    $data = [
                        'status' => 200,
                        'message' => 'Login Successful',
                        'data' => [
                            'id' => $res['id'],
                            'email' => $res['email'],
                            'phone' => $res['phone']
                        ],
                        'token' => generateJWT(['email' => $email]),
                    ];
                    header("HTTP/1.0 200 OK");
                    return json_encode($data);
                } else {
                    $data = [
                        'status' => 401,
                        'message' => 'Invalid Login Details',
                    ];
                    header("HTTP/1.0 401 Unauthorized Access");
                    return json_encode($data);
                }
            } else {
                $data = [
                    'status' => 401,
                    'message' => 'Invalid Login Details',
                ];
                header("HTTP/1.0 401 Unauthorized Access");
                return json_encode($data);
            }
        }
    }
}

function createProjectDirector($userInput)
{
    global $conn;

    $admin_first_name = mysqli_real_escape_string($conn, $userInput['admin_first_name']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $lga = mysqli_real_escape_string($conn, $userInput['lga']);
    $town = mysqli_real_escape_string($conn, $userInput['town']);

    if (empty(trim($admin_first_name))) {
        return error422('Enter your Admin first name');
    } elseif (empty(trim($first_name))) {
        return error422('Enter your first name');
    } elseif (empty(trim($last_name))) {
        return error422('Enter your last name');
    } elseif (empty(trim($state))) {
        return error422('Enter your state');
    } elseif (empty(trim($lga))) {
        return error422('Enter your lga');
    } elseif (empty(trim($town))) {
        return error422('Enter your town');
    } else {
        

        try {

            $query = "INSERT INTO project_director (first_name, last_name, state, lga, town) VALUES ('$first_name', '$last_name', '$state', '$lga', '$town')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                
                // send log data 
                $description = "$admin_first_name created new project director";
                $query = "INSERT INTO project_director_log (description, first_name, last_name, state, lga, town) VALUES ('$description','$first_name', '$last_name', '$state', '$lga', '$town')";
                $res=mysqli_query($conn, $query);
                print_r($res);
                $data = [
                    'status' => 201,
                    'message' => 'Project Director Created Successfully'
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

        } catch(Exception $e) {

            $data = [
                'status' => 400,
                'message' =>"$first_name already exists",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);
        }
    }
}

function update_project_director_user($userInput)
{
    // print_r($userInput);
    if(!$userInput['operator_role'] == "admin") {}
   
    global $conn;
    $operator_email = mysqli_real_escape_string($conn, $userInput['operator_email']);
    $operator_id = mysqli_real_escape_string($conn, $userInput['operator_id']);
    $operator_role = mysqli_real_escape_string($conn, $userInput['operator_role']);
    $user_id= mysqli_real_escape_string($conn, $userInput['user_id']);
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

        }else {
            $data = [
                'status' => 400,
                'message' =>"Only admins allowed",
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
    $user_id= mysqli_real_escape_string($conn, $userInput['user_id']);
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

        }else {
            $data = [
                'status' => 400,
                'message' =>"Only admins allowed",
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
    $user_id= mysqli_real_escape_string($conn, $userInput['user_id']);
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

        }else {
            $data = [
                'status' => 400,
                'message' =>"Only admins allowed",
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
    $user_id= mysqli_real_escape_string($conn, $userInput['user_id']);
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

        }else {
            $data = [
                'status' => 400,
                'message' =>"Only admins allowed",
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
    $user_id= mysqli_real_escape_string($conn, $userInput['user_id']);
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

        }else {
            $data = [
                'status' => 400,
                'message' =>"Only admins allowed",
            ];
            header("HTTP/1.0 400 Bad Request");
            return json_encode($data);

        }
    }
}



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

            // Store token in password_resets table
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
    $query = "SELECT email, expires_at FROM password_resets WHERE token = ?";
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
            $deleteQuery = "DELETE FROM password_resets WHERE token = ?";
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


function getUser($userParams)
{
    global $conn;

    if ($userParams['id'] == null) {
        return error422('Enter your user id');
    }

    $user_id = mysqli_real_escape_string($conn, $userParams['id']);

    $query = "SELECT id, email, phone, date_created FROM users WHERE id= '$user_id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return json_encode($res[0]);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    }
}

function getUserList()
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
