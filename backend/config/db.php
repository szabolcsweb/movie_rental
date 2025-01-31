<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../vendor/autoload.php';

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST') ?: 'localhost',
    'database'  => getenv('DB_DATABASE') ?: 'movie_rental',
    'username'  => getenv('DB_USERNAME') ?: 'root',
    'password'  => getenv('DB_PASSWORD') ?: 'rootpass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();


// működik-e az Eloquent kapcsolat
// try {
//     $movies = Capsule::table('movies')->get();
//     echo "✅ Adatbáziskapcsolat sikeres! " . count($movies) . " film található az adatbázisban.";
// } catch (\Exception $e) {
//     die("❌ Hiba az adatbáziskapcsolatban: " . $e->getMessage());
// }