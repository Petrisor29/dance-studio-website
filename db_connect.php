<?php
// Datele de configurare pentru serverul local XAMPP
$servername = "localhost";
$username = "root"; // Utilizatorul standard in XAMPP
$password = "";     // Parola este goala by default in XAMPP
$dbname = "scoala_dans";

// Crearea conexiunii folosind extensia MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a esuat: " . $conn->connect_error);
}


 // echo "Conectat cu succes la baza de date!";
?>