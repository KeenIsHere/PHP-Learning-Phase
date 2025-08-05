<?php


if (
    isset(
    $_POST['email'],
    $_POST['password'],
    $_POST['full_name']
)
) {

} else {
    echo json_encode([
        "success" => false,
        "message" => "email, password and full_name are required",
        // "data" => [
        //     "email" => $_POST['email'],
        //     "password" => $_POST['password'],
        //     "full_name" => [
        //         "suraj",
        //         "subedi"
        //     ]
        // ]
    ]);
}
