<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
$hasErrors = false;
if(isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
?>

<div class="form-container">
    <h2> Password Change</h2>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="success">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>
    <form action="changePassword.php" method="POST">
        <div class="form-group">
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password">
        </div>

        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <div class="form-group">
            <input type="submit" value="Change Password">
        </div>
        <p><a href="profile.php">Go back</a></p>
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
    </form>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <h1>Welcome again!)</h1>
                <p>Please remember your password!</p>

            </div>
        </div>
    </div>


</div>
</body>
</html>