<?php
include "../bootstrap.php";
use VC4A\Action\UploadCreateAction;

$uploadAction = new UploadCreateAction($uploadModel, $documentsModel);
header("Access-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {

    header('Content-Type: application/json');
    echo $uploadAction($_FILES);
    exit();
}
header('HTTP/1.0 404 Not Found');
exit();
