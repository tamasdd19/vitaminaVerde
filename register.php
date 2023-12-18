<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_email($username, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();        
    $mail->SMTPAuth   = true;                                       //Send using SMTP
    $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through                              //Enable SMTP authentication
    $mail->Username   = 'shoptrendlybox@gmail.com';                     //SMTP username
    $mail->Password   = '6737D21BAA75F452D751E0B22188A182D628';                               //SMTP password
    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('shoptrendlybox@gmail.com');
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmare adresa de email';
    $mail->Body    = '<!DOCTYPE html>
    <html lang="ro">
    
    <head>
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
                color: #333;
            }
    
            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                text-align: center;
                text-decoration: none;
                background-color: #4caf50;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }
    
            .button:hover {
                background-color: #45a049;
            }
    
            hr {
                border: 1px solid #ccc;
                margin: 15px 0;
            }
    
            .disclaimer {
                font-size: 12px;
                color: #888;
            }
        </style>
    </head>
    
    <body>
        <div class="container">
            <h2>Confirmare E-mail</h2>
            <p>Bună ziua, ' . $username . '!</p>
            <p>Vă mulțumim că v-ați înregistrat pe VitaminaVerde. Pentru a finaliza procesul de înregistrare, vă rugăm să confirmați adresa de e-mail.</p>
            <p>Pentru a confirma adresa de e-mail, apăsați butonul de mai jos:</p>
            <p><a href="http://localhost/vitaminaVerde/verify-mail.php?token=' . $verify_token . '" class="button">Confirmare E-mail</a></p>
            <hr>
            <p class="disclaimer">Acesta este un e-mail automatizat. Nu răspundeți la acest mesaj. Dacă nu v-ați înregistrat pe VitaminaVerde, ignorați acest e-mail.</p>
        </div>
    </body>
    
    </html>
    ';

    $mail->send();
    echo 'Message has been sent';
}

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
    $verify_token = md5(rand());

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

        $sql = "INSERT INTO users (username, email, password, verify_token) VALUES ('$username', '$email', '$hashedPassword', '$verify_token')";

        if ($conn->query($sql) === TRUE) {
            $success = "Înregistrare cu succes! Verifică adresa de email.";
            send_email($username, $email, $verify_token);
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
