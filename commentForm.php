<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>One post page</title>
    <?php require_once 'common/head.php' ?>
</head>
<body>

<?php require_once 'common/header.php'; ?>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form -->
                        <form action="addComment.php" method="post">
                            <textarea class="form-control" name="comment" rows="3" placeholder="Join the discussion and leave a comment!"></textarea>
                            <input type="hidden" name="game_id" value="<?=$game['id']?>">
                            <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
                        </form>

                        <!-- Display existing comments -->
                        <?php foreach ($comments as $comment): ?>
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0"><img class="rounded-circle" src="<?= $comment['avatar'] ?>" alt="User Avatar" /></div>
                                <div class="ms-3">
                                    <div class="fw-bold"><?= $comment['user_name'] ?></div>
                                    <div><?= $comment['created_at'] ?></div>
                                    <div><?= $comment['content'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
