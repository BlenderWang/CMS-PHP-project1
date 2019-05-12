<?php
    session_start();

    include_once('../includes/connection.php');

    global $pdo;

    if(isset($_SESSION['logged_in']) && isset($_SESSION['userID'])) {
        // display index
        $query = $pdo->prepare("SELECT * FROM entries WHERE userID = :userID");
        $query->execute([":userID" => $_SESSION['userID']]);
        $journals = $query->fetchAll();
?>

<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <nav>
            <a href="#" id="logo"><i class="fas fa-book"></i></a>
            <ul>
                <li><a href="add.php">Add New Entry</a></li>
                <li><a href="remove.php">Remove Entry</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>

        <header>
            <h3>Welcome <span><?php echo $_SESSION['username']; ?></span></h3>
        </header>

        <main>
            <div class="jounal-container">
                <ol>
                    <?php foreach($journals as $journal) { ?>
                        <li>
                            <a href="index.php?id=<?php echo $journal['entryID']; ?>" class="title">
                                <span><?php echo $journal['title']; ?></span>
                            </a>
                            <small>
                                - posted <?php echo $journal['createdAt'] ?>
                            </small>
                            <p class="journal-content"><?php echo $journal['content']; ?></p>
                        </li>
                    <?php } ?>
                </ol>
            </div>
        </main>
    </div>
</body>
</html>

<?php
    }
?>