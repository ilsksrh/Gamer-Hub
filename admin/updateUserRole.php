<?php
session_start();
require_once 'checkAuthAdmin.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newRole = $_POST['role'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $oldRole = $_POST['old_role'] ?? '';
    $errors = [];
    if ($newRole == $oldRole) {
        $errors['role'] = 'The selected role is already assigned to this user.';
        $errors['user_id'] = $user_id;
    }
    if(!empty($errors)){
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location: usersManageForm.php?user_id=$user_id");
        exit;
    }
    else{
        require_once '../common/connect.php';
        $result = updateUserRole($user_id, $newRole);
        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message']= 'Role updated successfully';
            $_SESSION['success']['user_id'] = $user_id;
            header("Location: usersManageForm.php");
            exit;
        }
        else{
            $_SESSION['status'] = 'error';
            $_SESSION['errors'] = 'Something went wrong';
            header("Location: usersManageForm.php?user_id=$user_id");
        }
    }
}
?>
