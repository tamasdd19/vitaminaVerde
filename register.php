<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ewd";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Conexiunea la baza de date a esuat: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkQuery);
    if ($result->num_rows > 0) {
        $error = "Numele de utilizator sau adresa de email exista deja.";
    }

    // Validate password and confirm password
    if ($password !== $confirmPassword) {
        $error = "Parola si confirmarea parolei nu se potrivesc.";
    }

    if (!isset($error)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $success = "Înregistrarea a fost realizată cu succes.";
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            header('Location: index.php');
        } else {
            $error = "Eroare la înregistrare: " . $conn->error;
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitaminaVerde - Înregistrare</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
    <header class="header">

        <a href="index.php" class="logo"><i class="fas fa-shopping-basket"></i> Vitamina<span>Verde</span> </a>

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

        <form action="" class="search-form">
            <input type="search" id="search-box" placeholder="cauta aici...">
            <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="shopping-cart">
            <div class="total">
              Total: 0 RON
            </div>
            <a href="#" class="button">Checkout</a>
          </div>

        <form action="" class="login-form">
            <h3>Intra in cont</h3>
            <input type="email" placeholder="email" class="box">
            <input type="password" placeholder="parola" class="box">
            <p>Ti-ai uitat parola? <a href="#">Apasa Aici</a></p>
            <p>Nu ai cont? <a href="#">Creaza-ti Unul</a></p>
            <input type="submit" value="Conecteaza-te Acum" class="button">
        </form>

    </header>
    <section class="register-section">
        <div class="register-form">
            <h2>Inregistrare</h2>
            <?php
            if (isset($error)) {
                echo '<div class="error">' . $error . '</div>';
            } elseif (isset($success)) {
                echo '<div class="success">' . $success . '</div>';
            }
            ?>
            <form action="register.php" method="POST">
                <input type="text" name="username" placeholder="Nume de utilizator" required>
                <input type="email" name="email" placeholder="Adresa de email" required>
                <input type="password" name="password" placeholder="Parola" required>
                <input type="password" name="confirm_password" placeholder="Confirma parola" required>
                <input type="submit" value="Înregistrare">
            </form>
        </div>
    </section>

</body>
</html>
