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
    successMessage.style.display = 'none'; /
    form.parentNode.insertBefore(successMessage, form.nextSibling); 

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        fetch('process_contact_form.php', { //обработка данных формы не реализована(
            method: 'POST',
            body: new FormData(form) 
        })
        .then(response => {
            if (response.ok) {
                return response.text(); 
            } else {
                throw new Error('Ошибка отправки формы.');
            }
        })
        .then(data => {
            console.log(data); 

            successMessage.style.display = 'block';

            
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