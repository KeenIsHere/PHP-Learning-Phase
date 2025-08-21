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

    $sql = "SELECT * FROM product join category on product.category_id = category.category_id";

    $result = mysqli_query($con, $sql);

    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => 'Products fetched successfully',
        'data' => $products
    ]);


} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}


