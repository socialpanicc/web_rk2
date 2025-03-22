<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bakery"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>