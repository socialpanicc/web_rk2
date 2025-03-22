<?php include 'header.php'; ?>

<section class="products">
    <h2>Наша выпечка</h2>
    <div class="product-grid">
    <?php

include 'db_config.php';


$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;


$categoryName = null; 
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
        $categoryName = "Неизвестная категория"; 
    }
    $stmtCategory->close();
}


if ($categoryId === null) {
    $sqlCategories = "SELECT * FROM categories";
    $resultCategories = $conn->query($sqlCategories);

    echo "<div class=\"categories-container\">"; 

    if ($resultCategories->num_rows > 0) {
        while ($category = $resultCategories->fetch_assoc()) {
            echo "<a href=\"?category_id=" . htmlspecialchars($category['id']) . "\" class=\"category-link product-link\">"; 
            echo "<div class=\"product category-product\">"; 
            echo "<img src=\"" . htmlspecialchars($category["image"]) . "\" alt=\"" . htmlspecialchars($category["name"]) . "\">"; 
            echo "<h3>" . htmlspecialchars($category["name"]) . "</h3>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "<p>Категории не найдены.</p>";
    }

    echo "</div>";
}


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