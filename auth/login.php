<?php

include '../helpers/connection.php';


if (
    isset(
    $_POST['email'],
    $_POST['password']
)
) {

    $email = $_POST['email'];
    $password = $_POST['password'];



    $sql = "select * from users where email = '$email'";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "error in query"
        ]);
        die();
    }

    $count = mysqli_num_rows($result);

    if ($count == 0) {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
        die();
    }


    $user = mysqli_fetch_assoc($result);

    $hashed_password = $user['password'];

    $is_password_correct = password_verify($password, $hashed_password);

    if (!$is_password_correct) {
        echo json_encode([
            "success" => false,
            "message" => "Wrong password"
        ]);
        die();
    }

    $token = bin2hex(random_bytes(32));

    $user_id = $user['user_id'];

    $sql = "insert into tokens (token, user_id) values ('$token', '$user_id')";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to insert token (query error)"
        ]);
        die();
    }

    echo json_encode([
        "success" => true,
        "message" => "User logged in successfully",
        "token" => $token
    ]);
    die();

} else {
    echo json_encode([
        "success" => false,
        "message" => "email and password are required",

    ]);
    die();
}
