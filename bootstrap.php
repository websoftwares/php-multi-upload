<?php
/*
|--------------------------------------------------------------------------
| Syrict types
|--------------------------------------------------------------------------
*/
declare(strict_types=1);
/*
|--------------------------------------------------------------------------
| Start session
|--------------------------------------------------------------------------
*/
session_start();
/*
|--------------------------------------------------------------------------
| Error reporting enabled default remove for production
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
|--------------------------------------------------------------------------
| Autoload classes
|--------------------------------------------------------------------------
*/
include 'vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Imports
|--------------------------------------------------------------------------
*/
use VC4A\Repository\DocumentsRepository;
use VC4A\Repository\UploadRepository;
use VC4A\Model\UploadModel;
use VC4A\Model\DocumentsModel;

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
} catch (PDOException $exception) {
    echo $exception->getMessage();
}

$documentsModel = new DocumentsModel(new DocumentsRepository($pdo));
$uploadModel = new UploadModel(new UploadRepository());
