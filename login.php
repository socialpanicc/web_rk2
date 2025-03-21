<?php

// Подключение к базе данных (предполагается, что файл db_config.php уже существует)
include 'db_config.php';

// Переменная для хранения сообщения об ошибке
$loginError = "";

// Обработка данных формы при отправке
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем и фильтруем данные
    $username = trim($_POST["username"]);    // Удаляем пробелы
    $password = $_POST["password"];

    // Валидация данных (простая)
    if (empty($username)) {
        $loginError = "Пожалуйста, введите имя пользователя.";
    } elseif (empty($password)) {
        $loginError = "Пожалуйста, введите пароль.";
    } else {
        // Если данные введены, проверяем имя пользователя и пароль в базе данных

        // Подготавливаем SQL-запрос для предотвращения SQL-инъекций
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        // Проверяем, удалось ли подготовить запрос
        if ($stmt) {
            // Привязываем параметр к запросу
            $stmt->bind_param("s", $username);

            // Выполняем запрос
            $stmt->execute();

            // Получаем результат запроса
            $stmt->store_result(); // Сохраняем результат, чтобы узнать количество строк
            if ($stmt->num_rows == 1) {
                // Если имя пользователя найдено, проверяем пароль
                $stmt->bind_result($id, $username, $hashedPassword); // Привязываем переменные к результату
                $stmt->fetch(); // Извлекаем данные из результата

                // Проверяем пароль с помощью password_verify()
                if (password_verify($password, $hashedPassword)) {
                    // Пароль верен, начинаем сессию
                    $_SESSION["username"] = $username; // Сохраняем имя пользователя в сессии
                    $_SESSION["user_id"] = $id; // Сохраняем ID пользователя в сессии
                    // Перенаправляем пользователя на главную страницу или личный кабинет
                    header("Location: index.php"); // Измените на нужную страницу
                    exit();
                } else {
                    // Неверный пароль
                    $loginError = "Неверное имя пользователя или пароль.";
                }
            } else {
                // Имя пользователя не найдено
                $loginError = "Неверное имя пользователя или пароль.";
            }

            // Закрываем запрос
            $stmt->close();
        } else {
            // Ошибка при подготовке запроса
            $loginError = "Ошибка при подключении к базе данных. Попробуйте позже.";
        }
    }
}

// Закрываем соединение с базой данных (если соединение открыто в db_config.php)
if (isset($conn) && $conn) {
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Подключаем таблицу стилей -->
    <?php include 'header.php'; ?>   <!-- Подключаем header -->
</head>
<body>
    <div class="container">
        <h1>Вход</h1>

        <?php if (!empty($loginError)): ?>
            <div class="error-message">
                <?php echo $loginError; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password">
            </div>

            <button type="submit" class="btn">Войти</button>
        </form>

        <p>Еще не зарегистрированы? <a href="reg.php">Зарегистрироваться</a></p>
    </div>

    <?php include 'footer.php'; ?>    <!-- Подключаем footer -->
</body>
</html>