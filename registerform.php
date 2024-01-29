<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php
$hasErrors = false;
if(isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
}
?>

<form method="POST" action="register.php" class="form-container" enctype="multipart/form-data">
    <h2>Registration</h2>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="success">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password">
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password">
    </div>
    <div class="field-group">
        <label for="avatar">User Avatar</label>
        <input type="file" id="avatar" name="avatar" />
    </div>
    <div class="form-group">
        <input type="submit" value="Register">
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
                <h1>Welcome!</h1>
                <p>Register with your personal details to use all of site features</p>

            </div>
        </div>
    </div>


    <p>Already registered? <a href="loginform.php">Login here</a></p>
</form>
</body>
</html>
