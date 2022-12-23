<?php

Class Task_Create_Sentence
{
    //підключення до БД таблиці words
    private $conn;
    private $table_name = 'create_sentence';

    //властивості
    public $topic;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //метод для запиту таски:
    function getTask($top)
    {
        //створення SQL-запиту на отримання списку тасків
        $query = "SELECT * FROM " . $this->table_name . " WHERE topic = '". $top ."'";

        //підготовка запиту
        $stmt = $this->conn->prepare($query);

        //Ін'єкція
        $this->topic=htmlspecialchars((strip_tags($this->topic)));

        //прив'язуємо значення topic
        $stmt->bindParam(":topic",$this->topic);

        // виконуємо запит
        $stmt->execute();

        $arr = [];
        $i = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $row['variants_fake'] = explode(',',$row['variants_fake']);
            shuffle($row['variants_fake']);
            $row['variants_fake'] = array_splice($row['variants_fake'],0,3);
            $row['variants_fake'] = implode(',', $row['variants_fake']);
            // заносимо значення в масив
            $arr[$i] = $row;
            $i++;
        }
        //перетасовуємо масив
        shuffle($arr);

        return $arr;


    }
}