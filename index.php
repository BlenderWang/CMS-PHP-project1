<?php
    session_start();

    include_once('includes/connection.php');

    global $pdo;

?>



<?php
    if(isset($_POST['username'])) {
        $username = $_POST['username'];

        if(empty($username)) {
            $error = 'All fields are required!';
        }else {
            $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $query->execute([":username" => $_POST['username']]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if(password_verify($_POST['password'], $user['password'])) {
                // user entered correct info
                $_SESSION['logged_in'] = true;
                // print_r($user);
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $user['username'];

                header('Location: admin/dashboard.php');
                exit();
            }else {
                $error = 'Incorrect password! Please try again.';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="full-screen-container">
        <div class="login-container">
            <h3 class="login-title">Welcome</h3>

            <?php if(isset($error)) { ?>
                <small style="color: indianred;"><?php echo $error; ?></small>
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

                <button type="submit" class="login-btn">Log In</button>

                <a href="admin/index.php" class="signup-link">Haven't registered yet?</a>
            </form>
        </div>
    </div>
</body>
</html>