<?php
session_start();
require_once '../common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'] ?? '';
    if (!empty($category_id)) {
        deleteCategory($category_id);
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Category deleted successfully';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Category ID is missing';
    }
    header('Location: categoriesManageForm.php');
    exit;
}