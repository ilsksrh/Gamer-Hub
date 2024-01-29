<?php
session_start();
require_once 'common/checkAuth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $game_id = $_POST['id'] ?? '';

    $errors = [];

    if (empty($comment)) {
        $errors['comment'] = 'Please enter your comment here!';
    }

    if (!empty($errors)) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location: oneGame.php?game_id=$game_id");
        exit;
    } else {
        require_once 'common/connect.php';
        $result = addComment($user_id, $game_id, $comment, $avatar = 'no-img.png');
        if($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'You have added a comment successfully';
            header("Location: oneGame.php?game_id=$game_id");
            exit;
        } else {
            $_SESSION['status'] = 'mainError';
            $_SESSION['message'] = 'Something went wrong while adding the comment!';
            header("Location: oneGame.php?game_id=$game_id");
            exit;
        }
    }
}
