<?php


$dsn='mysql:host=localhost;dbname=bd_sae;charset=utf8';
$dbuser='Raphael';
$dbpassword='1234';

try {
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo 'Connection failed : '.$e->getMessage();
}