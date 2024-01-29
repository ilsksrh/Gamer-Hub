<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_id = $_POST['game_id'] ?? '';
    $user_id = $user['id'];
    $error = [];
    $result = addFavGame($game_id, $user_id);
    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Game was added to favorites';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Something went wrong!';
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>
