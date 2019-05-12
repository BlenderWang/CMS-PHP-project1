<?php
    include_once('../includes/connection.php');
    session_start();
    global $pdo;
    // $errors = array();
    // if(isset($errors)) {
    //     print_r($errors);
    // }else{
    //     $errors = array();
    //     print_r("not set");
    // }

    if(isset($_POST['username']) && isset($_POST['password'])) {
        $errors = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(strlen($password) < 3) {
            array_push($errors, "Password should be longer than 3 characters");
        }
        if(strlen($username) < 3) {
            array_push($errors, "Username should be longer than 3 characters");
        }

        if(sizeof($errors) > 0) {
            //$errors = array();
        }else{
            $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $query->execute([":username" => $_POST['username']]);
            $query->fetchAll();

            $num = $query->rowCount();
            // echo $num;
            if($num > 0) {
                $error = 'Username has existed. Please choose another one!';
            }else {
                $query = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $query->execute([
                    ":username" => $_POST['username'],
                    ":password" => password_hash($_POST['password'], PASSWORD_BCRYPT)
                ]);
                // echo 'User created!';
                $_SESSION['logged_in'] = true;

                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute([":username" => $_POST['username']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $user['username'];

                header('Location: dashboard.php');
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="full-screen-container">
        <div class="login-container">
            <h3 class="login-title">Welcome</h3>
            <?php if(isset($errors)) { ?>
                <?php foreach($errors as $error) { ?>
                    <small style="color: indianred;"><?php  echo $error; ?></small><br/>
                <?php } ?>
            <?php } ?>
            <form action="index.php" method="post">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off">
                </div>

                <button type="submit" name="signup-submit" class="login-btn">Sign Up</button>
                <a href="../index.php" class="signup-link">Log in here</a>
            </form>
        </div>
    </div>
</body>
</html>
