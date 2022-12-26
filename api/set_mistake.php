<?php

// Заголовки
// Заголовки
#header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
#header("Access-Control-Allow-Methods: POST");
#header("Access-Control-Max-Age: 3600");
#header("Access-Control-Allow-Credentials: true");
#header("Access-Control-Allow-Headers: *");

function cors() {//------------------------------------------------------------------------------
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
  #  echo "You have CORS!";
}
cors();

include_once "./Config/LessonDB.php";
include_once "./Objects/Lesson_info.php";

//з'єднуємося з базою даних
$database = new LessonDB();
$db = $database->getConnection();
//----------------------------------------------------------------------------------

$mistake = new LessonInfo($db);

//отримуємо дані
$data = json_decode(file_get_contents("php://input"));
$data->info = json_encode($data->info);

$result = $mistake->set_mistake($data);
echo json_encode($result);