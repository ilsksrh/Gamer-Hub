<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'common/connect.php';
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user = $_SESSION['user'];

    $errors = [];
    if (empty($old_password)){
        $errors[] = 'Please fill old password';
    }
    else {
        if (md5($old_password) !== $user['password']) {
            $errors['current_passw  ord'] = 'Incorrect old password';
        }
    }
    if (empty($new_password)){
        $errors[] = 'Please fill new password';
    }
    else{
        if (strlen($new_password) < 6) {
            $errors['password'] = "Password must contain at least 6 characters.";
        }
        if (!preg_match('/[a-z]/', $new_password)) {
            $errors['password'] = "Add at least one lowercase letter in password.";
        }
        if (!preg_match('/[A-Z]/', $new_password)) {
            $errors['password'] = "Add at least one uppercase letter in password.";
        }
        if (!preg_match('/[0-9]/', $new_password)) {
            $errors['password'] = "Add at least one digit in password.";
        }
    }
    if (empty($confirm_password)){
        $errors[] = 'Please fill password confirmation';
    }
    if (($new_password !== $confirm_password) && (!empty($confirm_password) && !empty($new_password))) {
        $errors[] = 'New password and confirm password do not match.';
    }

    if($old_password == $new_password){
        $errors[] = 'You must have different old and new passwords!';
    }

    if($errors){
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header('Location:changePasswordForm.php');
    }
    else {
        $password_updated = updatePassword($user['email'], $new_password);
        if ($password_updated) {
            $_SESSION['user']['password'] = md5($new_password);
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Password updated successfully.';
            header('Location: changePasswordForm.php');
            exit;
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'error updating';
            header('Location: changePasswordForm.php');
            exit;
        }
    }
}
?>


