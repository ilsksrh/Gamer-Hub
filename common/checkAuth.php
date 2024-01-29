<?php
require_once 'connect.php';
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $banned_until = $user['banned_until'];
    $isBanExpired = isBanExpired($banned_until);
    if (!$isBanExpired) {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'Your account is temporarily banned.';
        header('Location: loginform.php');
        exit();
    }
}
else {
    $_SESSION['status'] = 'mainError';
    $_SESSION['message'] = 'First, you need to login';
    header("Location: loginform.php");
    exit();
}
?>
