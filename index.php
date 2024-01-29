<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';
$categories = getCategories();
$cat_id = $_GET['cat_id'] ?? '';
$search = $_POST['search'] ?? '';


if ($search) {
    $games = searchGames($search);
} else {
    if (isset($_GET['show_favorites']) && $_GET['show_favorites'] == '1') {
        $favGames = getFavGames($user['id']);
        $games = $favGames;
    } else {
        if ($cat_id) {
            $games = getGames($cat_id);
        } else {
            $games = getGames();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Shop Homepage</title>

    <link rel="stylesheet" type="text/css" href="css/indexCSS.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Black+Ops+One&family=Kdam+Thmor+Pro&family=Montserrat:wght@200;300&family=Press+Start+2P&family=Teko&display=swap');

        body{
            font-family: "Kdam Thmor Pro", Sans-Serif;
        }
        .success {
            color: #00fc38;
            margin-bottom: 20px;
        }
        .card-body form {
            display: inline;
        }
    </style>
</head>
<body>
<?php require_once 'common/head.php'?>

<!-- Navigation-->
<?php require_once 'common/header.php'?>
<!-- Header-->
<header class="bg-dark py-5" style="background-image: url('images/background/shogun.jpg'); background-size: cover; background-position: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome, <?php echo $user['name']; ?></h1>
            <p class="lead fb-normal text-white-50 mb-0">Create your own world</p>
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
                <div class="success">
                    <?= $_SESSION['message'] ?>
                    <i class="fa-regular fa-circle-xmark" onclick = "this.parentElement.remove()" style="color: #f4f4f4"></i>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'error'): ?>
                <div class="error">
                    <?= $_SESSION['message'] ?>
                    <i class="fa-regular fa-circle-xmark" onclick = "this.parentElement.remove()" style="color: #f4f4f4"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <?php if(empty($games)): ?>
                    <h3>There are no such games yet! </h3>
                <?php endif; ?>

                <?php foreach($games as $game): ?>
                    
                    <!-- Blog post-->
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="http://localhost/FridayProject/images/gamesImages/<?=$game['image']?>" alt="Image" /></a>
                        <div class="card-body">
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
                            <h2 class="card-title h4"><?= $game['title'] ?></h2>
                            <h6>Author: <?= $game['name'] ?></h6>
                            <p class="card-text"><?= $game['description'] ?></p>
                            <p class="card-text">Price: <?= $game['price'] ?> tenge</p>

                            <a class="btn btn-primary btn-custom" href="oneGame.php?game_id=<?= $game['id'] ?>">More →</a> 

                            <form onsubmit="return confirm('Item added to cart. Proceed to view your cart?')" action="addToCart.php" method="post">
                            <input type="hidden" name="id" value="<?= $game['id'] ?>">
                            <button type="submit" class="btn btn-primary btn-custom">Add to cart →</button>
                            </form>

                            <?php if($game['user_id'] == $user['id']): ?>
                           <a class="btn btn-warning btn-custom" href="editGameForm.php?game_id=<?= $game['id'] ?>"style="background-color: white; color: white;">Edit →</a>

                        <a class="btn btn-danger btn-custom" href="deleteGameForm.php?game_id=<?= $game['id'] ?>" style="background-color: white; color: black;">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
                        <?php require_once 'common/sidebar.php'?>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                        <li class="page-item"><a class="page-link" href="#!">2</a></li>
                        <li class="page-item"><a class="page-link" href="#!">3</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                        <li class="page-item"><a class="page-link" href="#!">15</a></li>
                        <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                    </ul>
                </nav>

                </div>
            </div>
        </div>
    </div>
</section>
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
