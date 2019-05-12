<?php
    try {
        $host = 'localhost';
        $db   = 'journal';
        $user = 'root';
        $pass = 'abc123';
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $pdo = new PDO($dsn, $user, $pass);
    }catch(PDOException $e) {
        exit('Database error.');
    }
?>