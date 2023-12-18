let searchForm = document.querySelector('.search-form');

document.querySelector('#search-button').onclick = () =>{
    searchForm.classList.toggle('active');
    loginForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
}

let shoppingCart = document.querySelector('.shopping-cart');

document.querySelector('#cart-button').onclick = () =>{
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
    navbar.classList.remove('active');
    shoppingCart.classList.toggle('active');
}

let loginForm = document.querySelector('.login-form');

document.querySelector('#user-button').onclick = () =>{
    loginForm.classList.toggle('active');
    searchForm.classList.remove('active');
    shoppingCart.classList.remove('active');
    navbar.classList.remove('active');
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

let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

function addToCart(event) {
    let itemContainer = event.target.parentElement;

    let productName = itemContainer.querySelector('.product-name').innerText;
    let productPrice = itemContainer.querySelector('.price').textContent;
    let productMaxQuantity = itemContainer.querySelector('.cantitateMaxima').textContent;
    let stockNumber = parseInt(productMaxQuantity.match(/\d+/)[0], 10);
    let productImage = itemContainer.querySelector('.product-image').getAttribute('src');

    let existingCartItem = cartItems.find(item => item.name === productName);

    if (existingCartItem) {
        if(existingCartItem.quantity < existingCartItem.maxQuantity) {
            existingCartItem.quantity = parseInt(existingCartItem.quantity, 10) + 1;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            updateCart();
        }
    } else {
        let newCartItem = {
            name: productName,
            price: productPrice,
            quantity: 1,
            image: productImage,
            maxQuantity: stockNumber
        };
        cartItems.push(newCartItem);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
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
            <i class="fas fa-cart-plus" onclick="addToCheckout2(${index})"></i>
            <i class="fas fa-trash" onclick="removeFromCart2(${index})"></i>
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

    localStorage.setItem('cartItems', JSON.stringify(cartItems));

    let totalElement = document.createElement('div');
    totalElement.className = 'total';
    totalElement.textContent = `Total: ${totalPrice.toFixed(2)} RON`;
    shoppingCart.appendChild(totalElement);

    let checkoutButton = document.createElement('a');
    if(cartItems.length > 0) {
        checkoutButton.href = 'checkout.php';
    } else {
        checkoutButton.href = '#';
    }
    checkoutButton.className = 'button';
    checkoutButton.textContent = 'Checkout';
    shoppingCart.appendChild(checkoutButton);
    checkoutForm.querySelector('#cart-items-input').value = JSON.stringify(cartItems);
}


function addToCheckout2(index) {
    if(cartItems[index].quantity < cartItems[index].maxQuantity) {
        cartItems[index].quantity = parseInt(cartItems[index].quantity, 10) + 1;
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCart();
    }
}

updateCart();

function removeFromCart2(index) {
    cartItems[index].quantity = parseInt(cartItems[index].quantity, 10) - 1;
    if (cartItems[index].quantity == 0) {
        cartItems.splice(index, 1); 
    }
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    updateCart(); 
}

