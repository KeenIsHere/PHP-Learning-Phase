<?php

try {

    include 'helpers/auth.php';

    if (!isset($_POST['token'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Token is required'
        ]);
        die();
    }

    $user_id = getUserIdByToken($_POST['token']);

    if (!$user_id) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid token'
        ]);
        die();
    }

    $sql = "SELECT * FROM categories";

    $result = mysqli_query($con, $sql);

    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => 'Categories fetched successfully',
        'data' => $categories
    ]);


} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}


