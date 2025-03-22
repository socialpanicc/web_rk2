<?php
include 'init.php';


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Название вашего магазина</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="https://i.pinimg.com/736x/87/02/0a/87020abf1b8495d9183301f09b74846a.jpg" alt="Логотип пекарни">
            <span>1927 Bakery</span>
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="products.php">Наша выпечка</a></li>
            <li><a href="about.php">О нас</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="cart.php">Корзина</a></li>';
                echo '<li><a href="logout.php">Выйти</a></li>';
            } else {
                echo '<li><a href="login.php">Войти</a></li>';
                echo '<li><a href="reg.php">Регистрация</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>

<main>