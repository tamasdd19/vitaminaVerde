let searchForm = document.querySelector('.search-form');

document.querySelector('#search-button').onclick = () =>{
    searchForm.classList.toggle('active');
    loginForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
}

let shoppingCart = document.querySelector('.shopping-cart');
let checkoutForm = document.querySelector('.checkout-form');

document.querySelector('#cart-button').onclick = () =>{
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
    shoppingCart.classList.toggle('active');
    checkoutForm.classList.add('active');
}

let loginForm = document.querySelector('.login-form');

document.querySelector('#user-button').onclick = () =>{
    loginForm.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
    checkoutForm.classList.remove('active');
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-button').onclick = () =>{
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    shoppingCart.classList.remove('active');
}

window.onscroll = () => {
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    // shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
}

let cartItems = [];

function addToCart(event) {
    let itemContainer = event.target.parentElement;

    let productName = itemContainer.querySelector('.product-name').innerText;
    let productPrice = itemContainer.querySelector('.price').textContent;
    let productImage = itemContainer.querySelector('.product-image').getAttribute('src');

    let existingCartItem = cartItems.find(item => item.name === productName);

    if (existingCartItem) {
        existingCartItem.quantity += 1;
        updateCart();
    } else {
        let newCartItem = {
            name: productName,
            price: productPrice,
            quantity: 1,
            image: productImage
        };
        cartItems.push(newCartItem);
        updateCart();
    }
}

function updateCart() {
    shoppingCart.innerHTML = '';

    let totalPrice = 0;

    cartItems.forEach((item, index) => {
        let cartItem = document.createElement('div');
        cartItem.className = 'box';
        cartItem.innerHTML = `
            <i class="fas fa-trash" onclick="removeFromCart(${index})"></i>
            <img src="${item.image}" alt="${item.name}">
            <div class="content">
                <h3>${item.name}</h3>
                <span class="pret">${item.price}</span>
                <span class="cantitate">cantitate: ${item.quantity} kg</span>
            </div>
        `;
        shoppingCart.appendChild(cartItem);

        let price = parseFloat(item.price.replace(/[^\d.]/g, ''));
        totalPrice += price * item.quantity;
    });

    let totalElement = document.createElement('div');
    totalElement.className = 'total';
    totalElement.textContent = `Total: ${totalPrice.toFixed(2)} RON`;
    shoppingCart.appendChild(totalElement);

    let checkoutButton = document.createElement('a');
    checkoutButton.href = '#';
    checkoutButton.className = 'button';
    checkoutButton.textContent = 'Checkout';
    shoppingCart.appendChild(checkoutButton);
    checkoutForm.querySelector('#cart-items-input').value = JSON.stringify(cartItems);
}

function removeFromCart(index) {
    cartItems.splice(index, 1); 
    updateCart(); 
}

checkoutForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Here, you can send the cart items to the server using AJAX or any other method
    // For simplicity, I'll log the cart items to the console
    console.log(JSON.parse(checkoutForm.querySelector('#cart-items-input').value));

    // You can add code here to handle the server-side processing of the order
    // (e.g., sending data to a server using fetch or XMLHttpRequest)
});

