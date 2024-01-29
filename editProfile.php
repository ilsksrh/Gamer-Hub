<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newAvatar = $_FILES['avatar'] ?? '';
    $newName = $_POST['name'] ?? '';
    $user = $_SESSION['user'];
    $errors = [];
    $email = $_POST['email'] ?? '';

    if (empty($newName)) {
        $errors['name'] = 'Please enter new name';
    }
    $time = time();
    $avatar_name = $time . $newAvatar['name'];
    $avatar_tmp_name = $newAvatar['tmp_name'];
    $avatar_destination_path = 'images/avatars/' . $avatar_name;

    $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
    $extention = explode('.', $avatar_name);
    $extention = end($extention);

    if (in_array($extention, $allowed_files)) {
        if ($newAvatar['size'] < 1000000) {
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
        } else {
            $errors['avatar'] = "File Size Too Big. Chose Less Than 1mb File..!";
        }
    } else {
        $errors['avatar'] = "File Should Be PNG, JPG, JPEG or WEBP";
    }

    if (!empty($errors)) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location: editProfileForm.php?email=$email");
        exit;
    } else {
        require_once 'common/connect.php';
        $result = editUser($email, $newName, $avatar_name);
        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['user']['name'] = $newName;
            $_SESSION['user']['avatar'] = $avatar_name;
            $_SESSION['message'] = 'Profile edited successfully.';
            header("Location: index.php");
            exit();
        }
    }
}
?>
