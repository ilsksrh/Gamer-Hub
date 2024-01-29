    <!DOCTYPE html>
    <?php
    require_once 'common/connect.php';
    $categories = getCategories();
    ?>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <style>
            body {
                background-color: #000;
                color: #fff;
            }

            .card {
                border: 1px solid rgba(255, 255, 255, 0.5);
                background-color: #000;
                border-radius: 10px;
                margin-bottom: 30px;
            }

            .card-header {
                background-color: rgba(255, 255, 255, 0.1);
                color: #fff;
                border-bottom: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 10px 10px 0 0;
            }

            .card-body {
                padding: 15px;
            }

            .input-group input {
                border: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 5px;
                color: #fff;
                background-color: rgba(255, 255, 255, 0.1);
            }

            .input-group button {
                background-color: rgba(255, 255, 255, 0.5); /* Полупрозрачный белый цвет */
                color: #fff;
                border: 1px solid rgba(255, 255, 255, 0.5);
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Тень */
            }

            .list-unstyled li a {
                color: #fff;
            }

            .card.mb-4 .card-body {
                color: #fff;
            }
            .list-unstyled li a:hover {
                color: #5d2f89 !important; 
            }
            button#button-search {
                background-color: #5d2f89;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.2s ease, color 0.3s;
                box-shadow: 0 0 0px #bd64f8;
                width: calc(100% + 4px);
                height: calc(100% + 4px);
            }
            button#button-search:hover {
                background-color: #7c4dff;
                color: #fff;
                transform: translateY(-5px);
                box-shadow: 0 0 20px #bd64f8;
            }
            button#button-search:active {
                transform: scale(0.96);
                animation: glow 0.5s infinite;
            }
            .heart-icon {
            color: red;
            margin-right: 5px;
        }
        .show-favorites-btn {
            color: red;
            font-size: 15px;
            display: flex;
            align-items: center;
        }
        </style>
    </head>
    <body>
    <!-- Side widgets-->
    <div class="col-lg-4">
        <!-- Search widget-->
        <div class="card mb-4">
            <div class="card-header">Search</div>
            <div class="card-body">
                <form action="index.php" method="post">
                    <div class="input-group">
                        <input name="search" class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Categories widget-->
        <div class="card mb-4">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $half = ceil(count($categories) / 2); // Calculate half the number of categories
                    $firstHalf = array_slice($categories, 0, $half);
                    $secondHalf = array_slice($categories, $half);
                    ?>
                    <div class="col-sm-6">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($firstHalf as $cat): ?>
                                <li><a href="index.php?cat_id=<?= $cat['id'] ?>"><?= $cat['name_en'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($secondHalf as $cat): ?>
                                <li><a href="index.php?cat_id=<?= $cat['id'] ?>"><?= $cat['name_en'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <form action="index.php" method="GET">
                    <input type="hidden" name="show_favorites" value="1">
                    <button type="submit" class="show-favorites-btn" style="font-size: 15px; margin-top: 10px;">
                    <i class="fa-regular fa-heart heart-icon"></i>Show Favorites
                    </button>
                </button>
                </form>
            </div>
        </div>
    </div>
    </body>
    </html>