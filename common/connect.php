<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=recipe", "root", "");
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

function registerUser($email, $password, $name, $avatar = 'no-ava.jpg', $role = 'user')
{
    global $pdo;
    $queryObj = $pdo->prepare("INSERT INTO users(email, password, name, avatar, role) VALUES (:ue, :up, :un, :ua, :ur)");
    try {
        $queryObj->execute([
            'ue' => $email,
            'up' => md5($password),
            'un' => $name,
            'ur' => $role,
            'ua' => $avatar,
        ]);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}
function loginUser($email, $password){
    global $pdo;
    $queryObj = $pdo->prepare("select * from users where email = :ue and password = :up");

    $queryObj->execute([
        'ue' => $email,
        'up' => md5($password)
    ]);

    $user = $queryObj->fetch(PDO::FETCH_ASSOC);
    return $user;
}
function updatePassword($email, $newPassword) {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE users SET password = :up WHERE email = :ue");

    try {
        $queryObj->execute([
            'ue' => $email,
            'up' => md5($newPassword)
        ]);
        return true;
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
}

function addCategory($name_en) {
    global $pdo;
    $queryObj = $pdo->prepare("INSERT INTO categories (name_en) VALUES (:name)");
    try {
        $queryObj->execute([
            'name' => $name_en
        ]);
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
    return true;
}
function deleteCategory($category_id) {
    global $pdo;
    $queryObj = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    try {
        $queryObj->execute(['id' => $category_id]);
    } catch (PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
    return true;
}
function updateCategory($newName, $category_id) {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE categories SET name_en = :newName WHERE id = :id");
    try {
        $queryObj->execute(['newName' => $newName, 'id' => $category_id]);
    } catch (PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
    return true;
}


function getCategories(){
    global $pdo;
    $queryObj = $pdo->query("select * from categories");
    $categories = $queryObj->fetchAll(PDO::FETCH_ASSOC); #fetchAll to take many categories
    return $categories;
}

function addGame($title, $description, $category_id, $user_id, $price, $image = 'no-img.png'){
    global $pdo;
    $queryObj = $pdo->prepare("INSERT INTO games (title, description, category_id, user_id, price, created_at, image, status, moderator_id) VALUES (:gt, :gd, :gci, :gui, :gp, :ca, :gi, :gs, :gmid)");
    date_default_timezone_set('Asia/Almaty');
    $createdAt = date("Y-m-d H:i:s", time());
    $status = 'pending';
    $moderator_id = 17;
    try {
        $queryObj->execute([
            'gt' => $title,
            'gd' => $description,
            'gi' => $image,
            'gci' => $category_id,
            'gui' => $user_id,
            'gp' => $price,
            'ca' => $createdAt,
            'gs' => $status,
            'gmid' => $moderator_id,
        ]);
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
    return true;
}
function getPendingGames($moderator_id) {
    global $pdo;
    $queryObj = $pdo->prepare("SELECT games.*, users.name 
                  FROM games 
                  LEFT JOIN users ON games.user_id = users.id 
                  WHERE games.status = 'pending' AND moderator_id = :moderator_id");
    $queryObj->execute(['moderator_id' => $moderator_id]);
    $pendingGames = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $pendingGames;
}
function getGames($catId = null){
    global $pdo;
    if($catId){
        $queryObj = $pdo->prepare("SELECT games.*, users.name 
                  FROM games 
                  LEFT JOIN users ON games.user_id = users.id 
                  WHERE games.category_id = ? AND games.status = 'approved'");
        $queryObj->execute([$catId]);
    } else {
        $queryObj = $pdo->query("SELECT games.*, users.name 
                  FROM games 
                  LEFT JOIN users ON games.user_id = users.id 
                  WHERE games.status = 'approved'");
    }
    $games = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $games;
}

function approveGame($game_id) {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE games SET status = 'approved' WHERE id = :game_id");

    try {
        $queryObj->execute([
            'game_id' => $game_id
        ]);
        return true;
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
}

function rejectGame($game_id) {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE games SET status = 'rejected' WHERE id = :game_id");

    try {
        $queryObj->execute([
            'game_id' => $game_id
        ]);
        return true;
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
}


function getUsersWithGames(){
    global $pdo;

    $queryObj = $pdo->query("SELECT users.id, users.name, users.email, users.role, GROUP_CONCAT(games.title SEPARATOR ', ') AS created_games 
                             FROM users 
                             LEFT JOIN games ON users.id = games.user_id 
                             GROUP BY users.id");
    $users = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function searchGames($search){
    global $pdo;

    if($search){
        $queryObj = $pdo->prepare("select * from games where title like :search OR description like :search");
        $queryObj->execute(['search' => '%'.$search.'%']);
    }
    else{
        $queryObj = $pdo->query("select * from games");
    }

    $games = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $games;
}

function getOneGame($gameId){
    global $pdo;

    $queryObj = $pdo->prepare("select * from games where id = ?");
    $queryObj->execute([$gameId]);

    $game = $queryObj->fetch(PDO::FETCH_ASSOC);
    return $game;
}

function editGame($id, $title, $description, $category_id, $price, $image = 'no-img.png') {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE games SET title=:gt, description=:gd, 
                 category_id=:gci, price=:gp, image=:gim, status = 'pending' WHERE id=:gi");

    try {
        $queryObj->execute([
            'gt' => $title,
            'gd' => $description,
            'gci' => $category_id,
            'gp' => $price,
            'gim' => $image,
            'gi' => $id
        ]);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

function deleteGame($gameId){
    global $pdo;

    $queryObj = $pdo->prepare("delete from games where id = ?");
    $result = $queryObj->execute([$gameId]);

    return $result;
}

function editUser($email, $name, $avatar = 'no-ava.jpg') {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE users SET name=:gn, avatar=:ga WHERE email=:ge");
    try {
        $queryObj->execute([
            'gn' => $name,
            'ga' => $avatar,
            'ge' => $email,
        ]);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

function updateUserRole($id, $role) {
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE users SET role=:ur WHERE id=:ui");

    try {
        $queryObj->execute([
            'ur' => $role,
            'ui' => $id
        ]);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}


function rateGame($user_id, $game_id, $rating){
    global $pdo;
    $queryObj = $pdo->prepare("select * from user_game where user_id=:uid and game_id=:gid");

    try {
        $queryObj->execute([
            'uid' => $user_id,
            'gid' => $game_id,
        ]);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        return false;
    }

    $result = $queryObj->fetch(PDO::FETCH_ASSOC);

    if($result){
        $queryObj = $pdo->prepare("update user_game SET rating=:rating where user_id=:uid and game_id=:gid");
    }
    else{
        $queryObj = $pdo->prepare("insert into user_game(user_id, game_id, rating) values(:uid, :gid, :rating)");
    }

    try {
        $queryObj->execute([
            'uid' => $user_id,
            'gid' => $game_id,
            'rating' => $rating,
        ]);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        return false;
    }
    return true;//rated
}


function addComment($user_id, $game_id, $comment){
    global $pdo;

    $queryObj = $pdo->prepare("INSERT INTO comments (user_id, game_id, comment, created_at) VALUES (?, ?, ?, NOW())");

    try {
        $queryObj->execute([$user_id, $game_id, $comment]);
        return true;
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
}

function getComments($game_id = null){
    global $pdo;
    $queryObj = $pdo->prepare("SELECT comments.*, users.name AS user_name, users.avatar AS user_avatar FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.game_id = ?");
    $queryObj->execute([$game_id]);
    $comments = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}

//function admin change the role of any user
function banUser($user_id) {
    global $pdo;
    date_default_timezone_set('Asia/Almaty');
    $ban_duration = 5;
    $ban_until = date('Y-m-d H:i:s', strtotime("+{$ban_duration} minutes"));

    $queryObj = $pdo->prepare("UPDATE users SET banned_until = :ban_until WHERE id = :user_id");
    try {
        $queryObj->execute([
            'user_id' => $user_id,
            'ban_until' => $ban_until,
        ]);
        return true;
    } catch (PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
}

function isBanExpired($banned_until) {
    date_default_timezone_set('Asia/Almaty');
    if(strtotime($banned_until) > time()){
        return false;
    } else {
        return true;
    }
}

function addFavGame($game_id, $user_id) {
    global $pdo;
    $queryObj = $pdo->prepare("INSERT INTO user_favorites (game_id, user_id) VALUES (:game_id, :user_id)");

    try {
        $queryObj->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
        return true;
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
}

function removeFavGame($game_id, $user_id) {
    global $pdo;
    $queryObj = $pdo->prepare("DELETE FROM user_favorites WHERE game_id = :game_id AND user_id = :user_id");

    try {
        $queryObj->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
        return true;
    } catch(PDOException $ex) { 
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
}

function isGameFav($game_id, $user_id) {
    global $pdo;
    $queryObj = $pdo->prepare("SELECT * FROM user_favorites WHERE game_id = :game_id AND user_id = :user_id");

    try {
        $queryObj->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
        $result = $queryObj->fetch(PDO::FETCH_ASSOC);
        return ($result !== false);
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return false;
    }
}

function getFavGames($user_id) {
    global $pdo;
    $queryObj = $pdo->prepare("SELECT games.*, users.name
                               FROM games 
                               INNER JOIN user_favorites ON games.id = user_favorites.game_id 
                               INNER JOIN users ON users.id = user_favorites.user_id 
                               WHERE user_favorites.user_id = :user_id");

    try {
        $queryObj->execute(['user_id' => $user_id]);
        $favGames = $queryObj->fetchAll(PDO::FETCH_ASSOC);
        return $favGames;
    } catch(PDOException $ex) {
        echo "An error occurred: " . $ex->getMessage();
        return [];
    }
}

function addToUserCart($game_id, $user_id) {
    global $pdo;
    $query = $pdo->prepare("INSERT INTO user_cart (user_id, game_id, quantity) VALUES (:user_id, :game_id, 1)");

    try {
        $query->execute([
            'user_id' => $user_id,
            'game_id' => $game_id,
        ]);
        return true;
    } catch(PDOException $ex) {
        return false;
    }
}

function checkIfGameInCart($game_id, $user_id) {
    global $pdo;
    $query = $pdo->prepare("SELECT * FROM user_cart WHERE game_id = :game_id AND user_id = :user_id");

    try {
        $query->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
        return $query->rowCount() > 0;
    } catch(PDOException $ex) {
        return false;
    }
}

function updateCartQuantity($game_id, $user_id) {
    global $pdo;
    $query = $pdo->prepare("UPDATE user_cart SET quantity = quantity + 1 WHERE game_id = :game_id AND user_id = :user_id");

    try {
        $query->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
        return true;
    } catch(PDOException $ex) {
        return false;
    }
}

function getCart($user_id) {
    global $pdo;
    $query = $pdo->prepare("SELECT user_cart.id AS cart_id, games.id AS game_id, games.title, games.image, games.price, user_cart.quantity
                            FROM user_cart
                            JOIN games ON user_cart.game_id = games.id
                            WHERE user_cart.user_id = :user_id");
    try {
        $query->execute(['user_id' => $user_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
        // Handle the exception or log the error
        return [];
    }
}


function deleteGameFromCart($gameId, $userId) {
    global $pdo;
    $query = "DELETE FROM user_cart WHERE game_id = :game_id AND user_id = :user_id";

    try {
        $statement = $pdo->prepare($query);
        $statement->execute([
            'game_id' => $gameId,
            'user_id' => $userId
        ]);

        return true;
    } catch (PDOException $ex) {
        return false;
    }
}


?>