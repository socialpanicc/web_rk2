document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const productId = this.dataset.productId;
            const quantity = 1; // Или получите количество из другого элемента

            console.log('Отправляем POST запрос', productId, quantity); // Проверяем значения

            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `add_to_cart=1&product_id=${productId}&quantity=${quantity}`,
            })
            .then(response => {
                console.log('Ответ сервера (response):', response); // Посмотрим на весь response

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`); // Бросаем ошибку, если status не 200-299
                }
                return response.json(); // Парсим JSON
            })
            .then(data => {
                console.log('JSON данные (data):', data); // Проверяем JSON

                if (data.status === 'success') {
                    console.log(data.message); // Сообщение об успехе
                    alert(data.message);
                    updateCartWidget(); // Обновляем виджет корзины, если он есть

                } else {
                    console.error('Ошибка от сервера:', data.message); // Сообщение об ошибке от сервера
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка при запросе (catch):', error); // Ловим ошибки сети, парсинга JSON и т.д.
                alert('Произошла ошибка при добавлении товара в корзину.  Пожалуйста, попробуйте позже.');
            });
        });
    });

    function updateCartWidget() {
        //  Функция обновления виджета корзины (реализуйте ее, если нужно)
        //  Например, отправка запроса к get_cart_data.php и обновление элементов на странице
        console.log("Обновляем виджет корзины.  Вам нужно реализовать эту функцию.");
    }
});