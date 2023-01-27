<?php

header("Content-Type: application/json; charset=UTF-8");

function cors() {//------------------------------------------------------------------------------
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
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

include_once "./Config/LessonDB.php";
include_once "./Objects/Task_Words_for_course.php";
include_once "./Objects/Task_Create_Sentence_for_course.php";

//з'єднуємося з базою даних
$database = new LessonDB();
$db = $database->getConnection();
//----------------------------------------------------------------------------------
//створюємо об'єкт Task_Words
$task_words = new Task_Words_for_course($db);

//отримуємо дані
$data = json_decode(file_get_contents("php://input"));

//встановлюємо значення

$task_words = $task_words->getTask($data->topic);
//------------------------------------------------------------------------------
//створюємо об'єкт Task_Create_Sentence
$task_creat_sent = new Task_Create_Sentence_for_course($db);

//встановлюємо значення

$task_creat_sent = $task_creat_sent->getTask($data->topic);

shuffle($task_creat_sent);
$task_creat_sent = array_slice($task_creat_sent, 0, 8);

// $task_creat_sent[0]["variants_fake"] = $task_words[0][0]["ua"];

for ($i = 0; $i < count($task_creat_sent); $i++) {
    for ($j = 0; $j < 3; $j++) {
        shuffle($task_words);
        if(in_array($task_words[$j][0]["ua"], $task_creat_sent[$i]["variants_fake"]) || !$task_words[$j][0]["ua"]) continue;
        $task_creat_sent[$i]["variants_fake"][] = $task_words[$j][0]["ua"];
    }
    
    $task_creat_sent[$i]["variants_fake"] = implode(",",$task_creat_sent[$i]["variants_fake"]);
    $task_creat_sent[$i]["variants_fake"] = str_replace(" ", ",", $task_creat_sent[$i]["variants_fake"]);
        // print_r($task_creat_sent[$i]["variants_fake"]);
}

shuffle($task_words);
$task_words = array_slice($task_words, 0, 2);


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