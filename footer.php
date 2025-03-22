<?php

date_default_timezone_set('Europe/Moscow');


$currentYear = date("Y");
$currentTime = date("H:i:s"); 
?>

<footer>
    <div class="footer-content">
        <p>&copy; 1927 Bakery - <?php echo $currentYear; ?></p>
        <p>Текущее время: <?php echo $currentTime; ?></p>
        <p>+9(999)999-99-99</p>
        <p>info@example.com</p>
    
    </div>
</footer>