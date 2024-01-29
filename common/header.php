    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Black+Ops+One&family=Kdam+Thmor+Pro&family=Montserrat:wght@200;300&family=Press+Start+2P&family=Teko&display=swap');
            body {
                font-family: 'Black Ops One', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #000000;
            }

            .navbar {
                background-color: #000000 !important;
            }

            .navbar-brand,
            .navbar-nav .nav-link,
            .navbar-toggler-icon,
            .bi-cart-fill {
                color: #ffffff !important;
                transition: color 0.4s;
            }
            .navbar-nav .nav-link:hover {
                color: #5d2f89!important;
            }
            .avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }
            .btn-outline-dark {
        border-color: #ffffff;
        color: #5d2f89 !important;
        transition: color 0.4s, border-color 0.4s;
        box-shadow: 0px 0px 10px 0px #5d2f89; 
    }

    .btn-outline-dark:hover {
        color: #ffffff !important;
        background-color: #24102e;;
        border-color: #ffffff; /
        box-shadow: 0px 0px 10px 0px #5d2f89; 
        transition: color 0.4s, background-color 0.4s, border-color 0.4s, box-shadow 0.4s; 
    }


        </style>
        <title>Shop Homepage</title>
    </head>
    <body>
    <?php
    require_once 'head.php';
    $user = $_SESSION['user'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">NOOB Gamer Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="addProductForm.php">Add new Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li><img src="http://localhost/FridayProject/images/avatars/<?=$user['avatar']?>" alt="Avatar" class="avatar" onclick="openModal()"></li>
                    <?php if($user['role'] == 'admin'):?>
                        <li><a class="btn btn-secondary" href="admin/index.php" style="margin-left: 20px ">Go to Admin Panel</a></li>
                    <?php endif; ?>
                    <?php if($user['role'] == 'moderator'):?>
                        <li><a class="btn btn-secondary" href="modIndex.php" style="margin-left: 20px ">Go to work</a></li>
                    <?php endif; ?>
                </ul>

                <div class="modal" id="avatarModal">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <img class="modal-content" id="img01">
                </div>


                <form action = "cartForm.php" class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                                Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    </body>
    </html>
    <script>
        function openModal() {
            var modal = document.getElementById('avatarModal');
            var img = document.querySelector('.avatar');
            var modalImg = document.getElementById('img01');
            modal.style.display = 'block';
            modalImg.src = img.src;
        }
        function closeModal() {
            var modal = document.getElementById('avatarModal');
            modal.style.display = 'none';
        }
    </script>
