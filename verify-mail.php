<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "ewd";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT * FROM users WHERE verify_token='$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['id'];

        // Actualizare înregistrare pentru a marca utilizatorul ca verificat
        $updateSql = "UPDATE users SET is_verified = 1 WHERE id = '$userId'";
        if ($conn->query($updateSql) === TRUE) {
            // Utilizatorul a fost verificat cu succes
            $_SESSION['is_verified'] = 1;
        } else {
            $_SESSION['error'] = 'Eroare la verificarea contului: ' . $conn->error;
            header('Location: error.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Token invalid. Contul nu a putut fi verificat.';
        header('Location: error.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Token lipsă. Contul nu a putut fi verificat.';
    header('Location: error.php');
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitaminaVerde - Inregistrare cu Succes</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css?v=123456">

    <style>
        .success-message {
            text-align: center;
            margin-top: 100px;
            padding: 20px;
            background-color: #4caf50;
            color: #fff;
            border-radius: 5px;
        }

        .success-message i {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .success-message p {
            font-size: 18px;
        }
    </style>
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
                        echo '<p>Nu ai cont? <a href="register.php">Creaza-ti Unul</a></p>';
            echo '<input type="submit" value="Conecteaza-te Acum" class="button">';
            echo '</form>';
        }
        ?>
    </header>

    <div class="success-message">
        <i class="fas fa-check-circle"></i>
        <p>Înregistrare cu succes! Bine ai venit pe VitaminaVerde.</p>
        <a href="index.php" class="button">Înapoi la Pagina Principală</a>
    </div>

    <script src="js/script.js"></script>

</body>

</html>
