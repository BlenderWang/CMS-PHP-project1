<?php
    session_start();

    include_once('../includes/connection.php');

    if(isset($_SESSION['logged_in']) && isset($_SESSION['userID'])) {
        // display add journal page
        if(isset($_POST['title'], $_POST['content'])) {
            $title = $_POST['title'];
            $content = nl2br($_POST['content']);
            $createdAt = date("Y-m-d H:i:s");
            $userid = $_SESSION['userID'];

            if(empty($title) || empty($content)) {
                $error = 'All fields are required!';
            }else {
                $query = $pdo->prepare("INSERT INTO entries (title, content, createdAt, userID) VALUES (?, ?, ?, ?)");
                $query->bindValue(1, $title);
				$query->bindValue(2, $content);
				$query->bindValue(3, $createdAt);
                $query->bindValue(4, $userid);

                $query->execute();
                print_r($query);

                header('Location: dashboard.php');
            }
        }
?>

<html>
<head>
    <title>PHP CMS</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <nav>
            <a href="dashboard.php" id="logo"><i class="fas fa-book"></i></a>
            <a href="dashboard.php" class="back">&larr; Back</a>
        </nav>

        <header>
            <h3>Add New Entry</h3>
            <?php if(isset($error)) { ?>
                <small style="color: crimson;"><?php echo $error; ?></small>
            <?php } ?>
        </header>

        <main>
            <div class="jounal-container">
                <form action="add.php" method="post" autocomplete="off">
					<input type="text" name="title" placeholder="title" />
					<br />
					<br />
					<br />
					<textarea rows="20" cols="60" placeholder="content" name="content"></textarea>
					<br />
					<br />
					<input type="submit" value="Add New Entry" class="btn" />
				</form>
            </div>
        </main>
    </div>
</body>
</html>
<?php
    }else {
        header('Location: ../index.php');
    }
?>