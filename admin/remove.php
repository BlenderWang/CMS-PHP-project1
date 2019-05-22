<?php
    session_start();

    include_once('../includes/connection.php');

    global $pdo;

    if(isset($_SESSION['logged_in']) && isset($_SESSION['userID'])) {
        $query = $pdo->prepare("SELECT * FROM entries WHERE userID = :userID");
        $query->execute([":userID" => $_SESSION['userID']]);

        $journals = $query->fetchAll();

        // display remove entry page
        if(isset($_GET['entryID'])) {
            $entryid = $_GET['entryID'];

            $query = $pdo->prepare('DELETE FROM entries WHERE entryID = ?');
            $query->bindValue(1, $entryid);
            $query->execute();

            header('Location: remove.php');
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
            <h3>Remove Entry</h3>
        </header>

        <main>
            <div class="jounal-container">
                <h5>Scoll down the list and select one entry to remove.</h5>
                <form action="remove.php" method="get">
                    <select name="entryID" id="" onchange="this.form.submit();">
                        <option value="default">Click on the entry to remove</option>
                        <?php foreach($journals as $journal) { ?>
                            <option value="<?php echo $journal['entryID']; ?>"><?php echo $journal['title']; ?></option>
                        <?php } ?>
                    </select>
				</form>
            </div>
        </main>
    </div>
</body>
</html>

<?php
    }else {
        header('Location: index.php');
    }
?>