<?php
session_start();
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['game_id'] ?? '';
    if (!empty($gameId)) {
        rejectGame($gameId);
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Game rejected successfully';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid action';
    }
    header('Location: modIndex.php');
    exit;
}
?>
