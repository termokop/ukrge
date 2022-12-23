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

// Требуется для кодирования веб-токена JSON
include_once "Config/Core.php";
include_once "libs/php-jwt/BeforeValidException.php";
include_once "libs/php-jwt/ExpiredException.php";
include_once "libs/php-jwt/SignatureInvalidException.php";
include_once "libs/php-jwt/JWT.php";
include_once "libs/php-jwt/Key.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/UsersProgress.php";

// Получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new UsersProgress($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Получаем jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// Если JWT не пуст
if ($jwt) {

    // Если декодирование выполнено успешно, показать данные пользователя
    try {
        
        // Декодирование jwt
        $decoded = JWT::decode($jwt, new Key($key, 'HS512'));

        // Нам нужно установить отправленные данные (через форму HTML) в свойствах объекта пользователя
        $user->email = $data->email;
        
        $user->id = $data->id;
        $user->nickname = $data->nickname;
        $user->name = $data->name;
        $user->country = $data->country;
        $user->about_yourself = $data->about_yourself;
        $user->lang = $data->lang;
        $user->phone = $data->phone;
        $user->icon = $data->icon;
        $user->birth = $data->birth;
        $user->gender = $data->gender;
        // Создание пользователя
        if ($user->update()) {
            
            
            // Нам нужно заново сгенерировать JWT, потому что данные пользователя могут отличаться
$token = array(
    "iss" => $iss,
    "aud" => $aud,
    "iat" => $iat,
    "nbf" => $nbf,
    "data" => array(
        "id" => $user->id,
        "email" => $user->email
    )
 );
 
 $jwt = JWT::encode($token, $key, 'HS512');
  
 // Код ответа
 http_response_code(200);
  
 // Ответ в формате JSON
 echo json_encode(
     array(
         "message" => "Пользователь был обновлён",
         "jwt" => $jwt,
         "userInfo" => $user
     )
 );

        }

        // Сообщение, если не удается обновить пользователя
        else {

            // Код ответа
            http_response_code(401);

            // Показать сообщение об ошибке
            echo json_encode(array("message" => "Невозможно обновить пользователя"));
        }
    }

    // Если декодирование не удалось, это означает, что JWT является недействительным
    catch (Exception $e) {

        // Код ответа
        http_response_code(401);

        // Сообщение об ошибке
        echo json_encode(array(
            "message" => "Доступ закрыт",
            "error" => $e->getMessage()
        ));
    }
}

// Показать сообщение об ошибке, если jwt пуст
else {

    // Код ответа
    http_response_code(401);

    // Сообщить пользователю что доступ запрещен
    echo json_encode(array("message" => "Доступ закрыт"));
}