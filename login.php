<?php
session_start();
require_once 'common/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']) ? true : false;
    $errors = [];
    if (empty($email)) {
        $errors[] = "Email is empty";
    }
    else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['email'] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is empty";
    }

    if ($errors) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        $_SESSION['email'] = $email;
        header('Location: loginform.php');
    }
    else {
        $user = loginUser($email, $password);

        if($user){
            if ($remember_me) {
                setcookie('remembered_email', $email, time() + (7 * 24 * 60 * 60), '/');
            }
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'You have logged in';
            $_SESSION['user'] = $user;
            $_SESSION['name'] = $user['name'];
            header('Location: index.php');
        }
        else{
            $_SESSION['status'] = 'mainError';
            $_SESSION['message'] = 'No user with this email and password';
            header('Location: loginform.php');
        }
        exit();
    }
}
?>