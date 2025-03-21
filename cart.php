<?php
session_start();

// Подключение к базе данных (убедитесь, что файл db_config.php существует)
include 'db_config.php';

// Функция для получения информации о товаре из базы данных
function getProductDetails($conn, $productId) {
    $sql = "SELECT id, name, image, price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Обработка добавления товара в корзину
if (isset($_POST['add_to_cart'])) {
    // var_dump($_POST); //  Удалить или закомментировать эту строку
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $product = getProductDetails($conn, $productId);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = array(
                'id' => $product['id'],
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'quantity' => $quantity
            );
        }
        // var_dump($_SESSION['cart']); // Удалить или закомментировать эту строку
        header('Content-Type: application/json');
        echo json_encode(array('status' => 'success', 'message' => 'Товар добавлен в корзину'));
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('status' => 'error', 'message' => 'Товар не найден'));
        exit();
    }
}

// Обработка изменения количества товара в корзине
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        $productId = intval($productId);
        $quantity = intval($quantity);

        if ($quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        } else {
            // Если количество равно 0, удаляем товар из корзины
            unset($_SESSION['cart'][$productId]);
        }
    }
    header("Location: cart.php");
    exit();
}

// Обработка удаления товара из корзины
if (isset($_GET['remove'])) {
    $productId = intval($_GET['remove']);
    unset($_SESSION['cart'][$productId]);
    header("Location: cart.php");
    exit();
}

// Функция для расчета общей суммы корзины
function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Получаем корзину из сессии
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

// Рассчитываем общую сумму
$total = calculateTotal($cart);

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
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Подключите ваш CSS файл -->
    <?php include 'header.php'; ?>
</head>
<body>
<div class="container">
        <h1>Корзина</h1>

        <?php if (empty($cart)): ?>
    <p>Ваша корзина пуста.</p>
<?php else: ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $productId => $item): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td><?php echo htmlspecialchars(number_format($item['price'], 2)); ?> руб.</td>
                        <td>
                            <input type="number" name="quantity[<?php echo $productId; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="0">
                        </td>
                        <td><?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?> руб.</td>
                        <td><a href="cart.php?remove=<?php echo $productId; ?>">Удалить</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Итого:</td>
                    <td><?php echo htmlspecialchars(number_format($total, 2)); ?> руб.</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <button type="submit" name="update_cart">Обновить корзину</button>
                        <a href="checkout.php">Оформить заказ</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
<?php endif; ?>
    </div>

     <?php include 'footer.php'; ?>

</body>
</html>