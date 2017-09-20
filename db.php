<?php
header('Content-Type: text/html; charset=utf-8');
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
$host = 'srv-db-plesk03.ps.kz:3306'; // адрес сервера 
$database = 'mediagur_dokumenty.kz'; // имя базы данных
$user = 'media_dexter'; // имя пользователя
$password = 'uYkh336$'; // пароль


// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
    
// Этот запрос не влияет на поведение ф-ии $mysqli->real_escape_string();
$link->query("SET NAMES utf8");

// И этот не влияет на $mysqli->real_escape_string();
$link->query("SET CHARACTER SET utf8");

// но вот этот запрос повлияет на поведение ф-ии $mysqli->real_escape_string();
$link->set_charset('utf8');

// а этот НЕ повлияет, потому что нельзя использовать "-" тире/дефис
$link->set_charset('utf-8'); // (utf8, а не utf-8)

$query ="SELECT * FROM clients";
$result = mysqli_query($link, $query) or die("Ошибка подключение к базе данных." . mysqli_error($link)); 
if($result)
{
    
}

?>