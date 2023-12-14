<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ewd";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
}

// Primește datele JSON de la client
$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $item) {
    $productName = $item['name'];
    $quantity = $item['quantity'];

    // Actualizează stocul în baza de date
    $sql = "UPDATE products SET quantity = quantity - $quantity WHERE name = '$productName'";

    if (!mysqli_query($conn, $sql)) {
        die("Eroare la actualizarea stocului: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>
