<?php

include_once 'config/database.php';

$module = $_GET['module'];

switch($module)
{
    case 'read':
        read();
    break;
    case 'readAll':
        readAll();
    break;
    default:
    returnError('Unknowen module: ' . $module);
}

function returnError($message){
    $returnValue = new stdClass();
    $returnValue->error = $message;
    echo json_encode($returnValue);
    die();
}

function read(){
    echo 'test lese kun functionen';
    //  //create query
    //  $query = 'SELECT * FROM `test`';

    //  //Prepare statment

    //  $stmt = $this->conn->prepare($query);

    //  //execute
    //  $stmt->execute();

    //  return $stmt;
}

function readAll(){
    echo 'tester alle functionen';
}
