<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <?php require_once 'common/header.php' ?>
    <?php require_once 'common/head.php' ?>
    <style>
        p.inputError {
            margin-top: 3px;
            color: red;
        }
    </style>
</head>
<body>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h3>If you want to delete game, please prove your identity:</h3>
                <form method="POST" action="deleteGame.php">
                    <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'mainError'): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['message'] ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="staticEmail" value="<?php echo $_SESSION['user']['email'] ?? ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword">
                            <?php if(isset($_SESSION['errors']['inputPassword'])): ?>
                                <p class="text-danger"><?= $_SESSION['errors']['inputPassword'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" name="game_id" value="<?php echo $_GET['game_id'] ?? ''; ?>">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger" name="delete_game">Delete</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<!-- ... Rest of your HTML code ... -->
</body>
</html>
<?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['message']);
?>
