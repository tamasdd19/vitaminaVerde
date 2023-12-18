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
        <a href="#" class="logo"><i class="fas fa-shopping-basket"></i> Vitamina<span>Verde</span></a>
        <nav class="navbar">
        <a href="#">acasă</a>
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
        <div class="total">Total: 0 RON</div>
        <a href="#" class="button">Checkout</a>
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
    


    <section class="acasa" id="acasa">
        <div class="content">
            <h3>Vitamina<span>Verde</span>: pasiunea pentru prospețime</h3>
            <p>Produse proaspete și organice pentru sănătatea ta.</p>
            <a href="produse.php" class="button">cumpară acum!</a>
        </div>
    </section>


    <section class="features" id="features">

        <h1 class="heading"> <span>caracteristicile</span> noastre </h1>

        <div class="box-container">

            <div class="box">
                <img src="img/features-img-1.webp" alt="">
                <h3>proaspăt și organic</h3>
                <p>Prosperitate prin prospetime și organicitate, magazinul dedicat produselor proaspete și organice pentru un stil de viață sănătos.</p>
            </div>
            <div class="box">
                <img src="img/features-img-2.jpg" alt="">
                <h3>livrare gratuită</h3>
                <p>Prospetime livrată gratuit, bucuria de a-ți oferi produse proaspete și organice, fără costuri suplimentare de transport.</p>
            </div>
            <div class="box">
                <img src="img/features-img-3.avif" alt="">
                <h3>ușor de plătit</h3>
                <p>Plăți simplificate, experiență de cumpărare fără efort, cu opțiuni ușoare și rapide de plată.</p>
            </div>

        </div>
    </section>

    <section class="features" id="produse">

        <h1 class="heading"> Câteva dintre <span>produsele</span> noastre </h1>

            <div class="box-container">

            <?php

                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "ewd";

                $conn = mysqli_connect($servername, $username, $password, $database);

                if (!$conn) {
                    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Eroare la interogare: " . mysqli_error($conn));
                }

                $counter = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $nume = $row['name'];
                    $pret = $row['price'];
                    $cantitate = $row['quantity'];

                    if($cantitate) {
                        echo '<div class="box">';
                        echo '<div class="item">';
                        echo '<img src="img/'.$nume.'.jpg" alt="fileNotFound" class="product-image">';
                        echo '<h3 class="product-name">'.$nume.'</h3>';
                        echo '<div class="price">'.$pret.' RON/kg</div>';
                        echo '<div class="cantitateMaxima">Stock:'.$cantitate.'</div>';
                        echo '
                            <button class="button" onclick="addToCart(event)">adauga in cos</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                    $counter++;
                    if($counter == 3)
                        break;
                }

                ?>

            </div>

    </section>







    <script src="js/script.js"></script>

</body>
</html>