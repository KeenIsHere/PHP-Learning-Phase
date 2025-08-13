<?php


// sudo chmod -R 777 /path/to/your/upload/directory

try {

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

    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];




    if (
        !isset(
        $_POST['product_name'],
        $_POST['price'],
        $_POST['description'],
        $_POST['category_id'],
        $_FILES['image']
    )
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'product_name, price, description, category_id and image are required'
        ]);
        die();
    }


    $image = $_FILES['image'];

    $image_size = $image['size'];
    $image_tmp_name = $image['tmp_name'];
    $image_name = $image['name'];

    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($image_ext, $allowed_ext)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid image extension, should be jpg, jpeg, png, gif, webp'
        ]);
        die();
    }

    if ($image_size > 1024 * 1024 * 5) {
        echo json_encode([
            'success' => false,
            'message' => 'Image size should be less than 5MB'
        ]);
        die();
    }

    $image_name = uniqid() . '.' . $image_ext;

    $image_path = 'uploads/' . $image_name;

    $is_moved = move_uploaded_file($image_tmp_name, $image_path);

    if (!$is_moved) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload image'
        ]);
        die();
    }

    $sql = "INSERT INTO products (product_title, price, description, category_id, image_url) VALUES ('$product_name', '$price', '$description', '$category_id', '$image_path')";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add product'
        ]);
        die();
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product added successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}





