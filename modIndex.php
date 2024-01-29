<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
$user = $_SESSION['user'];
$games = getPendingGames($user['id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Shop Homepage</title>
    <style>
        .success {
            color: #00fc38;
            margin-bottom: 20px;
        }
        .mainError {
            color: red;
            margin-bottom: 20px;
        }
        .success,
        .mainError {
            font-size: 1.2em;
        }


    </style>
</head>

<body>
<?php require_once 'common/head.php' ?>
<!-- Navigation-->
<?php require_once 'common/header.php'; ?>


<!-- Your HTML code with the form -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
                    <div class="success">
                        <?= $_SESSION['message'] ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'error'): ?>
                    <div class="mainError">
                        <?= $_SESSION['message'] ?>
                    </div>
                <?php endif; ?>
                <?php
                unset($_SESSION['status']);
                unset($_SESSION['errors']);
                unset($_SESSION['message']);
                ?>
                <div class="col-lg-8">
                    <?php if(empty($games)): ?>
                        <h3>There are no job for you now! </h3>
                    <?php endif; ?>

                    <?php foreach($games as $game): ?>
                        <!-- Blog post-->
                        <div class="card mb-4">
                            <a href="#!"><img class="card-img-top" src="http://localhost/FridayProject/images/gamesImages/<?=$game['image']?>" alt="Image" /></a>
                            <div class="card-body">
                                <div class="small text-muted"><?= $game['created_at'] ?></div>
                                <h2 class="card-title h4"><?= $game['title'] ?></h2>
                                <h6>Author: <?= $game['name'] ?></h6>
                                <p class="card-text"><?= $game['description'] ?></p>
                                <p class="card-text">Price: <?= $game['price'] ?> tenge</p>
                                <div class="button-row">
                                <form action="approveGame.php" method="post" class="approve-game-form">
                                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                    <button type="submit" class="btn btn-success btn-circle" name="approve_game_btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="rejectGame.php" method="post" class="reject-game-form">
                                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-circle" name="reject_game_btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <div style="margin-bottom: 20px;"></div> <!-- Space after the form -->
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>