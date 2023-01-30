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
    public $course_1; // при реєстрації

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
                    course_1 = :course_1,
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
        // $this->course_1 = htmlspecialchars(strip_tags($this->course_1));

        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nickname", $this->nickname);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":about_yourself", $this->about_yourself);
        $stmt->bindParam(":picture", $this->picture);
        $stmt->bindParam(":course_1", $this->course_1);
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
                    name = :name,
                    about_yourself = :about_yourself
                WHERE email = :email";
    
        // Підготовка запиту
        $stmt = $this->conn->prepare($query);
    
        // Ін'єкція
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nickname = htmlspecialchars(strip_tags($this->nickname));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->about_yourself = htmlspecialchars(strip_tags($this->about_yourself));
        // $this->picture = htmlspecialchars(strip_tags($this->picture));
    
        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":about_yourself", $this->about_yourself);
        $stmt->bindParam(":nickname", $this->nickname);
        // $stmt->bindParam(":picture", $this->picture);
    
        // Якщо виконання пройшло успішно, то информацію про користувача буде збережено в БД
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateProgress() {
    
        $query = "UPDATE " . $this->table_name . "
                SET
                    course_1 = :course_1
                WHERE email = :email;";
    
        // Підготовка запиту
        $stmt = $this->conn->prepare($query);
    
        // Ін'єкція
        $this->email=htmlspecialchars(strip_tags($this->email));
        // $this->course_1 = htmlspecialchars(strip_tags($this->course_1));
    
        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course_1", $this->course_1);
        
        // Якщо виконання пройшло успішно, то информацію про користувача буде збережено в БД
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function get_user_progress($email) {
        $sql = "SELECT course_1 FROM " . $this->table_name . " WHERE email = '". $email. "'";
        $result = $this->conn->query($sql);
        $row = $result->fetch();
        return $row["course_1"];
    }
}