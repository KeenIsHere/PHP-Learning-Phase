<?php 

include("../connection.php");
// Check if the connection was successful

//registration related codes/logics 
/* 

Step 1: check if required data is present in request 
Step 2: Check if user is already registred
Step 3: Encrypt the password
Step 4: Insert user data into database
Step 5: If all steps are successful, return success response
Step 6: If any step fails, return error response

Login Realted Codes

Step 1: Check if required data is present in request "Email" And "Password"
Step 2: Check if user is registered > Error ("User not found")
Step 3: Verify the password 
> Error ("Invalid Password") 
> Need To Pass ("Password","Hassesd Password")
> $user mysqli-fetch-assoc($result) to get user data When Ended Fetching data Returns None
$hassed_password = $user["password"];
Gives In Boolen (True:Fales)
Step 4: If all steps are successful, 
> Generate a token,  $token = random_bytes(32); 
OR  $token = bin2hexrandom_bytes(32));
> Write Query inserting into DB and  "Insert Into token table with user_id and token"
> Return login success response with token (success: true , message: "Login successful", token: $token)

*/

/*
Basic HTTP Methods for RESTful API:
GET 
POST
PUT
DELETE 

*/

try{



if (
    isset(
        $_POST["email"],
        $_POST["password"],
        $_POST["full_name"],
        )
        ) {

            $email = $_POST ["email"] ;
            $password = $_POST ["password"] ;
            $full_name = $_POST ["full_name"] ;

            // $sql = "select * from users where email = ?";
            // $sql = $conn->prepare($sql);
            // $sql->bindParam("$", $email, PDO::PARAM_

            $sql = "select * from users where email = '$email'";

            $result = mysqli_query($conn, $sql);
            
            

            if (!$result) {
                echo json_encode([
                    "success" => false,
                    "status" => "error",
                    "message" => "Database query failed",
                    "data" => []
                ]);
                exit();
            }

            $count = mysqli_num_rows($result);

            if ($count > 0) {
                echo json_encode([
                    "success" => false,
                    "status" => "error",
                    "message" => "User already exists",
                    "data" => [
                        "email" => $email,
                        "full_name" => $full_name
                    ]
                ]);
                exit();
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (email, password, full_name) VALUES ('$email', '$hashed_password', '$full_name')";

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo json_encode([
                    "success" => false,
                    "status" => "error",
                    "message" => "Failed to register query user",
                    "data" => []
                ]);
                exit();
            }

            echo json_encode([ 
                "success" => true,
                "status" => "success",
                "message" => "User registered successfully",
            ]);
            exit();

        }  else {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "Required data is missing",
            ]);
            exit();
        }
// Include the database connection file
    }
catch (Exception $e) {
    echo json_encode([
        "success"=> false,
        "status"=> $e->getMessage()
        ]);
}