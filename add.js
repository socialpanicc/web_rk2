document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const productId = this.dataset.productId;
            const quantity = 1; 

            console.log('Отправляем POST запрос', productId, quantity); 

            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `add_to_cart=1&product_id=${productId}&quantity=${quantity}`,
            })
            .then(response => {
                console.log('Ответ сервера (response):', response); 
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`); 
                }
                return response.json(); 
            })
            .then(data => {
                console.log('JSON данные (data):', data); 

                if (data.status === 'success') {
                    console.log(data.message); 
                    alert(data.message);
                    updateCartWidget(); 

                } else {
                    console.error('Ошибка от сервера:', data.message);
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка при запросе (catch):', error); 
                alert('Произошла ошибка при добавлении товара в корзину.  Пожалуйста, попробуйте позже.');
            });
        });
    });

    
});