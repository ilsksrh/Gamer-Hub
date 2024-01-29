 <?php
session_start();
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['game_id'] ?? '';
    $userId = $_SESSION['user']['id'];
    if ($gameId) {
        $deleted = deleteGameFromCart($gameId, $userId);
        if (!$deleted) {
            $_SESSION['success'] = 'error';
            $_SESSION['message'] = "Failed to delete the game from the cart.";
        }
        header("Location: cartForm.php");
    }
} 

