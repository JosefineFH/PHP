<?php 
include("../../../lib/initiate.inc");
include(NOCACHE_H);
include(COMMON_INC_H);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Origin: http://localhost:8080');
    //header('Access-Control-Allow-Origin: http://localhost:8081');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: http://localhost:8080');
//header('Access-Control-Allow-Origin: http://localhost:8081');
header('Content-Type: application/json');

$module = $_GET['module'];
if (!isset($_SESSION['usr_id']) && $module!="login"){
    returnError("Trying to access module \"" . $module . "\" without being logged in.");
}

switch($module)
{
    case 'login':
        login();
        break;
    case 'logout':
        unset($_SESSION['usr_id']);
        break;
    case 'department':
        department();
        break;
    case 'user':
        user();
        break;
    case 'editPassword':
        editPassword(); 
        break;     
    case 'editIntegrationCode':
        editIntegrationCode(); 
        break;  
    case 'deActivate':
        deActivate(); 
        break;
    case 'activate':
        activate(); 
        break;
    default:
        returnError("Unknown module: " . $module);
}

function returnError($message){
    $returnValue = new stdClass();
    $returnValue->error = $message;
    $returnValue->usr_id = $_SESSION['usr_id'];
    echo json_encode($returnValue);
    die();
}

################## LOGIN  ################################
function login(){
    $jsonData = json_decode(file_get_contents("php://input"));
    $returnValue = new stdClass();
    $returnValue->success = false;
    $DB = new DB_Sql();
    $dataArray = [];
  
    $DB->prepareAndExecute(
    "SELECT id, name FROM system.usr WHERE lower(username)=lower($1) AND password=crypt($2,password) AND disabled=0",
    [$jsonData->username, $jsonData->password]);
  
    if ($DB->numRows() == 0) {
        unset($_SESSION['usr_id']);
        echo json_encode($returnValue);
    } else {
        $returnValue->success=true;
        $name = $DB->getField("name");
        $id = $DB->getField("id");
        
        
    $DB->prepareAndExecute("SELECT department_id,  application_id  FROM hgoffline.usr_dep AS ud WHERE ud.id = $1", $id);
    if ($DB->numRows() <= 0) {
        echo json_encode($returnValue);
    } else {
        // Henter fra sql-resultatet
        $depId = $DB->getField("department_id");
        $appId =$DB->getField("application_id");
            
        $_SESSION['username'] = $jsonData->username; //ta vare på login navn
        $_SESSION['usr_id'] = $id; // Saves user id
        $_SESSION['dep_id'] = $depId;
        $_SESSION['app_id'] = $appId;

        $returnValue->login = true;
        $returnValue->name = $name;
        $returnValue->departmentId = $depId;
        $returnValue->applicationId = $appId;
        $returnValue->sessionUsrId =  $_SESSION['usr_id'];            
        echo json_encode($returnValue);
        }
    }
}

#################### DEPARTMENT ##########################
function department(){
    $DB1 = new DB_Sql();
    $DB = new DB_Sql();
    
    $jsonData = json_decode(file_get_contents("php://input"));
    $department = $jsonData->department;
    $session_dep = $_SESSION['dep_id'];
    $session_app = $_SESSION['app_id'];
    
    $DB->prepareAndExecute("SELECT name FROM hgoffline.application WHERE id = $1 ", $department);
    $params = [$session_app];
    $whereAdd = "";
        if ($session_dep >= 0) {
            $whereAdd = " AND id=$2";
            $params[] = $session_dep;
        }

    $DB1->prepareAndExecute("SELECT department.name, department.id FROM hgoffline.department WHERE application_id=$1" . $whereAdd, $params);

        if ($session_dep== -1) {
            do {
            $row = new stdClass();
            $row->id = $DB1->getField("id");
            $row->name = $DB1->getField("name");
            $dataArray[] = $row;
            } 
            while ($DB1->MoveNext());
        }
    $department = json_encode($dataArray);
    printf(json_encode($dataArray));
}

############## USER ######################
function user(){
    $DB = new DB_Sql();
    $dataArray = [];
	$cont=file_get_contents("php://input");
    $jsonData = json_decode($cont);
    $selectedDepartment = (int)$jsonData->selectedDepartment;
 
    $appId = $_SESSION['app_id'];
    $depId = $_SESSION['dep_id'];
   
    $sql =  "SELECT visual, id, application_id, department, " .
            "code, deleted, password "  .  
            "FROM hgoffline.user hu " . 
            "WHERE application_id=$1 AND department=$2 AND deleted = 0";
    $params =[$appId]; 
 
    if ($depId  >= 0) $params[] =$depId; //vanlig bruker
    elseif ($depId == -1){ $params[] = $selectedDepartment;} //superbruker
    else unset($_SESSION['usr_id']); //ikke bruker
        
    $DB->prepareAndExecute($sql, $params);
        if ($DB->numRows() >= 0) {
            do {
                $row = new stdClass();
                $row->name = $DB->getField("visual");
                $row->app = $DB->getField("application_id");
                $row->dep_id = $DB->getField("department");
                $row->id = $DB->getField("id");
                $row->code = $DB->getField("code");
                $row->deleted = $DB->getField("deleted");
                $row->password = $DB->getField("password");
                $dataArray[] = $row;
                } 
            while ($DB->MoveNext());
        } 
    echo json_encode($dataArray);
}


##########  EDIT   ##########################
function editPassword(){
    $jsonData = json_decode(file_get_contents("php://input"));
    doLog( $jsonData);
    
    $newPassword = $jsonData->newPassword;
    $selectedUser = (int)$jsonData->selectedUser;
    $DB = new DB_Sql();
    $dataArray = [];

    if($newPassword == ''|| $selectedUser == ''){
    //ikke kjør SQL || sett params til allerede lagrede verdier?
    die();
    }
    else{
    $sql =  "UPDATE hgoffline.user SET password=$1 WHERE id=$2";
    $params =[$newPassword, $selectedUser];
    
    $DB->prepareAndExecute($sql, $params);
    }
}


function editIntegrationCode(){
    $jsonData = json_decode(file_get_contents("php://input"));
    $newIntegrationCode = (string)$jsonData->code;
    $selectedUser = (int)$jsonData->selectedUser;
    $DB = new DB_Sql();
    
    $params =[$newIntegrationCode, $selectedUser];
    
  $DB->prepareAndExecute("UPDATE hgoffline.user SET integrationcode = $1 WHERE id =$2", $params);
}

############ DEACTIVATE  ######################
function deActivate(){
    $jsonData = json_decode(file_get_contents("php://input"));
    doLog( $jsonData);
    $deActivateUser = (bool)$jsonData->deActivateUser;
    $selectedUser = (int)$jsonData->selectedUser;
    $DB = new DB_Sql();

    if($deActivateUser == true){ $deActivateUser == 1;}
    else{ $deActivateUser == 0;}

    $params =[$deActivateUser,$selectedUser ];
   
    $DB->prepareAndExecute("UPDATE hgoffline.user SET deleted = $1 WHERE id =$2", $params);
}

/*
########### RE-ACTIVATE  #########################
function reActivate(){

}*/

/*
############### LOGOUT ###################
function logout(){
denne ligger i modules allerede - tester om funker v/neste anledning :D
}
*/ 