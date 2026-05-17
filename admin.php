<?php
session_start();

if (!isset($_SESSION['admin_logat']) || $_SESSION['admin_logat'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php';

// Variabila pentru a afisa mesaje de succes sau eroare
$mesaj = "";

// --- LOGICA DE ADAUGARE (CREATE) ---
// Verificam daca s-a apasat butonul de "Salveaza Instructor"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adauga_instructor'])) {
    $nume = trim($_POST['nume']);
    $specializare = trim($_POST['specializare']);
    $descriere = trim($_POST['descriere']);

    // Validare simpla pe server: ne asiguram ca nu sunt goale
    if (!empty($nume) && !empty($specializare) && !empty($descriere)) {
        // Folosim Prepared Statements pentru siguranta
        $stmt = $conn->prepare("INSERT INTO instructori (nume, specializare, descriere) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $specializare, $descriere);
        
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Instructor adaugat cu succes in baza de date!</p>";
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Eroare la adaugare: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        $mesaj = "<p style='color: red; font-weight: bold;'>Toate campurile sunt obligatorii!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Panou Administrare</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-container { max-width: 1000px; margin: 40px auto; padding: 20px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .admin-nav { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eee; }
        .admin-nav a { margin-right: 15px; text-decoration: none; color: #2c3e50; font-weight: bold; }
        .admin-nav a:hover { color: #e74c3c; }
        .btn-logout { float: right; background-color: #333; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none;}
        .btn-logout:hover { background-color: #000; }
        .form-box { background: #f9f9f9; padding: 15px; border: 1px solid #ccc; margin-bottom: 20px; border-radius: 5px;}
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .admin-table th, .admin-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .admin-table th { background: #2c3e50; color: white; }
    </style>
</head>
<body>

    <div class="admin-container">
        <a href="logout.php" class="btn-logout">Delogare</a>
        <h2>Bun venit, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <div class="admin-nav">
            <a href="admin.php?sectiune=instructori">Gestionare Instructori</a>
            <a href="admin.php?sectiune=cursuri">Gestionare Cursuri</a>
            <a href="admin.php?sectiune=evenimente">Gestionare Evenimente</a>
            <a href="index.php" target="_blank">Vezi Site-ul Public</a>
        </div>

        <div class="admin-content">
            <?php
            $sectiune = isset($_GET['sectiune']) ? $_GET['sectiune'] : 'dashboard';

            if ($sectiune == 'dashboard') {
                echo "<h3>Alege o sectiune din meniul de mai sus pentru a incepe.</h3>";
            } 
            // SECTIUNEA INSTRUCTORI
            elseif ($sectiune == 'instructori') {
                echo "<h3>Gestionare Instructori</h3>";
                echo $mesaj; // Afisam mesajul de succes/eroare daca exista
                ?>
                
                <div class="form-box">
                    <h4>Adauga un instructor nou</h4><br>
                    <form method="POST" action="admin.php?sectiune=instructori">
                        <input type="hidden" name="adauga_instructor" value="1">
                        
                        <label>Nume Instructor:</label><br>
                        <input type="text" name="nume" required><br><br>
                        
                        <label>Specializare (ex: Dans Sportiv, Hip-Hop):</label><br>
                        <input type="text" name="specializare" required><br><br>
                        
                        <label>Descriere (experienta, stil de predare):</label><br>
                        <textarea name="descriere" rows="4" required></textarea><br>
                        
                        <button type="submit">Salveaza Instructor</button>
                    </form>
                </div>

                <h4>Lista Instructori Existenti</h4>
                <table class="admin-table">
                    <tr>
                        <th>ID</th>
                        <th>Nume</th>
                        <th>Specializare</th>
                        <th>Descriere</th>
                        <th>Actiuni</th>
                    </tr>
                    <?php
                    // --- LOGICA DE CITIRE (READ) ---
                    $sql = "SELECT * FROM instructori ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Parcurgem fiecare rand gasit in baza de date
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            // htmlspecialchars previne atacurile de tip XSS
                            echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['specializare']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['descriere']) . "</td>";
                            echo "<td><i>[Butoane Edit/Delete In Curand]</i></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>Nu exista instructori adaugati inca.</td></tr>";
                    }
                    ?>
                </table>

                <?php
            } 
            else {
                echo "<h3>Momentan construim sectiunea: " . htmlspecialchars($sectiune) . "</h3>";
            }
            ?>
        </div>
    </div>

</body>
</html>