<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/MovieController.php';

$controller = new MovieController();
$movies = $controller->rent();

// var_dump($movies);
// die;
?>