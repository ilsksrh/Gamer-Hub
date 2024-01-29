<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    $_SESSION['status'] = 'mainError';
    $_SESSION['message'] = 'You have logged out';
    header('Location: loginform.php');
    exit();
}
$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
require_once 'common/connect.php';

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>One post page</title>

    <?php require_once 'common/head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/profileCSS.css">
</head>
<body style="margin: 0; padding: 0; height: 100%;">

<?php require_once 'common/header.php'; ?>
<header class="bg-dark py-6" style="background-image: url('images/background/121.jpg'); background-size: cover; background-position: center; height: 100vh;">

    <!-- Page content-->
    <div class="container py-4">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">

                <h2>Welcome, <?php echo $user['name']; ?></h2>
                <p><span class="label">Email:</span> <?php echo $user['email']; ?></p>
                <p><span class="label">Role:</span> <?php echo $user['role']; ?></p>
                <form action="index.php" method="POST">
                    <input type="submit" value="Continue Shopping">
                </form>
                <form action="changePasswordForm.php" method="POST">
                    <input type="submit" value="Change Password">
                </form>
                <form action="editProfileForm.php" method="POST">
                    <input type="submit" value="Edit Profile">
                </form>
                <form method="POST" action="profile.php">
                    <input type="submit" name="logout" value="Logout">
                </form>

            </div>

            <!-- Avatar block
            <div class="col-lg-4">
                <div class="card mb-4">
                    Avatar styling
                    <img src="http://localhost/FridayProject/images/avatars/<?=$user['avatar']?>" alt="Avatar"
                        style="width: 400px; height: 400px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);"> -->
        </div>
    </div>
    </div>
    </div>
</header>
</body>
</html>