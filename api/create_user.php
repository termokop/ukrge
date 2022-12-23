<?php

// Заголовки
#header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
#header("Access-Control-Allow-Methods: POST");
#header("Access-Control-Max-Age: 3600");
#header("Access-Control-Allow-Credentials: true");
#header("Access-Control-Allow-Headers: *");

function cors() {
    
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

// Подключение к БД
// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/User.php";
include_once "./Objects/UsersProgress.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);
 


// Получаем данные
$data = json_decode(file_get_contents("php://input"));
 
// Устанавливаем значения
$user->email = $data->email;
$user->password = $data->password;

// Поверка на существование e-mail в БД
 $email_exists = $user->emailExists();
 


// Создание пользователя
if (
    !empty($user->email) &&
     $email_exists == 0 &&
    !empty($user->password) &&
    $user->create()
) {
    // Устанавливаем код ответа
    http_response_code(200);

    //my code start
    $userProgress = new UsersProgress($db);
    $userProgress->email = $data->email;
    $userProgress->create();

    // my code finish
 
    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(array("message" => "Пользователь был создан"));

}
 
// Сообщение, если не удаётся создать пользователя
/*else {
 
    // Устанавливаем код ответа
    http_response_code(400);
 
    // Покажем сообщение о том, что создать пользователя не удалось
    echo json_encode(array("message" => "Невозможно создать пользователя"));
}*/



