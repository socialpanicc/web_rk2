<?php include 'header.php'; ?>

<section class="products">
    <h2>Наша выпечка</h2>
    <div class="product-grid">
    <?php
// Подключение к базе данных
include 'db_config.php';

// 1. Получение `category_id` из GET-параметра (для отображения товаров)
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// 2. Получение информации о категории (если categoryId задан)
$categoryName = null; // Инициализируем переменную
if ($categoryId !== null) {
    $sqlCategory = "SELECT name FROM categories WHERE id = ?";
    $stmtCategory = $conn->prepare($sqlCategory);
    $stmtCategory->bind_param("i", $categoryId);
    $stmtCategory->execute();
    $resultCategory = $stmtCategory->get_result();

    if ($resultCategory->num_rows == 1) {
        $categoryData = $resultCategory->fetch_assoc();
        $categoryName = $categoryData['name'];
    } else {
        $categoryName = "Неизвестная категория"; // Или другое сообщение об ошибке
    }
    $stmtCategory->close();
}

// 3. Отображение категорий (только если categoryId не задан)
if ($categoryId === null) {
    $sqlCategories = "SELECT * FROM categories";
    $resultCategories = $conn->query($sqlCategories);

    echo "<div class=\"categories-container\">"; // Контейнер для категорий

    if ($resultCategories->num_rows > 0) {
        while ($category = $resultCategories->fetch_assoc()) {
            echo "<a href=\"?category_id=" . htmlspecialchars($category['id']) . "\" class=\"category-link product-link\">"; // Оборачиваем в ссылку (как product-link)
            echo "<div class=\"product category-product\">"; // Используем класс product, но добавляем класс category-product для стилизации
            echo "<img src=\"" . htmlspecialchars($category["image"]) . "\" alt=\"" . htmlspecialchars($category["name"]) . "\">"; // Отображаем картинку категории
            echo "<h3>" . htmlspecialchars($category["name"]) . "</h3>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "<p>Категории не найдены.</p>";
    }

    echo "</div>";
}

// 4. Отображение товаров (если выбрана категория)
if ($categoryId !== null) {
    echo "<h2 class=\"products-title\">Товары в категории:  " . htmlspecialchars($categoryName) . "</h2>"; // Отображаем название выбранной категории
    echo "<div class=\"products-container\">";
    $sqlProducts = "SELECT * FROM products WHERE category_id = " . $categoryId;
    $resultProducts = $conn->query($sqlProducts);

    if ($resultProducts->num_rows > 0) {
        while ($row = $resultProducts->fetch_assoc()) {
            echo "<a href=\"product.php?id=" . htmlspecialchars($row['id']) . "\" class=\"product-link\">";
            echo "<div class=\"product\">";
            echo "<img src=\"" . htmlspecialchars($row["image"]) . "\" alt=\"" . htmlspecialchars($row["name"]) . "\">";
            echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
            echo "<p class=\"price\">Цена: " . htmlspecialchars($row["price"]) . " руб.</p>";
            echo "<p>" . htmlspecialchars($row["short_description"]) . "</p>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "<p>Товары не найдены в этой категории.</p>";
    }
    echo "</div>";
}
?>

<?php include 'footer.php'; ?>