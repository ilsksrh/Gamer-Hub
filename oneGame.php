<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}

$user = $_SESSION['user'];
$categories = getCategories();
$game_id = $_GET['game_id'] ?? '';
$id = $_POST['id'] ?? '';

if ($game_id) {
    $game = getOneGame($game_id);
    $comments = getComments($game_id);
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>One post page</title>
    <?php require_once 'common/head.php' ?>
    <style>
        p.inputError {
            margin-top: 3px;
            color: red;
        }
        .success {
            color: green;
            margin-bottom: 20px;
        }

        .mainError {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php require_once 'common/header.php'; ?>

<!-- Page content-->
<div class="container py-4">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">

            <!-- Post content-->
            <article>
                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1"><?= $game['title'] ?></h1>
                    <!-- Post meta content-->
                    <div style="position: relative;">
                        <div style="font-size: 13px; color: white;"><?= $game['created_at'] ?></div>
                        <?php if(isGameFav($game['id'], $user['id'])): ?>
                            <form action="removeFav.php" method="post">
                                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                <button type="submit" style="background: none; border: none; padding: 0; font-size: 25px; color: red;">
                                    <i class="fa-solid fa-heart" style="position: absolute; top: 5px; right: 10px; font-size: 25px; color: red;"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="addFav.php" method="post">
                                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                <button type="submit" style="background: none; border: none; padding: 0; font-size: 25px; color: red;">
                                    <i class="fa-regular fa-heart" style="position: absolute; top: 5px; right: 10px; font-size: 25px; color: red;"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <!-- Post categories-->
                    <a class="badge bg-secondary text-decoration-none link-light" href="#!">Super Igra</a>
                    <a class="badge bg-secondary text-decoration-none link-light" href="#!">Playable</a>
                </header>
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
                    <div class="success">
                        <?= $_SESSION['message'] ?>
                        <i class="fa-regular fa-circle-xmark" onclick = "this.parentElement.remove()" style="color: #f4f4f4"></i>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'mainError'): ?>
                    <div class="mainError">
                        <?= $_SESSION['message'] ?>
                        <i class="fa-regular fa-circle-xmark" onclick = "this.parentElement.remove()" style="color: #f4f4f4"></i>
                    </div>
                <?php endif; ?>
                <!-- Preview image figure-->
                <figure class="mb-4"><img class="img-fluid rounded" src="http://localhost/FridayProject/images/gamesImages/<?=$game['image']?>" alt="..." /></figure>
                <!-- Post content-->
                <section class="mb-5">
                    <?= $game['description'] ?>
                </section>
            </article>
            <!-- Comments section--><!-- ... (previous HTML code) ... -->
            <form action="rate.php" method="post">
                <input type="hidden" name="game_id" value="<?=$game['id']?>">
                <select class="form-select" name="rating">
                    <option value="1">very bad (1)</option>
                    <option value="2">bad (2)</option>
                    <option value="3">ok (3)</option>
                    <option value="4">good (4)</option>
                    <option value="5">excellent (5)</option>
                </select>
                <button type="submit" class="btn btn-info my-3">Rate</button>
            </form>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form -->
                        <form action="addComment.php" method="post">
                            <textarea class="form-control" name="comment" rows="3"></textarea>
                            <?php if ($hasErrors && isset($_SESSION['errors']['comment'])) : ?>
                                <p class="inputError"><?= $_SESSION['errors']['comment'] ?></p>
                            <?php endif; ?>
                            <input type="hidden" name="id" value="<?= $game['id'] ?>">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-primary mt-2" style="margin-bottom: 10px">Add Comment</button>
                        </form>
                        <?php if (empty($comments)): ?>
                            <h3>There are no comments yet! </h3>
                        <?php else: ?>
                            <!-- Display existing comments -->
                            <?php foreach ($comments as $comment): ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <img src="http://localhost/FridayProject/images/avatars/<?= $comment['user_avatar'] ?>" alt="User Avatar" style="width: 100px; height: 100px;"/>
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold"><?= $comment['user_name'] ?></div>
                                        <div><?= $comment['created_at'] ?></div>
                                        <div><?= $comment['comment'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>
                </div>
            </section>

        </div>
            <?php require_once 'common/sidebar.php'; ?>
    </div>
</div>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>

<?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['message']);
?>
