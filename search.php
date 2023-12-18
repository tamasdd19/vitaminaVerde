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
        <div class="total">Total: 0 RON</div>
        <a href="#" class="button">Checkout</a>
        </div>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            // User is logged in
            echo '<div class="login-form">';
            echo '<p>Bine ai venit, <span>' . $_SESSION['username'] . '<span>!</p>';
            echo '<a href="logout.php" class="button">Log Out</a>';
            echo '</div>';
        } else {
            // User is not logged in
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

    <section class="features" id="produse">

        <h1 class="heading"> <span>Rezultatele</span> cautarii:</h1>
        <div class="box-container">
    <?php
    // Check if a search term is provided
    if (isset($_GET['searchTerm'])) {
        // Retrieve the search term
        $searchTerm = $_GET['searchTerm'];

        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'ewd');

        // Check the connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare the query to search for products
        $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if any results are found
        if (mysqli_num_rows($result) > 0) {

            // Display the search results
            while ($row = mysqli_fetch_assoc($result)) {
                $nume = $row['name'];
                $pret = $row['price'];
                $cantitate = $row['quantity'];
                
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
        } else {
            echo "<p class='heading'>Niciun rezultat gasit.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
    </div>
    </section>

    <script src="js/script.js"></script>
</body>
</html>
