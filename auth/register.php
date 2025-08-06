<?php

include '../helpers/connection.php';


if (
    isset(
    $_POST['email'],
    $_POST['password'],
    $_POST['full_name']
)
) {




    $email = $_POST['email'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];

    // $sql = "select * from users where email = ?";
    // $stmt = $con->prepare($sql);
    // $stmt->bind_param("s", $email);
    // $stmt->execute();
    // $result = $stmt->get_result();

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

    if ($count > 0) {
        echo json_encode([
            "success" => false,
            "message" => "Email is already registered"
        ]);
        die();
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);



    $sql = "insert into users (email, password,full_name) values ('$email', '$hashed_password','$full_name')";


    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to register (query error)"
        ]);
        die();
    }

    echo json_encode([
        "success" => true,
        "message" => "User registered successfully"
    ]);
    die();
} else {
    echo json_encode([
        "success" => false,
        "message" => "email, password and full_name are required",

    ]);
    die();
}
