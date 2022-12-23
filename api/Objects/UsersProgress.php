<?php

class UsersProgress
{
    // Подключение к БД таблице "users"
    public $conn;
    private $table_name = "progress";

    // Свойства
    public $email;
    // public $nickname;
    // public $name;
    // public $gender;
    // public $country;
    // public $about_yourself;
    // public $lang;
    // public $phone;
    // public $icon;
    // public $birth;
    // public $id;
    // public $password;

    // Конструктор класса User
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Метод для создания нового пользователя
    function create()
    {

        // Запрос для добавления нового пользователя в БД
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    email = :email";
                   

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->email = htmlspecialchars(strip_tags($this->email));
        // $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        // $this->name = htmlspecialchars(strip_tags($this->name));
        // $this->country = htmlspecialchars(strip_tags($this->country));
        // $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));
        // $this->lang = htmlspecialchars(strip_tags($this->lang));
        // $this->phone = htmlspecialchars(strip_tags($this->phone));
        // $this->icon = htmlspecialchars(strip_tags($this->icon));

        // Привязываем значения
        $stmt->bindParam(":email", $this->email);
        // $stmt->bindParam(":nickname", $this->nickname);
        // $stmt->bindParam(":name", $this->name);
        // $stmt->bindParam(":country", $this->country);
        // $stmt->bindParam(":about_yourself", $this->about_yourself);
        // $stmt->bindParam(":lang", $this->lang);
        // $stmt->bindParam(":phone", $this->phone);
        // $stmt->bindParam(":icon", $this->icon);

        // // Для защиты пароля
        // // Хешируем пароль перед сохранением в базу данных
        // $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        // $stmt->bindParam(":password", $password_hash);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

 
// Здесь будет метод update()
    // Обновить запись пользователя
public function update() {
 
    // Если не введен пароль - не обновлять пароль
    $query = "UPDATE " . $this->table_name . "
            SET
                nickname = :nickname,
                email = :email,
                name = :name,
                country = :country,
                about_yourself = :about_yourself,
                lang = :lang,
                phone = :phone,
                icon = :icon,
                birth = :birth,
                gender = :gender
            WHERE id = :id";
 
    // Подготовка запроса
    $stmt = $this->conn->prepare($query);
 
    // Инъекция (очистка)
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->nickname = htmlspecialchars(strip_tags($this->nickname));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->country = htmlspecialchars(strip_tags($this->country));
    $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));
    $this->lang = htmlspecialchars(strip_tags($this->lang));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->icon = htmlspecialchars(strip_tags($this->icon));
    $this->birth = htmlspecialchars(strip_tags($this->birth));
    $this->gender = htmlspecialchars(strip_tags($this->gender));
 
    // Привязываем значения с HTML формы
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":nickname", $this->nickname);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":country", $this->country);
    $stmt->bindParam(":about_yourself", $this->about_yourself);
    $stmt->bindParam(":lang", $this->lang);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":icon", $this->icon);
    $stmt->bindParam(":birth", $this->birth);
    $stmt->bindParam(":gender", $this->gender);
 
 
    // Уникальный идентификатор записи для редактирования
    $stmt->bindParam(":id", $this->id);
 
    // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
    if($stmt->execute()) {
        return true;
    }
 
    return false;
}


 // nickname = :nickname,
// name = :name,
// country = :country,
// about_yourself = :about_yourself,
// lang = :lang,
// phone = :phone,
// icon = :icon";

                   
/*
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        

        // Инъекция
        $this->email = htmlspecialchars(strip_tags($this->email));
        // $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        // $this->name = htmlspecialchars(strip_tags($this->name));
        // $this->country = htmlspecialchars(strip_tags($this->country));
        // $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));
        // $this->lang = htmlspecialchars(strip_tags($this->lang));
        // $this->phone = htmlspecialchars(strip_tags($this->phone));
        // $this->icon = htmlspecialchars(strip_tags($this->icon));

        // Привязываем значения
        $stmt->bindParam(":email", $this->email);
        // $stmt->bindParam(":nickname", $this->nickname);
        // $stmt->bindParam(":name", $this->name);
        // $stmt->bindParam(":country", $this->country);
        // $stmt->bindParam(":about_yourself", $this->about_yourself);
        // $stmt->bindParam(":lang", $this->lang);
        // $stmt->bindParam(":phone", $this->phone);
        // $stmt->bindParam(":icon", $this->icon);

        // // Для защиты пароля
        // // Хешируем пароль перед сохранением в базу данных
        // $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        // $stmt->bindParam(":password", $password_hash);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
*/
}