<?php

    $dsn = 'mysql:host=localhost;dbname=iteh';
    $username = "root";
    $password = "";

try{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    print_error_page(500, "Connection failed: ".$e->getMessage());
    phpinfo();
    die();
}