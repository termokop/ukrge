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
}
cors();

include_once "./Config/Database.php";
include_once "./Objects/Task_Words.php";
include_once "./Objects/Task_Create_Sentence.php";

//з'єднуємося з базою даних
$database = new Database();
$db = $database->getConnection();
//----------------------------------------------------------------------------------
//створюємо об'єкт Task_Words
$task_words = new Task_Words($db);

//отримуємо дані
$data = json_decode(file_get_contents("php://input"));

//встановлюємо значення

$task_words = $task_words->getTask($data->topic);
//------------------------------------------------------------------------------
//створюємо об'єкт Task_Create_Sentence
$task_creat_sent = new Task_Create_Sentence($db);

//встановлюємо значення

$task_creat_sent = $task_creat_sent->getTask($data->topic);

//об'єднуємо масиви
$result = array_merge($task_creat_sent, $task_words);

//перетасовую масив
shuffle($result);

if(sizeof($result) > 10) {
   $result = array_slice($result, 0, 10);
}

echo json_encode(
    array(
        "task" => $result,
    )
    );