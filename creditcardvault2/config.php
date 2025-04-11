<?php
session_start();
$host = 'localhost';
$db = 'creditcardvault2';
$user = 'root';
$pass = ''; //use your own password if none use the default root123
$encryption_key = 'supersecretkey2025'; // Change this!

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
