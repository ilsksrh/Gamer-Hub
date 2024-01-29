<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredPassword = $_POST['inputPassword'] ?? '';
    $user = $_SESSION['user'];
    $errors = [];
    $id = $_POST['game_id'] ?? '';

    if (empty($enteredPassword)) {
        $errors['inputPassword'] = 'Please fill password';
    } else {
        if (md5($enteredPassword) !== $user['password']) {
            $errors['inputPassword'] = 'Password is incorrect.';
        }
    }
    if (!empty($errors)) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location:deleteGameForm.php?game_id=$id");
        exit;
    } else {
        $result = deleteGame($id);
        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Game deleted successfully.';
            header("Location: index.php");
            exit();
        }
    }
}
?>