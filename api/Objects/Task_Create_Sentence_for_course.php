<?php

Class Task_Create_Sentence_for_course
{
    //підключення до БД таблиці words
    private $conn;
    private $table_name = 'sentences';

    //властивості
    public $topic;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    // рубаю речення на масив слів
    function sentenceToArray($sentence) 
        {
        $punctuations = array(",",":",".","!","?","— ");
        $sentence = str_replace($punctuations, "", $sentence);
        $result = explode(" ", $sentence);
        return $result;
    }
    
    // заміняю всі слова в реченні на <.?.>
    function replaceWordsWithEllipses($sentence, $temp_str) {
        mb_internal_encoding("UTF-8");
        $words = mb_split('[\s,.:!?-]+', $sentence);
        $ellipsedSentence = $sentence;
        foreach($words as $word) {
            $ellipsedSentence = mb_ereg_replace('\b'.preg_quote($word, '/').'\b', $temp_str, $ellipsedSentence);
        }
        return $ellipsedSentence;
    }
    
    // беру масив і повертаю рандомну кількість рандомних індексів цього масива
    function randomIndexesOfArreyWords($array_of_words) {
        $random_number_of_arr_length = random_int(1,count($array_of_words));

        $random_keys = array_rand($array_of_words, $random_number_of_arr_length);
    
        if(gettype($random_keys) === "integer") {
            $random_keys = [$random_keys];
        }
        return $random_keys;
    }
    
    // функція для заміни першого співпадіння
    function replace_first_substring($string, $replacement, $substring) {
        $pos = strpos($string, $substring);
        if($pos !== false) {
            $string = substr_replace($string, $replacement, $pos, strlen($substring));
        }
        return $string;
    }
    
    function sentenceToTaskConstruuctor($str) {
    $temp_str = "<.?.>";




    $array_of_all_words = $this->sentenceToArray($str);

    $sentence_without_words = $this->replaceWordsWithEllipses($str, $temp_str);



    $random_keys_of_arr = $this->randomIndexesOfArreyWords($array_of_all_words);

    $array_with_holes = $array_of_all_words;

    for ($j=0; $j < count($random_keys_of_arr); $j++) { 
        $array_with_holes[$random_keys_of_arr[$j]] = "<...>";
    }


    $arr_of_correct_variants = [];
    for ($k=0; $k < count($array_with_holes); $k++) { 
        $sentence_without_words = $this->replace_first_substring($sentence_without_words, $array_with_holes[$k], $temp_str);
        if($array_with_holes[$k] === $array_of_all_words[$k]) continue;
        else $arr_of_correct_variants[] = $array_of_all_words[$k];
    }

    $result = [];
    $result[answer] = $sentence_without_words;
    $result[variants_real] = implode(",",$arr_of_correct_variants);

    return $result;

}

    //метод для запиту таски:
    function getTask($top)
    {
        $top = str_replace("lesson_", "", $top);
        //створення SQL-запиту на отримання списку тасків
        $query = "SELECT id,ge,ua,voice,lesson FROM " . $this->table_name . " WHERE lesson <= '". (int)$top ."'";

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
            $task = $this->sentenceToTaskConstruuctor($row["ua"]);
            $task["id"] = $row["id"];
            $task["question"] = $row["ge"];
            $task["correct_answer"] = $row["ua"];
            $task["topic"] = "Lesson_" . $row["lesson"];
            $task["type"] = "create_sentence";
            $arr[$i] = $task;
            $i++;
        }
        //перетасовуємо масив
        shuffle($arr);
        return $arr;


    }
}