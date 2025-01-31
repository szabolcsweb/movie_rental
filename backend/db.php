<?php
$host = 'db';
$dbname = 'movie_rental';
$username = 'root';
$password = 'rootpass';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Hiba az adatbázis kapcsolódás során: " . $e->getMessage());
}
?>