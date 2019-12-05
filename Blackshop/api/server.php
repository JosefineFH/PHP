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
  <?php

  include_once 'config/database.php';

  $module = $_GET['module'];

  switch($module)
  {
      case 'readAll':
          readAll();
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

  function readAll (){
      $database = new Database();
      $conn = $database->connect();
      $result = $conn->query('SELECT `id`, `name` FROM `test` WHERE 1');

      $posts_arr = array();
      $posts_arr['data'] = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC))
      {
          extract($row);
          $post_item = array(
              'id' => $id,
              'name' => $name
          );
          array_push($posts_arr['data'], $post_item);

      }
      echo json_encode($posts_arr);

  }

  function readAll(){
      echo 'tester alle functionen';
  }
}

function readAll(){
    echo 'tester alle functionen';
}
