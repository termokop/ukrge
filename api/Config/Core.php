<?php

// вивід помилок
error_reporting(E_ALL);
 
// часовий пояс
date_default_timezone_set("Asia/Tbilisi");
 
// дані для JWT
$key = "key";
$iss = "http://www.ukrge.site";
$aud = "http://www.ukrge.site";
$iat = 1356999524;
$nbf = 1357000000;
