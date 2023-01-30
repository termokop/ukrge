<?php
function cors() {//------------------------------------------------------------------------------
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
}
cors();//*************************************************************************************** */
 
// Файли для з'єднання з БД
include_once "./Config/Database.php";
include "./Objects/User.php";
include "./Objects/UsersInfo.php";//----------------------------------------------------------
 
// з'єднуємося з БД
$database = new Database();
$db = $database->getConnection();
 
// створюємо об'єкт user
$user = new User($db);
 
// отримуємо дані з клієнта
$data = json_decode(file_get_contents("php://input"));
 
// Встановлюємл значення
$user->email = $data->email;
$email_exists = $user->emailExists();
$user->password = $data->password;
// Підключення файлів JWT
include_once "Config/Core.php";
include_once "libs/php-jwt/BeforeValidException.php";
include_once "libs/php-jwt/ExpiredException.php";
include_once "libs/php-jwt/SignatureInvalidException.php";
include_once "libs/php-jwt/JWT.php";
use \Firebase\JWT\JWT;
    
if ( // Якщо користувач ще не зареєстрований — виконуємо реєстрацію
    !empty($user->email) &&
        $email_exists == 0 &&
    !empty($user->password) &&
    $user->create() ) {
    // Заносимо інфо про користувача, зчитане з google
        $userProgress = new UsersInfo($db);
        $userProgress->email = $data->email;
        $userProgress->name = $data->given_name;
        $userProgress->picture = $data->picture;
        $userProgress->nickname = "";
        $userProgress->about_yourself = "";
        $userProgress->course_1 = '{"L_1":"0"}';
        $userProgress->create();
}
$email_exists = $user->emailExists(); // заносимо дані про користувача в об'єкт user
    // Существует ли электронная почта и соответствует ли пароль тому, что находится в базе данных
if ($email_exists &&  password_verify($data->password, $user->password)) {
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "email" => $user->email
        )
    );

    // Код ответа
    http_response_code(200);

    // Зчитую інфо про користувача з БД щоб надіслати відповідь про вдалий вхід
    $myuser = new UsersInfo($db);
    $sql = "SELECT * FROM user_info WHERE email = '". $data->email. "'";
    $result = $myuser->conn->query($sql);
    $row = $result->fetch();

    $myuser->email = $row['email'];
    $myuser->nickname = $row['nickname'];
    $myuser->name = $row['name'];
    $myuser->about_yourself = $row['about_yourself'];
    $myuser->picture = $row['picture'];
    $myuser->course_1 = $row['course_1'];
    unset($myuser->conn); // видаляю поле conn
    //echo $myuser;

    #echo json_encode($myuser);


    // Создание jwt
    $jwt = JWT::encode($token, $key, 'HS512');
    echo json_encode(
        array(
            "message" => "Success",
            "jwt" => $jwt,
            "userInfo" => $myuser,//
            
        )
    );
}
