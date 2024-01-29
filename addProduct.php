<?php
session_start();
require_once 'common/checkAuth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';
    $user_id = $_SESSION['user']['id'];

    $errors = [];
    $image_name = $image['name'];
    $image_destination_path = 'images/gamesImages/' . $image_name;
    $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
    $image_tmp_name = $image['tmp_name'];
    $extention = explode('.', $image_name);
    $extention = end($extention);
    if (in_array($extention, $allowed_files)) {
        if ($image['size'] < 1000000) {
            move_uploaded_file($image_tmp_name, $image_destination_path);
        } else {
            $errors['image'] = "File Size Too Big. Chose Less Than 1mb File..!";
        }
    } else {
        $errors['image'] = "File Should Be PNG, JPG, JPEG or WEBP";
    }
    if (empty($image)) {
        $errors['image'] = 'Please choose an image';
    }
    if (empty($title)) {
        $errors['title'] = 'Please write the title';
    }

    if (empty($description)) {
        $errors['description'] = 'Description field is empty';
    }

    if (empty($category_id)) {
        $errors['category_id'] = 'Choose the category';
    }

    if (empty($price)) {
        $errors['price'] = 'Price field is empty';
    } else {
        if (!is_numeric($price)) {
            $errors['price'] = 'Price must be a numeric value';
        } elseif ($price <= 1500) {
            $errors['price'] = 'Price must be more than 1500';
        }
    }


    if (!empty($errors)) {
        $_SESSION['status'] = 'error';
        $_SESSION['image'] = $image_name;
        $_SESSION['errors'] = $errors;
        $_SESSION['title'] = $title;
        $_SESSION['description'] = $description;
        $_SESSION['category_id'] = $category_id;
        $_SESSION['price'] = $price;
        header('Location: addProductForm.php');
        exit;
    } else {
        require_once 'common/connect.php';
        $result = addGame($title, $description, $category_id, $user_id, $price, $image_name);
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Game was send to moderator successfully. Please wait his verdict.';
        header('Location: index.php');
    }
}
