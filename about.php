<?php include 'header.php'; ?>

<section class="about-us">
    <h2>О нашей пекарне</h2>
    <div class="about-content">

        <!-- Слайд-шоу -->
        <div class="slideshow-container">
            <div class="slide">
                <img src="https://i.pinimg.com/736x/0d/74/e7/0d74e703d70402ada9e8bc5548ef8729.jpg" alt="Интерьер пекарни 1">
            </div>
            <div class="slide">
                <img src="https://i.pinimg.com/736x/27/09/17/270917279673e5ffe00900ffcf28c19a.jpg" alt="Интерьер пекарни 2">
            </div>
            <div class="slide">
                <img src="https://i.pinimg.com/736x/5b/ce/d0/5bced01755f4b6a3ab8caab4eb08a30f.jpg" alt="Интерьер пекарни 3">
            </div>
        

            <!-- Кнопки навигации -->
            <a class="prev">&#10094;</a>
            <a class="next">&#10095;</a>

            <!-- Индикаторы (точки) -->
            <div class="dots-container"></div>
        </div>
        <!-- /Слайд-шоу -->

        <!-- Текст о пекарне -->
        <div class="bakery-text">
            <p>Мы - небольшая пекарня, которая с любовью создает свежую и ароматную выпечку каждый день.</p>
            <p>Мы используем только натуральные ингредиенты и проверенные рецепты, чтобы радовать наших клиентов неповторимым вкусом.</p>
            <p>Наша история началась в [год основания], когда мы открыли нашу первую пекарню в [местоположение]. С тех пор мы постоянно развиваемся и совершенствуем наши навыки, чтобы предлагать вам только лучшее.</p>
        </div>
    </div>
</section>

<script src="slideshow.js"></script> <!-- Подключение внешнего JavaScript файла -->

<?php include 'footer.php'; ?>