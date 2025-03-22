<?php include 'header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Свежая выпечка каждый день!</h1>
        <p>Насладитесь неповторимым вкусом нашей ароматной выпечки, приготовленной с любовью и только из натуральных ингредиентов.</p>
        <a href="products.php" class="cta-button">Смотреть нашу выпечку</a>
    </div>
</section>


<section class="featured-products">
    <h2>Наши хиты</h2>
    <div class="product-grid">
        <?php
        include 'db_config.php';

        $sql = "SELECT * FROM products WHERE featured = 1 LIMIT 3";
        $result = $conn->query($sql);
   
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href=\"product.php?id=" . htmlspecialchars($row['id']) . "\" class=\"product-link\">"; // Оборачиваем div в ссылку
        echo "<div class=\"product\">";
        echo "<img src=\"" . htmlspecialchars($row["image"]) . "\" alt=\"" . htmlspecialchars($row["name"]) . "\">";
        echo "<h3>" . htmlspecialchars($row["name"]) . "</h3>";
        echo "<p class=\"price\">Цена: " . htmlspecialchars($row["price"]) . " руб.</p>";
        echo "<p>" . htmlspecialchars($row["short_description"]) . "</p>";
        echo "</div>";
        echo "</a>"; 
    }
} else {
    echo "<p>Избранных товаров не найдено.</p>";
}
        $conn->close();
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>