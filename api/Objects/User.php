<?php

class User
{
    // Підключення до таблиці "users"
    private $conn;
    private $table_name = "users";

    // Властивості
    public $id;
    public $email;
    public $password;

    // Конструктор класа User
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Метод для створення нового користувача
    function create()
    {
        // Запит на додавання нового користувача в БД
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    email = :email,
                    password = :password";

        // Підготовка запиту
        $stmt = $this->conn->prepare($query);

        // Ін'єкція
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Прив'язуємо значення
        $stmt->bindParam(":email", $this->email);

        // Для захисту пароля
        // Хешуємо пароль перед береженням в БД
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password_hash);

        // Виконуємо запит
        // Якщо запит виконано успішно, то повертаємо TRUE
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Перевірка, чи існує email в БД
    function emailExists() {
        // Запит для перевірки існування
        $query = "SELECT id, password
                FROM " . $this->table_name . "
                WHERE email = ?
                LIMIT 0,1";
    
        // Підготовка запиту
        $stmt = $this->conn->prepare($query);
    
        // Ін'єкція
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // Прив'язуємо значення до email
        $stmt->bindParam(1, $this->email);
    
        // Виконуємо запит
        $stmt->execute();
    
        // Отримуємо кількість рядків
        $num = $stmt->rowCount();
    
        // Якщо електронна пошта існує,
        // Присвоїмо значення властивостям об'єкта для легкого доступу та використання для php сессії
        if ($num > 0) {
    
            // Отримуємо значення
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Присвоїмо значення властивостям об'єкта
            $this->id = $row["id"];
            $this->password = $row["password"];
    
            // Повернемо TRUE, тому що в БД існує дана електронна пошта
            return true;
        }
        // Повернемо FALSE, якщо даної електронної пошти ще не існує в БД
        return false;
    }

}