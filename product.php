<?php
// Подключение к базе данных
include 'db_config.php';

// Проверяем, был ли передан ID продукта в URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']); // Преобразуем ID в целое число для безопасности

    // Подготавливаем SQL-запрос для получения данных о продукте
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId); // "i" означает integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Проверяем, найден ли продукт
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc(); // Получаем данные о продукте в виде ассоциативного массива

        // Начинаем вывод HTML-кода
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($product['name']); ?></title>
            <link rel="stylesheet" href="css/style.css">
            <?php include 'header.php'; ?>
        </head>
        <body>
            <section class="product-details">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>

                <div class="product-content">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="product-info">
                        <p class="price">Цена: <?php echo htmlspecialchars(number_format($product['price'], 2)); ?> руб.</p>
                        <div class="description-block"> <!-- Оборачиваем описание в div -->
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>
                        <p>В наличии: <?php echo htmlspecialchars($product['amount']); ?> шт.</p>

                        <?php if ($product['amount'] > 0) { ?>
                            <!-- Убираем форму и оставляем только кнопку -->
                            <button class="cta-button add-to-cart-button" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">Добавить в корзину</button>
                            <script src="add.js"></script>
                        <?php } else { ?>
                            <p style="color: red;">Нет в наличии</p>
                        <?php } ?>
                    </div>
                </div>
            </section>

            <?php include 'footer.php'; ?>
        </body>
        </html>
        <?php
    } else {
        // Если продукт не найден, выводим сообщение об ошибке или перенаправляем
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ошибка</title>
            <link rel="stylesheet" href="css/style.css">
            <?php include 'header.php'; ?>
        </head>
        <body>
            <section class="error-message">
                <p>Товар не найден.</p>
            </section>
            <?php include 'footer.php'; ?>
        </body>
        </html>
        <?php
    }
    $stmt->close();
} else {
    // Если ID продукта не передан, выводим сообщение об ошибке или перенаправляем
    ?>
    <!DOCTYPE html>
    <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ошибка</title>
            <link rel="stylesheet" href="css/style.css">
            <?php include 'header.php'; ?>
        </head>
        <body>
            <section class="error-message">
                <p>Неверный запрос.</p>
            </section>
            <?php include 'footer.php'; ?>
        </body>
        </html>
        <?php
    }

    // Закрываем соединение с базой данных (если соединение открыто в db_config.php)
    if (isset($conn) && $conn) { // Проверяем, что соединение существует
    $conn->close();
    }
    ?>