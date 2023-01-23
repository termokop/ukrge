<?php

Class LessonInfo
{
    //оголошення приватних змінних для підключення до потрібних таблиць в БД
    private $conn;
    private $text_info_table = 'text_info';
    private $letters_table = 'letters';
    private $words_table = 'words';
    private $sentence_table = 'sentences';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //метод для отримання тексту до уроку:
    function getLessonTheorty($lesson)
    {
        //створення SQL-запиту на отримання тестових даних
        $query = "SELECT intro,gramar,addictional FROM " . $this->text_info_table . " WHERE lesson = '". $lesson ."'";

        //підготовка запиту
        $stmt = $this->conn->prepare($query);

        //Ін'єкція
        $lesson=htmlspecialchars((strip_tags($lesson)));

        //прив'язуємо значення lesson
        $stmt->bindParam(":lesson",$lesson);

        // виконуємо запит
        $stmt->execute();

        //отримуємо к-сть рядків
        //$num = $stmt->rowCount();
        
        //отримуємо значення
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $info;

    }

        //метод для отримання літер до уроку:
        function getLetters($lesson)
        {
            //створення SQL-запиту на отримання тестових даних
            $query = "SELECT id,ge,ua,voice FROM " . $this->letters_table . " WHERE lesson = '". $lesson ."'";
    
            //підготовка запиту
            $stmt = $this->conn->prepare($query);
    
            //Ін'єкція
            $lesson=htmlspecialchars((strip_tags($lesson)));
    
            //прив'язуємо значення lesson
            $stmt->bindParam(":lesson",$lesson);
    
            // виконуємо запит
            $stmt->execute();

            //формуємо мисив 
            $letters = [];

            $i = 0;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // заностмо значення в масив
                $letters[$i] = $row;
                $i++;
            }
            return $letters;
        }

        //метод для отримання слів до уроку:
        function getWords($lesson)
        {
            //створення SQL-запиту на отримання тестових даних
            $query = "SELECT id,ge,ua,voice,ua_additional FROM " . $this->words_table . " WHERE lesson = '". $lesson ."'";
    
            //підготовка запиту
            $stmt = $this->conn->prepare($query);
    
            //Ін'єкція
            $lesson=htmlspecialchars((strip_tags($lesson)));
    
            //прив'язуємо значення lesson
            $stmt->bindParam(":lesson",$lesson);
    
            // виконуємо запит
            $stmt->execute();

            //формуємо мисив слів
            $words = [];

            $i = 0;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // заностмо значення в масив
                $words[$i] = $row;
                $i++;
            }
            return $words;
        }


        //метод для отримання літер до уроку:
        function getSentences($lesson)
        {
            //створення SQL-запиту реченьна отримання тестових даних
            $query = "SELECT id,ge,ua,voice FROM " . $this->sentence_table . " WHERE lesson = '". $lesson ."' AND for_lesson = '1'";
    
            //підготовка запиту
            $stmt = $this->conn->prepare($query);
    
            //Ін'єкція
            $lesson=htmlspecialchars((strip_tags($lesson)));
    
            //прив'язуємо значення lesson
            $stmt->bindParam(":lesson",$lesson);
    
            // виконуємо запит
            $stmt->execute();

            //формуємо мисив 
            $sentences = [];

            $i = 0;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // заностмо значення в масив
                $sentences[$i] = $row;
                $i++;
            }
            return $sentences;
        }

        function set_mistake($data) {
            $query = "INSERT INTO `mistakes`(`id`, `user`, `text`, `info`) VALUES ('', '" . $data->user . "', '" . $data->text . "', '" . $data->info . "');";
            //підготовка запиту
            $stmt = $this->conn->prepare($query);
            
            $data=htmlspecialchars((strip_tags($data)));
            
            // виконуємо запит
            
            
            if($stmt->execute()) {
                return  true;
            }
            return false;
        }

}