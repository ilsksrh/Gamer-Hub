<?php
session_start();
require_once '../common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'] ?? '';
    $newName = $_POST['newName'] ?? '';
    $oldName = $_POST['oldName'] ?? '';
    $errors = [];

    if(empty($newName)){
        $errors['newName'] = 'Please enter new name';
    }
    if ($newName == $oldName) {
        $errors['newName'] = 'Error. The same name!';
    }

    if(!empty($errors)){
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header("Location: categoriesManageForm.php?catId=$category_id");
        exit;
    }
    else{
        $result = updateCategory($newName, $category_id);
        if($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Category updated successfully';
        }
        else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Something went wrong!';
        }
        header('Location: categoriesManageForm.php');
        exit;
    }
}