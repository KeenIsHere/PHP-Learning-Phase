<?php
include 'connection.php';





function getUserIdByToken($token)
{
    global $con;

    $sql = "SELECT user_id FROM tokens where token ='$token'";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['user_id'];
    }

    return null;
}


function isAdmin($token)
{
    global $con;

    $user_id = getUserIdByToken($token);

    if (!$user_id) {
        return false;
    }

    $sql = "SELECT * FROM users where user_id ='$user_id'";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['role'] == 'admin';
    }

    return false;
}
