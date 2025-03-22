<?php
include 'init.php';
include 'db_config.php';

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username)) {
        $loginError = "Пожалуйста, введите имя пользователя.";
    } elseif (empty($password)) {
        $loginError = "Пожалуйста, введите пароль.";
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashedPassword);
                $stmt->fetch();

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION["username"] = $username;
                    $_SESSION["user_id"] = $id;
                    header("Location: index.php");
                    exit();
                } else {
                    $loginError = "Неверное имя пользователя или пароль.";
                }
            } else {
                $loginError = "Неверное имя пользователя или пароль.";
            }
            $stmt->close();
        } else {
            $loginError = "Ошибка при подключении к базе данных. Попробуйте позже.";
        }
    }
}

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
    <link rel="stylesheet" href="css/style.css"> 
    <?php include 'header.php'; ?>   
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

    <?php include 'footer.php'; ?>   
</body>
</html>