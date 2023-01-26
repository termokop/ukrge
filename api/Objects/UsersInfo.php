<?php

class UsersInfo
{
    // підключення до таблиці "user_info"
    public $conn;
    private $table_name = "user_info";

    // Властивості
    public $email; // при реєстрації
    public $nickname;
    public $name; // при реєстрації
    public $about_yourself;
    public $picture; // при реєстрації

    // Конструктор класа UsersInfo
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Метод для створення нового користувача в з інфо
    function create()
    {
        // Запит на додавання нового користувача в БД
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    email = :email,
                    nickname = :nickname,
                    name = :name,
                    picture = :picture,
                    about_yourself = :about_yourself";
                   

        // Підготовка запиту
        $stmt = $this->conn->prepare($query);

        // Ін'єкція
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->picture = htmlspecialchars(strip_tags($this->picture));
        $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));

        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nickname", $this->nickname);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":about_yourself", $this->about_yourself);
        $stmt->bindParam(":picture", $this->picture);
        // Виконуємо запит
        if ($stmt->execute()) {
            return true; // Якщо виконання пройшло успішно, то информацію про користувача буде збережено в БД
        }
        return false;
    }

    // Метод оновлення інфо про користувача
    public function update() {
    
        $query = "UPDATE " . $this->table_name . "
                SET
                    nickname = :nickname,
                    email = :email,
                    name = :name,
                    about_yourself = :about_yourself,
                    picture = :picture,
                WHERE email = :email";
    
        // Підготовка запиту
        $stmt = $this->conn->prepare($query);
    
        // Ін'єкція
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));
        $this->picture = htmlspecialchars(strip_tags($this->picture));
    
        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":about_yourself", $this->about_yourself);
        $stmt->bindParam(":nickname", $this->nickname);
        $stmt->bindParam(":picture", $this->picture);
    
        // Якщо виконання пройшло успішно, то информацію про користувача буде збережено в БД
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}