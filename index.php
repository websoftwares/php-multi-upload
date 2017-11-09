<?php
session_start();
/*
|--------------------------------------------------------------------------
| Error reporting enabled default remove for production
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
|--------------------------------------------------------------------------
| Autoload classes
|--------------------------------------------------------------------------
*/
include 'vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Load configuration
|--------------------------------------------------------------------------
*/
$config = include 'config/config.php';
/*
|--------------------------------------------------------------------------
| Create database object instance
|--------------------------------------------------------------------------
*/
try {
    $pdo = new PDO(...$config['db']); // Better would be to store this into a IoC container.
} catch(PDOException $exception) {
    echo $exception->getMessage();
}
