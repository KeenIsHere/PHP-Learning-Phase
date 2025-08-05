<?php 

//registration related codes/logics 
/* 

Step 1: check if required data is present in request 
Step 2: Check if user is already registred
Step 3: Encrypt the password
Step 4: Insert user data into database
Step 5: If all steps are successful, return success response
Step 6: If any step fails, return error response
*/

/*
Basic HTTP Methods for RESTful API:
GET 
POST
PUT
DELETE 

*/



if (
    isset(
        $_POST["email"],
        $_POST["password"],
        $_POST["full_name"],
        )
        ) {

        }  else {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "Required data is missing",
                "data" => [
                    "email" => $_POST["email"],
                    "password"=> $_POST["password"],
                    "full_name" => $_POST["Krishna"]

                ]
            ]);
            exit();
        }
// Include the database connection file
