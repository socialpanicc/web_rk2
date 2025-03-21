<?php
// Получаем текущую дату и время
$currentYear = date("Y");
$currentTime = date("H:i:s"); // Формат: часы:минуты:секунды
?>

<footer>
    <div class="footer-content">
        <p>&copy; 1927 Bakery - <?php echo $currentYear; ?></p>
        <p>Текущее время: <?php echo $currentTime; ?></p>
        <p>+9(999)999-99-99</p>
        <p>info@example.com</p>
    
    </div>
</footer>