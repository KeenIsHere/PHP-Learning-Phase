<?php
// Include the database connection file
include("../helpers/connection.php");

// Check if the database connection was successful
// This ensures we can interact with the database before proceeding

/*
Login Related Code Logic:
Step 1: Check if required data is present in request "Email" And "Password"
Step 2: Check if user is registered > Error ("User not found")
Step 3: Verify the password
> Error ("Invalid Password")
> Need To Pass ("Password","Hashed Password")
> $user = mysqli_fetch_assoc($result) to get user data
> When ended fetching data returns None
> $hashed_password = $user["password"];
> password_verify() gives Boolean (True/False)
Step 4: If all steps are successful,
> Generate a token, $token = random_bytes(32);
> OR $token = bin2hex(random_bytes(32));
> Write Query inserting into DB "Insert Into token table with user_id and token"
> Return login success response with token (success: true, message: "Login successful", token: $token)
*/

try {
    // Step 1: Check if required data is present in request
    // Verify that both email and password are provided in the POST request
    if (
        isset(
            $_POST["email"],
            $_POST["password"]
        )
    ) {
        // Get the email and password from POST request
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Step 2: Check if user is registered in the database
        // Create SQL query to find user by email (using user_id as primary key)
        $sql = "SELECT * FROM users WHERE email = '$email'";
        
        // Execute the query to search for the user
        $result = mysqli_query($conn, $sql);

        // Check if the database query was successful
        if (!$result) {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "Database query failed",
            ]);
            exit();
        }

        // Count how many rows were returned (should be 1 if user exists, 0 if not)
        $count = mysqli_num_rows($result);

        // If no user found with this email, return error
        if ($count == 0) {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "User not found",
            ]);
            exit();
        }

        // Step 3: Get user data and verify password
        // Fetch the user data from the result set
        $user = mysqli_fetch_assoc($result);
        
        // Get the hashed password stored in database
        $hashed_password = $user["password"];

        // Verify the provided password against the hashed password
        // password_verify() returns Boolean (True if match, False if not)
        if (!password_verify($password, $hashed_password)) {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "Invalid Password",
            ]);
            exit();
        }

        // Step 4: If all steps are successful, generate token and create session
        // Generate a random token for the user session
        $token = bin2hex(random_bytes(32));
        
        // Get the user_id (primary key) for token storage
        $user_id = $user["user_id"];

        // Insert the token into the tokens table to track user session
        $token_sql = "INSERT INTO tokens (user_id, token) VALUES ('$user_id', '$token')";
        
        // Execute the token insertion query
        $token_result = mysqli_query($conn, $token_sql);

        // Check if token was successfully inserted
        if (!$token_result) {
            echo json_encode([
                "success" => false,
                "status" => "error",
                "message" => "Failed to create user session",
            ]);
            exit();
        }

        // Return successful login response with token and user data
        echo json_encode([
            "success" => true,
            "status" => "success",
            "message" => "Login successful",
            "token" => $token,
            "data" => [
                "user_id" => $user_id,
                "email" => $user["email"],
                "full_name" => $user["full_name"],
                "role" => $user["role"]
            ]
        ]);
        exit();

    } else {
        // If required data (email or password) is missing from request
        echo json_encode([
            "success" => false,
            "status" => "error",
            "message" => "Required data is missing. Email and Password are required.",
        ]);
        exit();
    }

} catch (Exception $e) {
    // Catch any unexpected errors and return error response
    echo json_encode([
        "success" => false,
        "status" => "error",
        "message" => $e->getMessage(),
    ]);
}
?>