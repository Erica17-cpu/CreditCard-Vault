<?php
session_start();
$host = 'localhost';
$db = 'creditcardvault2';
$user = 'root';
$pass = 'Skywave@254!';
$encryption_key = 'supersecretkey2025'; // Change this!

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>