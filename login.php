<?php
// Pornim sesiunea obligatoriu la inceputul fisierului
session_start();
require 'db_connect.php';

$eroare = "";

// Verificam daca formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Folosim Prepared Statements pentru a bloca complet orice tentativa de SQL Injection
    $stmt = $conn->prepare("SELECT id, password FROM utilizatori WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verificam daca parola introdusa se potriveste cu hash-ul din baza de date
        if (password_verify($pass, $row['password'])) {
            // Autentificare cu succes! Generam ecusonul de sesiune.
            $_SESSION['admin_logat'] = true;
            $_SESSION['username'] = $user;
            
            // Redirectionam catre panoul de control
            header("Location: admin.php");
            exit;
        } else {
            $eroare = "Parola incorecta!";
        }
    } else {
        $eroare = "Utilizatorul nu a fost gasit!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Administrator</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .error-msg {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Autentificare Admin</h2>
        
        <?php if($eroare != ""): ?>
            <p class="error-msg"><?php echo $eroare; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="username">Utilizator:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="password">Parola:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <button type="submit">Intra in cont</button>
        </form>
    </div>
</body>
</html>