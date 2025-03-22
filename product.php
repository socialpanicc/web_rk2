<?php

include 'db_config.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']); 

   
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc(); 
        
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
                        <div class="description-block"> 
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>
                        <p>В наличии: <?php echo htmlspecialchars($product['amount']); ?> шт.</p>

                        <?php if ($product['amount'] > 0) { ?>
                          
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

  
    if (isset($conn) && $conn) { 
    $conn->close();
    }
    ?>