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
function refCreateRecord($userInput)
{
    global $conn;

    $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
    $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
    $phone = mysqli_real_escape_string($conn, $userInput['phone']);
    $mobilizer_id = mysqli_real_escape_string($conn, $userInput['mobilizer_id']);
    $field_officer_id = mysqli_real_escape_string($conn, $userInput['field_officer_id']);
    $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
    $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
    $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);

    // Validation
    if (empty(trim($user_id))) return error422('Enter the user_id');
    if (empty(trim($fullname))) return error422('Enter your fullname');
    if (empty(trim($phone))) return error422('Enter your phone');
    if (empty(trim($mobilizer_id))) return error422('Enter your mobilizer id');
    if (empty(trim($field_officer_id))) return error422('Enter your field officer id');
    if (empty(trim($supervisor_id))) return error422('Enter your supervisor id');
    if (empty(trim($project_manager_id))) return error422('Enter your project manager id');
    if (empty(trim($project_director_id))) return error422('Enter your project director');

    // Insert record
    $query = "INSERT INTO records (fullname, phone, mobilizer, field_officer, supervisor, project_manager, project_director, users) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return json_encode([
            'status' => 500,
            'message' => 'Prepare failed: ' . $conn->error
        ]);
    }

    $stmt->bind_param("ssssssss", $fullname, $phone, $mobilizer_id, $field_officer_id, $supervisor_id, $project_manager_id, $project_director_id, $user_id);
    $result = $stmt->execute();

    if (!$result) {
        return json_encode([
            'status' => 500,
            'message' => 'Execute failed: ' . $stmt->error
        ]);
    }

    $record_id = $conn->insert_id;

    // Insert log
    $description = "$fullname created a new record";
    $logQuery = "INSERT INTO records_activity_log 
        (users, records, description, fullname, phone, mobilizer, field_officer, supervisor, project_manager, project_director) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logQuery);

    if (!$logStmt) {
        return json_encode([
            'status' => 500,
            'message' => 'Log Prepare failed: ' . $conn->error
        ]);
    }

    $logStmt->bind_param("ssssssssss", $user_id, $record_id, $description, $fullname, $phone, $mobilizer_id, $field_officer_id, $supervisor_id, $project_manager_id, $project_director_id);
    $res = $logStmt->execute();

    if ($res) {
        return json_encode([
            'status' => 201,
            'message' => 'Record added and log created successfully',
            'record_id' => $record_id
        ]);
    } else {
        return json_encode([
            'status' => 500,
            'message' => 'Log Execute failed: ' . $logStmt->error
        ]);
    }
}

function createRecord($userInput)
{
    global $conn;

    // GLOBAL $result;
    $role = mysqli_real_escape_string($conn, $userInput['role']);
    // $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
    
            if($role == "mobilizer"){
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $mobilizer_id = mysqli_real_escape_string($conn, $userInput['mobilizer_id']);
                $field_officer_id = mysqli_real_escape_string($conn, $userInput['field_officer_id']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operator_name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                } elseif (empty(trim($mobilizer_id))) {
                    return error422('Enter your mobilizer id');
                } elseif (empty(trim($field_officer_id))) {
                    return error422('Enter your field officer id');
                } elseif (empty(trim($supervisor_id))) {
                    return error422('Enter your supervisor id');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone, mobilizer, field_officer, supervisor, project_manager, project_director,users) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sssssss", $fullname, $phone, $mobilizer_id, $field_officer_id, $supervisor_id, $project_manager_id, $project_director_id, $_SESSION['user_id']);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "mobilizer" )  {
                    
                    // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone, mobilizer, field_officer, supervisor, project_manager, project_director) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sssssssss",$user_id, $description,$fullname,$phone,$mobilizer_id,$field_officer_id,$supervisor_id,$project_manager_id,$project_director_id );

                // Execute the prepared statement
                $res = $stmt->execute();

                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by mobilizer'
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
            }
            }elseif($role == "field_officer"){
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $field_officer_id = mysqli_real_escape_string($conn, $userInput['field_officer_id']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operators name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                }elseif (empty(trim($field_officer_id))) {
                    return error422('Enter your field officer id');
                } elseif (empty(trim($supervisor_id))) {
                    return error422('Enter your supervisor id');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone,  field_officer, supervisor, project_manager, project_director, users) 
                VALUES (?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "ssssss", $fullname, $phone,  $field_officer_id, $supervisor_id, $project_manager_id, $project_director_id,  $_SESSION['user_id']);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "field_officer" )  {
                    
                    // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone,  field_officer, supervisor, project_manager, project_director) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "ssssssss",$user_id, $description,$fullname,$phone,$field_officer_id,$supervisor_id,$project_manager_id,$project_director_id );

                // Execute the prepared statement
                $res = $stmt->execute();
                    print_r($res);
                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by field officer'
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
            }
            }elseif($role == "supervisor"){
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operators name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                } elseif (empty(trim($supervisor_id))) {
                    return error422('Enter your supervisor id');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone,  supervisor, project_manager, project_director, users) 
                VALUES (?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sssss", $fullname, $phone,  $supervisor_id, $project_manager_id, $project_director_id,  $_SESSION['user_id']);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "supervisor" )  {
                    
                // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone,  supervisor, project_manager, project_director) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sssssss",$user_id, $description,$fullname,$phone,$supervisor_id,$project_manager_id,$project_director_id );

                // Execute the prepared statement
                $res = $stmt->execute();
                    print_r($res);
                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by supervisor'
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
            }
            }elseif($role == "project_manager"){
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operators name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone, project_manager, project_director) 
                VALUES (?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "ssss", $fullname, $phone,   $project_manager_id, $project_director_id);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "project_manager" )  {
                    
                    // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone,   project_manager, project_director) 
                VALUES (?, ?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "ssssss",$user_id, $description,$fullname,$phone,$project_manager_id,$project_director_id );

                // Execute the prepared statement
                $res = $stmt->execute();
                    print_r($res);
                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by project_manager'
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
            }
            }elseif($role == "project_director"){
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operators name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone, project_director) 
                VALUES (?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sss", $fullname, $phone,  $project_director_id);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "project_director" )  {
                    
                    // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone, project_director) 
                VALUES (?, ?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sssss",$user_id, $description,$fullname,$phone,$project_director_id );

                // Execute the prepared statement
                $res = $stmt->execute();
                    print_r($res);
                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by project_director'
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
            }
            }elseif($role == "admin"){ 
                $fullname = mysqli_real_escape_string($conn, $userInput['fullname']);
                $user_id = mysqli_real_escape_string($conn, $userInput['user_id']);
                $operator_name = mysqli_real_escape_string($conn, $userInput['operator_name']);
                $phone = mysqli_real_escape_string($conn, $userInput['phone']);
                $supervisor_id = mysqli_real_escape_string($conn, $userInput['supervisor_id']);
                $project_manager_id = mysqli_real_escape_string($conn, $userInput['project_manager_id']);
                $project_director_id = mysqli_real_escape_string($conn, $userInput['project_director_id']);
                if (empty(trim($role))) {
                    return error422('Enter your role');
                } elseif (empty(trim($user_id))) {
                    return error422('Enter the user_id');
                } elseif (empty(trim($operator_name))) {
                    return error422('Enter the operators name');
                } elseif (empty(trim($fullname))) {
                    return error422('Enter your fullname');
                } elseif (empty(trim($phone))) {
                    return error422('Enter your phone');
                } elseif (empty(trim($project_manager_id))) {
                    return error422('Enter your project manager id');
                } elseif (empty(trim($project_director_id))) {
                    return error422('Enter your project director');
                } else {

                // Prepare the SQL query
                $query = "INSERT INTO records (fullname, phone, admin        VALUES (?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "sss", $fullname, $phone,  $project_director_id);

                // Execute the prepared statement
                $result = $stmt->execute();

                print_r($result);
                if ($result  & $role == "admin" )  {
                    
                    // send log data 
                // Prepare log data
                $description = "$operator_name created a new record";

                // Prepare the SQL query
                $query = "INSERT INTO records_activity_log (user, description, fullname, phone,) 
                VALUES (?, ?, ?, ?)";

                // Initialize the prepared statement
                $stmt = $conn->prepare($query);

                // Bind parameters to the prepared statement
                $stmt->bind_param(
                "ssss",$user_id, $description,$fullname,$phone );

                // Execute the prepared statement
                $res = $stmt->execute();
                    print_r($res);
                    $data = [
                        'status' => 201,
                        'message' => 'records added successfully by admin'
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
