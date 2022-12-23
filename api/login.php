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
cors();//*************************************************************************************** */
 
// Файлы необходимые для соединения с БД
include_once "./Config/Database.php";
include_once "./Objects/User.php";
include_once "./Objects/UsersProgress.php";//----------------------------------------------------------
 
// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();
 
// Создание объекта "User"
$user = new User($db);
 
// Получаем данные
$data = json_decode(file_get_contents("php://input"));
 
// Устанавливаем значения
$user->email = $data->email;
$email_exists = $user->emailExists();
 
// Файлы для JWT будут здесь

// Подключение файлов JWT
include_once "Config/Core.php";
include_once "libs/php-jwt/BeforeValidException.php";
include_once "libs/php-jwt/ExpiredException.php";
include_once "libs/php-jwt/SignatureInvalidException.php";
include_once "libs/php-jwt/JWT.php";
use \Firebase\JWT\JWT;
 
// Существует ли электронная почта и соответствует ли пароль тому, что находится в базе данных
if ($email_exists && password_verify($data->password, $user->password)) {
 
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
 
    // Код ответа
    http_response_code(200);

    //my code start--------------------------------------------------------------------
    $myuser = new UsersProgress($db);
    $sql = "SELECT * FROM progress WHERE email = '". $data->email. "'";
    $result = $myuser->conn->query($sql);
    $row = $result->fetch();

    $myuser->email = $row['email'];
    $myuser->nickname = $row['nickname'];
    $myuser->name = $row['name'];
    $myuser->gender = $row['gender'];
    $myuser->country = $row['country'];
    $myuser->about_yourself = $row['about_yourself'];
    $myuser->lang = $row['lang'];
    $myuser->phone = $row['phone'];
    $myuser->icon = $row['icon'];
    $myuser->birth = $row['birth'];
    $myuser->id = $user->id;
    unset($myuser->conn); // видаляю поле conn
    //echo $myuser;

    #echo json_encode($myuser);
    //my code finish------------------------------

 
    // Создание jwt
    $jwt = JWT::encode($token, $key, 'HS512');
    echo json_encode(
        array(
            "message" => "Успешный вход в систему",
            "jwt" => $jwt,
            "userInfo" => $myuser,//--------------------------------------------------------------------
            
        )
    );
}
 
// Если электронная почта не существует или пароль не совпадает,
// Сообщим пользователю, что он не может войти в систему
/*else {
 
  // Код ответа
  http_response_code(401);

  // Скажем пользователю что войти не удалось
  echo json_encode(array("message" => "Ошибка входа"));
}
?>*/