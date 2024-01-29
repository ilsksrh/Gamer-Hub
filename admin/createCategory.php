<?php
require_once 'checkAuthAdmin.php';
require_once '../common/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'] ?? '';
    $errors = [];
    $categories = getCategories();

    if (empty($category_name)) {
        $errors[] = 'Please enter the name of the new category';
    }
        else {
            foreach ($categories as $cat) {
                if ($cat['name_en'] == $category_name) {
                    $errors[] = 'This category already exists';
                    break;
                }
            }
        }


    if (!empty($errors)) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header('Location: categoriesManageForm.php');
        exit;
    } else {
        $result = addCategory($category_name);
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'You have added new category successfully';
        header('Location: categoriesManageForm.php');
    }
}
