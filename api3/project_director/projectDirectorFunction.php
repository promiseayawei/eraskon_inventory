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

function createProjectManager($userInput)
{
    global $conn;

    $project_director_first_name = mysqli_real_escape_string($conn, $userInput['project_director_first_name']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $lga = mysqli_real_escape_string($conn, $userInput['lga']);
    $town = mysqli_real_escape_string($conn, $userInput['town']);
    $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);

    // Validate inputs
    if (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($project_director_first_name))) {
        return error422('Enter your Project Director first name');
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
    } elseif (empty(trim($project_director_id))) {
        return error422('Enter your project director');
    }

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists
        $res = $result->fetch_assoc();
        if ($res['email'] == $email) {
            // Insert new project manager record
            $insertQuery = "INSERT INTO project_manager (first_name, last_name, state, lga, town, project_director) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssss", $first_name, $last_name, $state, $lga, $town, $project_director_id);
            $insertResult = $stmt->execute();

            if ($insertResult) {
                // Log data
                $description = "$project_director_first_name created new project director";
                $logQuery = "INSERT INTO project_manager_log (description, first_name, last_name, state, lga, town, project_director) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($logQuery);
                $stmt->bind_param("sssssss", $description, $first_name, $last_name, $state, $lga, $town, $project_director_id);
                $logResult = $stmt->execute();

                if ($logResult) {
                    $data = [
                        'status' => 201,
                        'message' => 'Project Manager Created Successfully'
                    ];
                    header("HTTP/1.0 201 Created");
                    return json_encode($data);
                }
            }

            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 404,
            'message' => 'No User Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}


function createSupervisor($userInput)
{
    global $conn;

    $project_manager_first_name = mysqli_real_escape_string($conn, $userInput['project_manager_first_name']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $lga = mysqli_real_escape_string($conn, $userInput['lga']);
    $town = mysqli_real_escape_string($conn, $userInput['town']);
    $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
    

    if (empty(trim($project_manager_id))) {
        return error422('Enter your project Manager first name');
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
    } elseif (empty(trim($project_manager_id))) {
        return error422('Enter your project manager');
    } else {
        

        try {

            $query = "INSERT INTO supervisor (first_name, last_name, state, lga, town, project_manager) VALUES ('$first_name', '$last_name', '$state', '$lga', '$town', 'project_manager_id')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                
                // send log data 
                $description = "$project_manager_first_name created new project manager";
                $query = "INSERT INTO supervisor_log (description, first_name, last_name, state, lga, town, project_manager) VALUES ('$description','$first_name', '$last_name', '$state', '$lga', '$town', 'project_manager_id')";
                $res=mysqli_query($conn, $query);
                print_r($res);
                $data = [
                    'status' => 201,
                    'message' => 'Supervisor Created Successfully'
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

function createFieldOfficer($userInput)
{
    global $conn;

    $supervisor_first_name = mysqli_real_escape_string($conn, $userInput['supervisor_first_name']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $lga = mysqli_real_escape_string($conn, $userInput['lga']);
    $town = mysqli_real_escape_string($conn, $userInput['town']);
    $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
    

    if (empty(trim($supervisor_first_name))) {
        return error422('Enter your supervisor first name');
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
    } elseif (empty(trim($supervisor_id))) {
        return error422('Enter your supervisor');
    } else {
        

        try {

            $query = "INSERT INTO field_officer (first_name, last_name, state, lga, town, supervisor) VALUES ('$first_name', '$last_name', '$state', '$lga', '$town', 'supervisor_id')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                
                // send log data 
                $description = "$supervisor_first_name created new Field Officer";
                $query = "INSERT INTO field_officer_log (description, first_name, last_name, state, lga, town, supervisor) VALUES ('$description','$first_name', '$last_name', '$state', '$lga', '$town', 'supervisor_id')";
                $res=mysqli_query($conn, $query);
                print_r($res);
                $data = [
                    'status' => 201,
                    'message' => 'Field Officer Created Successfully'
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

function createMobilizer($userInput)
{
    global $conn;

    $field_officer_first_name = mysqli_real_escape_string($conn, $userInput['field_officer_first_name']);
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $state = mysqli_real_escape_string($conn, $userInput['state']);
    $lga = mysqli_real_escape_string($conn, $userInput['lga']);
    $town = mysqli_real_escape_string($conn, $userInput['town']);
    $field_officer_id = mysqli_real_escape_string($conn, $userInput['field_officer_id']);
    

    if (empty(trim($field_officer_id))) {
        return error422('Enter your project Manager first name');
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
    } elseif (empty(trim($field_officer_id))) {
        return error422('Enter your field officer');
    } else {
        

        try {

            $query = "INSERT INTO mobilizer (first_name, last_name, state, lga, town, field_officer) VALUES ('$first_name', '$last_name', '$state', '$lga', '$town', 'field_officer_id')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                
                // send log data 
                $description = "$field_officer_first_name created new mobilizer";
                $query = "INSERT INTO mobilizer_log (description, first_name, last_name, state, lga, town, field_officer) VALUES ('$description','$first_name', '$last_name', '$state', '$lga', '$town', 'field_officer_id')";
                $res=mysqli_query($conn, $query);
                print_r($res);
                $data = [
                    'status' => 201,
                    'message' => 'mobilizer Created Successfully'
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
