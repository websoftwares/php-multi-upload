<?php
include "../bootstrap.php";
use VC4A\Action\DocumentsListAction;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    $documentsListAction = new DocumentsListAction($documentsModel);

    header('Content-Type: application/json');
    echo $documentsListAction();
    exit();
}

header('HTTP/1.0 404 Not Found');
exit();
