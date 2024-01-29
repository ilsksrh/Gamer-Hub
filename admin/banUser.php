<?php
session_start();
require_once '../common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    if (!empty($user_id)) {
        $result = banUser($user_id);
        if($result){
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'User banned successfully for 5 minutes';
            header('Location: usersManageForm.php');
        }
        else{
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'An error occurred while banning the user';
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'User ID is missing';
    }
    header('Location: usersManageForm.php');
    exit;
}