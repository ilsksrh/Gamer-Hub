<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'] ?? '';
    $game_id = $_POST['game_id'] ?? '';
    $user_id = $user['id'];
    $errors = [];
    if(empty($rating)){
        $errors['rating'] = "Please, choose the rating";
    }

    if(!empty($error)){
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header('Location:oneGame.php');
    }
    else{
        $result = rateGame($user_id, $game_id, $rating);
        if ($result) {
            header("Location: oneGame.php?game_id=$game_id");
        }
    }
}


