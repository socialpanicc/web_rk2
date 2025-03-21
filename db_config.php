<?php
$servername = "localhost"; // Или адрес вашего сервера БД
$username = "root"; // Замените на имя пользователя вашей БД
$password = ""; // Замените на пароль пользователя вашей БД
$dbname = "bakery"; // Замените на имя вашей БД

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Устанавливаем кодировку (важно для кириллицы)
$conn->set_charset("utf8");
?>