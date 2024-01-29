<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$categories = getCategories();

$hasErrors = false;

if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}

$title = $hasErrors ? ($_SESSION['title'] ?? '') : '';
$description = $hasErrors ? ($_SESSION['description'] ?? '') : '';
$category_id = $hasErrors ? ($_SESSION['category_id'] ?? '') : '';
$price = $hasErrors ? ($_SESSION['price'] ?? '') : '';
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
        .mainError {
            color: red;
            margin-bottom: 20px;
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
                <form action="addProduct.php" method="post" enctype="multipart/form-data">
                    <div class="form-group ">
                        <label for="imageId">Choose the image</label>
                        <input name="image" type="file" class="form-control-file" id="imageId">
                        <?php if ($hasErrors && isset($_SESSION['errors']['image'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['image'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="titleId">Game title</label>
                        <input name="title" type="text" class="form-control" id="gameId" value="<?= $title ?>">
                        <?php if ($hasErrors && isset($_SESSION['errors']['title'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['title'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="descriptionId">Game Description</label>
                        <textarea name="description" class="form-control" id="descriptionId" rows="4"><?= $description ?></textarea>
                        <?php if ($hasErrors && isset($_SESSION['errors']['description'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['description'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="categoryId">Select category</label>
                        <select name="category_id" class="form-control" id="categoryId">
                            <option value="">--Default--</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $category_id) ? 'selected' : '' ?>>
                                    <?= $cat['name_en'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($hasErrors && isset($_SESSION['errors']['category_id'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['category_id'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3 ">
                        <label for="price">Enter Price</label>
                        <input type="text" name="price" class="form-control" id="price" value="<?= $price ?>">
                        <?php if ($hasErrors && isset($_SESSION['errors']['price'])) : ?>
                            <p class="inputError"><?= $_SESSION['errors']['price'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary mt-3">Add</button>
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
