<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game_id = $_POST['id'] ?? '';
    $user_id = $user['id'];
    $error = [];
    $isGameInCart = checkIfGameInCart($game_id, $user_id);

    if ($isGameInCart) {
        $result = updateCartQuantity($game_id, $user_id);
    } else {
        $result = addToUserCart($game_id, $user_id);
    }
}

header("Location: cartForm.php");
