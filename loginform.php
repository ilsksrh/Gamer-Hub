<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
    $email = $_SESSION['email'];
}
if (isset($_COOKIE['remembered_email'])) {
    $email = $_COOKIE['remembered_email'];
} else {
    $email = '';
}
?>


<form method="POST" action="login.php" class="form-container">
    <h2>Login</h2>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="success">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'mainError'): ?>
        <div class="mainError">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $email;?>">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" >
    </div>
    <div class="form-group-rem">
        <label for="remember_me">Remember Me</label>
        <input type="checkbox" name="remember_me">
    </div>
    <br>
    <div class="form-group">
        <input type="submit" value="Login">
    </div>
    <div class="error-container">
        <?php
        if ($hasErrors) {
            if (isset($_SESSION['errors'])) {
                $errors = $_SESSION['errors'];
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            }
        }
        unset($_SESSION['status']);
        unset($_SESSION['errors']);
        unset($_SESSION['message']);
        ?>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!)</h1>
            </div>
        </div>
    </div>

    <p>Not registered? <a href="registerform.php">Register here</a></p>

</form>
</body>
</html>
