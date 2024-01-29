<?php
session_start();
require_once 'common/checkAuth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_FILES['image'] ?? '';
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';
    $errors = [];
    // Check if any required field is empty
    if (empty($title)){
        $errors['title'] = 'Title can not be empty';
    }
    if (empty($description)){
        $errors['description'] = 'Description can not be empty';
    }
    if (empty($price)) {
        $errors['price'] ='Price is empty';

    }
    else if(!is_numeric($price)){
        $errors['price'] ='Price must be digit';

    }
    else if($price<=1500){
        $errors['price'] = 'Price must be more than 1500';
    }

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
        $errors['image'] = "File Should Be PNG, JPG, JPEG dor WEBP";
    }

    if(!empty($errors)){
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location: editGameForm.php?game_id=$id");
        exit;
    }
    else{
        require_once 'common/connect.php';

        $result = editGame($id, $title, $description, $category_id, $price, $image_name);

        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Your changes have been submitted for review by the moderator';
            header("Location: index.php");
        }

    }
}
?>
