<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$categories = getCategories();
$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
$game_id = $_GET['game_id'] ?? '';
if($game_id) {
    $game = getOneGame($game_id);
}

if($game['user_id'] != $user['id']){
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = "You can not edit someone's game";
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Shop Homepage</title>
    <style>
        p.inputError {
            margin-top: 3px;
            color: red;
        }
        label {
            color: white;
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
                <form action="editGame.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $game['id'] ?>">
                    <div class="form-group mt-3">
                        <label for="imageId">Change Image</label>
                        <input name="image" type="file" class="form-control-file" id="imageId">
                        <?php if ($hasErrors && isset($_SESSION['errors']['image'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['image'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="titleId">Game title</label>
                        <input value = "<?=$game['title']?>" name="title" type="text" class="form-control" id="gameId">
                        <?php if ($hasErrors && isset($_SESSION['errors']['title'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['title'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="descriptionId">Game Description</label>
                        <textarea name="description" class="form-control" id="descriptionId" rows="4"><?= $game['description']?></textarea>
                        <?php if ($hasErrors && isset($_SESSION['errors']['description'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['description'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="categoryId">Select category</label>
                        <select name="category_id" class="form-control" id="categoryId">
                            <?php foreach ($categories as $cat) : ?>
                                <option <?php echo $cat['id'] == $game['category_id'] ? 'selected' : '' ?> value="<?= $cat['id']?>"><?= $cat['name_en']?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($hasErrors && isset($_SESSION['errors']['category_id'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['category_id'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3 ">
                        <label for="price">Enter Price</label>
                        <input type="text" name="price" class="form-control" id="price" value="<?=$game['price']?>">
                        <?php if ($hasErrors && isset($_SESSION['errors']['price'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['price'] ?></p>
                        <?php endif; ?>
                    </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                            <a href="index.php" class="btn btn-secondary mt-3 ms-2">Cancel</a>
                        </div>

                </form>

                <div style="margin-bottom: 20px;"></div> <!-- Space after the form -->
            </div>
        </div>
    </div>
</section>

<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>

</html>