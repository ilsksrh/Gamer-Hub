
        <!DOCTYPE html>
        <html>
        <head>
            <title>Profile</title>
            <link rel="stylesheet" type="text/css" href="css/profileCSS.css">
            <?php  require_once 'common/head.php';

                session_start();
                require_once 'common/checkAuth.php';
                require_once 'common/connect.php';
                $user = $_SESSION['user'];
                $user_id = $user['id'];
                $cart_items = getCart($user_id);
                $hasErrors = false;
                if(isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
                    $hasErrors = true;
                }
            ?>
            <style>
        
            @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Black+Ops+One&family=Kdam+Thmor+Pro&family=Montserrat:wght@200;300&family=Press+Start+2P&family=Teko&display=swap');
            body {
                font-family: 'Black Ops One', sans-serif;
                margin: 0;
                padding: 0;
                background-color: black;
                color: white; 
            }   

            </style>
        </head>
        <body>
        <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'error'): ?>
        <div class="error">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>
    
        <section class="h-100 gradient-custom">

            <div class="container py-5">
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Cart - <?php echo count($cart_items); ?> items</h5>
                            </div>
                            <div class="card-body">
                                <?php foreach ($cart_items as $item): ?>
                                <!-- Single item -->
                                <div class="row">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                            <!-- Image -->
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light" style="width: 200px;">
                                                <img src="http://localhost/FridayProject/images/gamesImages/<?=$item['image'];?>" class="w-100" style="height: 130px;" />
                                                <a href="#!">
                                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                                </a>
                                            </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <!-- Data -->
                                       <form action="deleteFromCart.php" method="post">
                                            <p><strong style="color: #0b0b0b"><?php echo $item['title']; ?></strong></p>
                                            <input type="hidden" name="id" value="<?= $item['game_id'] ?>">
                                            <button type="submit" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip" title="Remove item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                       </form>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <!-- Quantity -->
                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <button class="btn btn-primary px-3 me-2"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <div class="form-outline">
                                                <input id="form1" min="0" name="quantity" value="<?php echo $item['quantity']; ?>" type="number" class="form-control" />
                                                <label class="form-label" for="form1">Quantity</label>
                                            </div>

                                            <button class="btn btn-primary px-3 ms-2"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                </form>


                                        <!-- Price -->
                                        <p class="text-start text-md-center">
                                            <strong style="color: #0b0b0b"><?php echo $item['price']; ?> tenge</strong>
                                        </p>
                                        <!-- Price -->
                                    </div>
                                </div>
                                <!-- Single item -->

                                <hr class="my-4" />
                                <?php endforeach; ?>
                                <!-- Single item -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        
                    <!-- Summary -->
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="mb-0">Summary</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
            
                <?php
                $totalAmount = 0; 
                foreach ($cart_items as $item):
                    $totalAmount += $item['price'] * $item['quantity'];
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                    <?php echo $item['title']; ?>
                    <span><?php echo $item['price'] * $item['quantity']; ?> tenge</span>
                </li>
                <?php endforeach; ?>

                <!-- Total amount -->
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    Total
                    <span><strong><?php echo $totalAmount; ?> tenge</strong></span>
                </li>
            </ul>

            <!-- Button -->
            <button type="button" class="btn btn-success btn-lg btn-block btn-continue-shopping" onclick="window.location.href = 'index.php'"
    style="font-family: 'Black Ops One', sans-serif;
    padding: 9px 17px;
    font-size: 16px;
    background-color: #5d2f89;
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    transition: background-color 0.3s, transform 0.2s ease, color 0.3s;
    box-shadow: 0 0 10px #bd64f8;"
    onmousedown="this.style.transform='scale(0.96)'"
    onmouseup="this.style.transform='scale(1)'"
    onmouseout="this.style.transform='scale(1)'"
>
    Continue shopping
</button>



        </div>
    </div>

                    </div>
                </div>
            </div>
        </section>
        </body>
        </html>
