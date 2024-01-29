<?php
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    $_SESSION['status'] = 'mainError';
    $_SESSION['message'] = 'Unauthorized access';
    header("Location: ../loginform.php");
    exit();
}

$user = $_SESSION['user'];
?>
