<?php

// Используем для подключения к базе данных MySQL
class LessonDB
{
    // Учётные данные базы данных
    private $host = "ukrge.mysql.tools";
    private $db_name = "ukrge_lessons";
    private $username = "ukrge_db";
    private $password = "Pr2zNJBp";
    public $conn;

    // Получаем соединение с базой данных
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Помилка з'єднання: " . $exception->getMessage();
        }

        return $this->conn;
    }
}