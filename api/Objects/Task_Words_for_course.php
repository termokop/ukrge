<?php

Class Task_Words_for_course
{
    //підключення до БД таблиці words
    private $conn;
    private $table_name = 'words';

    //властивості
    public $topic;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //метод для запиту таски:
    function getTask($top)
    {   
        $top = str_replace("lesson_", "", $top);
        //створення SQL-запиту на отримання списку тасків
        $query = "SELECT * FROM " . $this->table_name . " WHERE lesson <= '". $top ."'";

        //підготовка запиту
        $stmt = $this->conn->prepare($query);

        //Ін'єкція
        $this->topic=htmlspecialchars((strip_tags($this->topic)));

        //прив'язуємо значення topic
        $stmt->bindParam(":topic",$this->topic);

        // виконуємо запит
        $stmt->execute();

        //отримуємо к-сть рядків
        //$num = $stmt->rowCount();
        $arr = [];
        //отримуємо значення
        $i = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // заностмо значення в масив
            $row['type'] = "words";
            $arr[$i] = $row;
            $i++;
        }
        //перетасовуємо масив
        shuffle($arr);

        //повертаємо кількість перших елементів з перетасованого масиву, яка кратна 4-м
        $x = sizeof($arr) % 4;
        $arr = array_slice($arr,0,sizeof($arr)-$x);
         $result = [];
         for ($i=0; $i < sizeOf($arr); $i+=4) { 
            array_push($result, array_slice($arr,$i,4));
         }
         return $result;


    }
}