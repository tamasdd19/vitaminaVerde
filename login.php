<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    // User is already logged in, redirect to the desired page
    header('Location: ' . $_POST['current_page']);
    exit();
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

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Authentication successful, set session variables and redirect to the desired page
            $_SESSION['username'] = $row['username'];
            $_SESSION['message'] = "Autentificare reușită. Bine ai venit, " . $row['username'] . "!";
            $_SESSION['email'] = $email;
            header('Location: ' . $_POST['current_page']);
            exit();
        } else {
            $error = "Parola introdusă este incorectă.";
        }
    } else {
        $error = "Adresa de email nu este înregistrată.";
    }

    // Store the error message in a session variable
    $_SESSION['error'] = $error;

    $conn->close();
}

header('Location: ' . $_POST['current_page']);
exit();
?>
