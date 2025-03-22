<?php



include 'db_config.php';


function sanitizeInput($data) { 
    $data = stripslashes($data);  
    $data = htmlspecialchars($data); 
    return $data;
}

$usernameError = $passwordError = $emailError = "";
$registrationSuccess = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = sanitizeInput($_POST["username"]);
    $password = $_POST["password"];
    $email = sanitizeInput($_POST["email"]);
    $firstName = sanitizeInput($_POST["first_name"]);
    $lastName = sanitizeInput($_POST["last_name"]);   


    if (empty($username)) {
        $usernameError = "Пожалуйста, введите имя пользователя.";
    }
    if (empty($password)) {
        $passwordError = "Пожалуйста, введите пароль.";
    }
    if (empty($email)) {
        $emailError = "Пожалуйста, введите адрес электронной почты.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Неверный формат адреса электронной почты.";
    }

 
    if (empty($usernameError) && empty($passwordError) && empty($emailError)) {
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
           
            $stmt->bind_param("sssss", $username, $hashedPassword, $email, $firstName, $lastName);

         
            if ($stmt->execute()) {
              
                $registrationSuccess = true;
                
            } else {
              
                $registrationError = "Ошибка при регистрации. Возможно, имя пользователя или email уже заняты.";
            }

        
            $stmt->close();
        } else {
            $registrationError = "Ошибка при подготовке запроса."; 
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
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include 'header.php'; ?> 
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>

        <?php if ($registrationSuccess): ?>
            <div class="success-message">
                Регистрация прошла успешно!  Теперь вы можете войти в систему.
            </div>
        <?php elseif (isset($registrationError)): ?>
            <div class="error-message">
                <?php echo $registrationError; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                <span class="error"><?php echo $usernameError; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password">
                <span class="error"><?php echo $passwordError; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                <span class="error"><?php echo $emailError; ?></span>
            </div>

             <div class="form-group">
                <label for="first_name">Имя:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="last_name">Фамилия:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>">
            </div>

            <button type="submit" class="btn">Зарегистрироваться</button>
        </form>

        <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
    </div>

    <?php include 'footer.php'; ?>  
</body>
</html>