<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>One post page</title>
    <link rel="stylesheet" type="text/css" href="css/editProfile.css">
    <?php require_once 'common/head.php' ?>
    <style>
        body {
            font-family: 'Black Ops One', sans-serif;
            height: 100vh;
            background-size: cover;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #000000, #2b1147, #482d60);
        }

        .navbar {
            background-color: #000000 !important;
        }

        .navbar-brand,
        .navbar-nav .nav-link,
        .navbar-toggler-icon,
        .bi-cart-fill {
            color: #ffffff !important;
            transition: color 0.4s;
        }

        .navbar-nav .nav-link:hover {
            color: #3e3e3e !important;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .btn-outline-dark {
            border-color: #ffffff;
            color: #3e3e3e !important;
            transition: color 0.4s;
        }

        .btn-outline-dark:hover {
            color: #ffffff !important;
        }

        .nav-item:hover .nav-link {
            color: #3e3e3e !important;
        }

        .profile-container {
            background-color: #000000;
            border-radius: 15px;
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #ffffff;
            text-align: center;
            position: relative;
            width: 700px;
            margin: 50px 20px;
        }

        .profile-form {
            margin-top: 20px;
            max-width: 490px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-form label {
            color: #ffffff;
            margin-bottom: 8px;
            display: block;
        }

        .profile-form h6 {
            color: #ffffff;
        }

        .profile-form input[type="file"] {
            border-radius: 8px;
            border: 1px solid #0b0b0b;
            margin-top: 8px;
        }

        .profile-form .btn-primary,
        .profile-form .btn-secondary {
            font-family: 'Black Ops One', sans-serif;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s ease, color 0.3s;
            box-shadow: 0 0 10px #bd64f8;
        }

        .profile-form .btn-primary {
            background-color: #5d2f89;
            color: #fff;
            border: none;
            margin-right: 15px;
        }

        .profile-form .btn-primary:hover {
            background-color: #7c4dff;
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 0 20px #bd64f8;
        }

        .profile-form .btn-primary:active {
            transform: scale(0.96);
            animation: glow 0.5s infinite;
        }

        .profile-form .btn-secondary {
            background-color: #fff;
            color: #5d2f89;
            border: none;
            margin-left: 15px;
        }

        .profile-form .btn-secondary:hover {
            background-color: #7c4dff;
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 0 20px #bd64f8;
        }

        .profile-form .btn-secondary:active {
            transform: scale(0.96);
            animation: glow 0.5s infinite;
        }

        .form-group mt-3 p.inputError {
            color: white;
        }
    
    
    </style>
</head>

<body>
<?php require_once 'common/header.php'; ?>
<!-- Page content-->
<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Blog entries-->
        <div class="col-lg-8">
            <div class="profile-container">
                <img src="http://localhost/FridayProject/images/avatars/<?= $user['avatar'] ?>" alt="Avatar"
                     class="avatar">
                <form action="editProfile.php" method="post" enctype="multipart/form-data" class="profile-form">
                    <input type="hidden" name="email" value="<?= $user['email'] ?>">
                    <div class="form-group mt-3">
                        <label for="imageId">Change Image:</label>
                        <input name="avatar" type="file" class="form-control-file" id="imageId">
                        <?php if ($hasErrors && isset($_SESSION['errors']['avatar'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['avatar'] ?></p>
                        <?php endif; ?>
                    </div>

                    <h6>Change Name:</h6>
                    <div class="form-group mt-3">
                        <input value="<?= $user['name'] ?>" name="name" type="text" class="form-control" id="name"
                               style="width: 390px;">
                        <?php if ($hasErrors && isset($_SESSION['errors']['name'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['name'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="profile.php" class="btn btn-secondary mt-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Additional content as needed -->
        </div>
    </div>
</div>
</body>

</html>
