<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];

    if (empty($email)) {
        $errors['email'] = 'The email is empty';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['email'] = "Invalid email format";
    }
    if (empty($name)) {
        $errors['name'] = 'The name is empty';
    }

    if (empty($password)) {
        $errors['password'] = 'The password is empty';
    } else {
        if (strlen($password) < 6) {
            $errors['password'] = "Password must contain at least 6 characters.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors['password'] = "Add at least one lowercase letter in password.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors['password'] = "Add at least one uppercase letter in password.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors['password'] = "Add at least one digit in password.";
        }
        if ($password !== $confirmPassword) {
            $errors['password'] = "Passwords do not match.";
        }
    }

    $avatar = $_FILES['avatar'];
    $time = time();
    $avatar_name = $time . $avatar['name']; // $avatar_name = 1231232134girl.png
    $avatar_tmp_name = $avatar['tmp_name']; // $avatar_tmp_name = C:\xampp\tmp\phpAE3C.tmp
    $avatar_destination_path = 'images/avatars/' . $avatar_name;

    $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
    $extention = explode('.', $avatar_name); // [1231232134girl, png]
    $extention = end($extention); // $extention = 'png'

    if (in_array($extention, $allowed_files)) {
        if ($avatar['size'] < 1000000) {
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
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location:registerform.php');
    } else {
        require_once 'common/connect.php';
        $result = registerUser($email, $password, $name, $avatar_name);
        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'You have registered successfully';
            header('Location: loginform.php');
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['errors'] = ['email' => 'This email is in use'];
            header('Location: registerform.php');
        }
    }
}
?>