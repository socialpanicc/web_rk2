<?php include 'header.php'; ?>

<section class="contact-us">
    <h2>Свяжитесь с нами</h2>
    <div class="contact-info">
        <p><b>Адрес:</b> улица Пушкина дом Колотушкина</p>
        <p><b>Телефон:</b> +9(999)999-99-99</p>
        <p><b>Email:</b> <a href="mailto:info@example.com">info@example.com</a></p>
    </div>

    <form class="contact-form" id="contactForm">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Сообщение:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Отправить</button>

        
    </form>
</section>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const successMessage = document.createElement('p');
    successMessage.style.color = 'green';
    successMessage.textContent = 'Форма успешно отправлена!';
    successMessage.style.display = 'none'; // Скрываем сообщение по умолчанию
    form.parentNode.insertBefore(successMessage, form.nextSibling); // Добавляем сообщение после формы

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        // Отправляем данные формы на сервер с использованием AJAX
        fetch('process_contact_form.php', { // Замените 'process_contact_form.php' на URL вашего обработчика
            method: 'POST',
            body: new FormData(form) // Создаем объект FormData из формы
        })
        .then(response => {
            if (response.ok) {
                return response.text(); // Или response.json(), если сервер возвращает JSON
            } else {
                throw new Error('Ошибка отправки формы.');
            }
        })
        .then(data => {
            console.log(data); // Выводим ответ от сервера (для отладки)

            // Показываем сообщение об успехе
            successMessage.style.display = 'block';

            // Скрываем сообщение через некоторое время (например, через 3 секунды)
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000);

            form.reset(); // Очищаем форму
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже.');
        });
    });
});
</script>