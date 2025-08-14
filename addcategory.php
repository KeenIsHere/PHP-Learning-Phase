<?php

try {
    include 'helpers/connection.php';
    include 'helpers/auth.php';

    if (!isset($_POST['token'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Token is required'
        ]);
        die();
    }

    if (!isAdmin($_POST['token'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized user'
        ]);
        die();
    }

    if (!isset($_POST['category_name'])) {
        echo json_encode([
            'success' => false,
            'message' => 'category_name is required'
        ]);
        die();
    }

    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO category (category_name) VALUES ('$category_name')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add category'
        ]);
        die();
    }

    echo json_encode([
        'success' => true,
        'message' => 'Category added successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        "status"=> $e->getMessage(),
        'message' => 'Catch Output Whats Wrong Find Out'
    ]);
}
