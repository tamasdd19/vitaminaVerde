<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitaminaVerde</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo"><i class="fas fa-shopping-basket"></i> Vitamina<span>Verde</span></a>
        <nav class="navbar">
        <a href="index.php">acasă</a>
        <a href="produse.php">produse</a>
        <a href="categorii.php">categorii</a>
        
        </nav>
        <div class="icons">
        <div class="fas fa-bars" id="menu-button"></div>
        <div class="fas fa-search" id="search-button"></div>
        <div class="fas fa-shopping-cart" id="cart-button"></div>
        <div class="fas fa-user" id="user-button"></div>
        </div>
        <form action="search.php" method="GET" class="search-form">
            <input type="search" name="searchTerm" id="search-box" placeholder="cauta aici...">
            <button for="search-box" class="fas fa-search"></button>
        </form>
        <div class="shopping-cart">
        </div>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            // User-ul este logat
            echo '<div class="login-form">';
            echo '<p>Bine ai venit, <span>' . $_SESSION['username'] . '<span>!</p>';
            echo '<a href="logout.php" class="button">Log Out</a>';
            echo '</div>';
        } 
        else {
            // User-ul nu este logat
            echo '<form action="login.php" method="POST" class="login-form">';
            echo '<h3>Intra in cont</h3>';
            if(isset($_SESSION['error'])){
                echo '<p> ' . $_SESSION['error'] . '</p>';
                echo "<script> loginForm.classList.toggle('active'); </script>";
            }
            echo '<input type="hidden" name="current_page" value="' . $_SERVER["REQUEST_URI"] . '">';
            echo '<input type="email" name="email" placeholder="email" class="box">';
            echo '<input type="password" name="password" placeholder="parola" class="box">';
            echo '<p>Ti-ai uitat parola? <a href="forgotPassword.php">Apasa Aici</a></p>';
            echo '<p>Nu ai cont? <a href="register.php">Creaza-ti Unul</a></p>';
            echo '<input type="submit" value="Conecteaza-te Acum" class="button">';
            echo '</form>';
        }
        ?>
    </header>
    
    <section class="register-section" id="checkout-section">
        <div class="register-form" id="checkout-form">
            <h2>Finalizare Comandă</h2>

            <!-- Display cart items here -->
            <div class="shopping-cart" id="cart-items-container">
                <!-- Cart items will be dynamically inserted here using JavaScript -->
            </div>

            <?php
            // Display errors or success messages
            if (isset($error)) {
                echo '<div class="error">' . $error . '</div>';
            } elseif (isset($success)) {
                echo '<div class="success">' . $success . '</div>';
            }
            ?>

            <form id="couponForm">
                <label for="coupon">Aplică cupon:</label>
                <input type="text" name="coupon" id="coupon" optional>
                <input type="submit" value="Aplică cupon" id="couponSubmit">
            </form>
            <br>
            <form onsubmit="confirmareComanda(); reset(); return false;" id="confirmForm">
                <label for="nume">Nume:</label>
                <input type="text" name="nume" id="nume" required>

                <label for="prenume">Prenume:</label>
                <input type="text" name="prenume" id="prenume" required>

                <label for="address">Adresă:</label>
                <input type="text" name="address" id="address" required>

                <label for="oras">Oraș:</label>
                <input type="text" name="oras" id="oras" required>

                <label for="codPostal">Cod poștal:</label>
                <input type="number" name="codPostal" id="codPostal" required>

                <label for="phone">Număr de telefon:</label>
                <input type="tel" name="phone" id="phone" required>

                <!-- Additional checkout fields can be added here -->

                <input type="submit" value="Finalizează Comanda">
            </form>
        </div>
    </section>

    <script>
        let reducere = 0;

        document.getElementById('couponForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne trimiterea formularului

            var couponValue = document.getElementById('coupon').value;

            if (couponValue === 'EXEMPLU10') {
                if (reducere != 10){
                    reducere = 10;
                    updateCheckout();
                    alert('Reducerea de 10% a fost aplicata!');
                }
                else {
                    alert('Cuponul este deja aplicat');
                }
            } else {
                    alert('Cupon invalid');
            }
        });

        function updateCheckout() {
            // Get cart items from local storage
            let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

            // Display cart items in the checkout form
            let shoppingCart = document.getElementById('cart-items-container');
            shoppingCart.innerHTML = '';

            let totalPrice = 0;

            cartItems.forEach((item, index) => {
                let cartItem = document.createElement('div');
                cartItem.className = 'box';
                cartItem.innerHTML = `
                    <i class="fas fa-trash" onclick="removeFromCheckout(${index})"></i>
                    <i class="fas fa-cart-plus" onclick="addToCheckout(${index})"></i>
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
            if (reducere != 0) {
                let discountedPrice = totalPrice - totalPrice * (reducere / 100);
                totalElement.textContent = `Total: ${discountedPrice.toFixed(2)} RON`;
            } else {
                totalElement.textContent = `Total: ${totalPrice.toFixed(2)} RON`;
            }
            shoppingCart.appendChild(totalElement);
        }

        function removeFromCheckout(index) {
            cartItems[index].quantity = parseInt(cartItems[index].quantity, 10) - 1;
            if (cartItems[index].quantity == 0) {
                cartItems.splice(index, 1); 
            }
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            updateCheckout(); 
            updateCart();
        }

        function addToCheckout(index) {
            cartItems[index].quantity = parseInt(cartItems[index].quantity, 10) + 1;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            updateCheckout(); 
            updateCart();
        }
        document.addEventListener('DOMContentLoaded', updateCheckout());
        updateCheckout();
    </script>

    <script src="js/script.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>

    <script>
function confirmareComanda() {
    var numeClient = document.getElementById('nume').value;
    var prenumeClient = document.getElementById('prenume').value;
    var telefonClient = document.getElementById('phone').value;
    var adresaClient = document.getElementById('address').value;
    var orasClient = document.getElementById('oras').value;
    var codPostal = document.getElementById('codPostal').value;
    // Obține produsele din coșul de cumpărături (așa cum ai făcut în scriptul tău existent)
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    Email.send({
        Host : "smtp.elasticemail.com",
        Username : "shoptrendlybox@gmail.com",
        Password : "6737D21BAA75F452D751E0B22188A182D628",
        To : 'andreitm20@gmail.com',
        From : "shoptrendlybox@gmail.com",
        Subject : "Confirmare comandă",
        Body : `
            <html lang="ro">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Email de Confirmare</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        margin: 0;
                        padding: 0;
                    }

                    .container {
                        max-width: 600px;
                        margin: 20px auto;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                    }

                    h2 {
                        color: #4caf50;
                    }

                    p {
                        margin-bottom: 15px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Email de Confirmare</h2>
                    <p>Dragă ${numeClient} ${prenumeClient},</p>
                    <p>Mulțumim pentru comanda plasată la VitaminaVerde! Comanda ta a fost primită și este în curs de procesare.</p>
                    <p>Detalii Comandă:</p>
                    <ul>
                        <!-- Loop prin produsele comandate și afișare -->
                        <!-- Înlocuiește valorile de exemplu cu detalii reale ale comenzii -->
                        <li>Nume Produs 1 - Cantitate: 2 - Preț: 20.00 RON</li>
                        <li>Nume Produs 2 - Cantitate: 1 - Preț: 15.00 RON</li>
                        <!-- Adaugă mai multe elemente după nevoie -->
                    </ul>
                    <p>Suma Totală: [Suma Totala] RON</p>
                    <p>Comanda ta va fi expediată la adresa următoare:</p>
                    <p>${numeClient} ${prenumeClient}<br>${adresaClient}<br>${orasClient} ${codPostal}<br>România</p>
                    <p>Dacă ai întrebări sau nelămuriri, te rugăm să ne contactezi.</p>
                    <p>Mulțumim că ai ales VitaminaVerde! Apreciam afacerea ta.</p>
                    <hr>
                    <p>Acesta este un email automatizat. Te rugăm să nu răspunzi la acest mesaj.</p>
                </div>
            </body>
            </html>
        `,
    }).then(
        message => alert(message)
    );
}

    </script>
</body>
</html>

