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
            <!-- Information about Game Company -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-heading">About Our Game Company</h2>
                <p class="mb-4">Our company is fake. But we still have the best and the cheapest games so buy it!</p>
                <p class="mb-4">Our names are Sara and Yasmeen. We aree the champiionnsss tonighhtttt</p>
            </div>
        </div>
    </div>
</section>

    

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
