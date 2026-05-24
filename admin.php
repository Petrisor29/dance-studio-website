<?php
// Pornim sesiunea obligatoriu la inceputul fisierului
session_start();

if (!isset($_SESSION['admin_logat']) || $_SESSION['admin_logat'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php';

// Variabila pentru a afisa mesaje de succes sau eroare
$mesaj = "";

// --- LOGICA DE ADAUGARE (CREATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adauga_instructor'])) {
    $nume = trim($_POST['nume']);
    $specializare = trim($_POST['specializare']);
    $descriere = trim($_POST['descriere']);

    if (!empty($nume) && !empty($specializare) && !empty($descriere)) {
        $stmt = $conn->prepare("INSERT INTO instructori (nume, specializare, descriere) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $specializare, $descriere);
        
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Instructor adaugat cu succes!</p>";
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Eroare la adaugare: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        $mesaj = "<p style='color: red; font-weight: bold;'>Toate campurile sunt obligatorii la adaugare!</p>";
    }
}

// --- LOGICA DE MODIFICARE (UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editeaza_instructor'])) {
    $id = intval($_POST['id']);
    $nume = trim($_POST['nume']);
    $specializare = trim($_POST['specializare']);
    $descriere = trim($_POST['descriere']);

    if (!empty($id) && !empty($nume) && !empty($specializare) && !empty($descriere)) {
        $stmt = $conn->prepare("UPDATE instructori SET nume = ?, specializare = ?, descriere = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nume, $specializare, $descriere, $id);
        
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Datele instructorului au fost actualizate!</p>";
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Eroare la actualizare: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        $mesaj = "<p style='color: red; font-weight: bold;'>Toate campurile sunt obligatorii la modificare!</p>";
    }
}

// --- LOGICA DE STERGERE (DELETE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sterge_instructor'])) {
    $id = intval($_POST['id']);
    
    $stmt = $conn->prepare("DELETE FROM instructori WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mesaj = "<p style='color: green; font-weight: bold;'>Instructorul a fost sters din baza de date!</p>";
    } else {
        $mesaj = "<p style='color: red; font-weight: bold;'>Eroare la stergere: " . $conn->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
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
        .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-delete { background: none; border: none; color: #e74c3c; font-weight: bold; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit; }
    </style>
    
    <script>
        function valideazaFormular(formular) {
            var nume = formular.nume.value.trim();
            var specializare = formular.specializare.value.trim();
            var descriere = formular.descriere.value.trim();
            
            if (nume.length < 3) {
                alert("Numele trebuie sa aiba cel putin 3 caractere!");
                return false;
            }
            if (specializare.length < 3) {
                alert("Specializarea trebuie sa aiba cel putin 3 caractere!");
                return false;
            }
            if (descriere.length < 10) {
                alert("Descrierea trebuie sa fie mai detaliata (minim 10 caractere)!");
                return false;
            }
            return true;
        }

        function confirmaStergerea() {
            return confirm("Sigur doriti sa stergeti acest instructor? Actiunea este ireversibila!");
        }
    </script>
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
            
            // --- SECTIUNEA INSTRUCTORI ---
            elseif ($sectiune == 'instructori') {
                echo "<h3>Gestionare Instructori</h3>";
                echo $mesaj;

                // Verificam daca suntem in modul de editare (apasat butonul Editeaza din tabel)
                $mod_editare = false;
                $edit_id = ""; $edit_nume = ""; $edit_specializare = ""; $edit_descriere = "";

                if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
                    $id_cautat = intval($_GET['id']);
                    $stmt = $conn->prepare("SELECT * FROM instructori WHERE id = ?");
                    $stmt->bind_param("i", $id_cautat);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    
                    if ($res->num_rows === 1) {
                        $instructor_edit = $res->fetch_assoc();
                        $mod_editare = true;
                        $edit_id = $instructor_edit['id'];
                        $edit_nume = $instructor_edit['nume'];
                        $edit_specializare = $instructor_edit['specializare'];
                        $edit_descriere = $instructor_edit['descriere'];
                    }
                    $stmt->close();
                }

                if ($mod_editare): 
                ?>
                    <div class="form-box" style="border-left: 5px solid #3498db;">
                        <h4>Modifica datele instructorului: <?php echo htmlspecialchars($edit_nume); ?></h4><br>
                        <form method="POST" action="admin.php?sectiune=instructori" onsubmit="return valideazaFormular(this)">
                            <input type="hidden" name="editeaza_instructor" value="1">
                            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                            
                            <label>Nume Instructor:</label><br>
                            <input type="text" name="nume" value="<?php echo htmlspecialchars($edit_nume); ?>" required><br><br>
                            
                            <label>Specializare:</label><br>
                            <input type="text" name="specializare" value="<?php echo htmlspecialchars($edit_specializare); ?>" required><br><br>
                            
                            <label>Descriere:</label><br>
                            <textarea name="descriere" rows="4" required><?php echo htmlspecialchars($edit_descriere); ?></textarea><br><br>
                            
                            <button type="submit" style="background-color: #3498db; color: white;">Actualizeaza Datele</button>
                            <a href="admin.php?sectiune=instructori" style="margin-left: 10px; color: #555;">Anuleaza</a>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="form-box">
                        <h4>Adauga un instructor nou</h4><br>
                        <form method="POST" action="admin.php?sectiune=instructori" onsubmit="return valideazaFormular(this)">
                            <input type="hidden" name="adauga_instructor" value="1">
                            
                            <label>Nume Instructor:</label><br>
                            <input type="text" name="nume" required><br><br>
                            
                            <label>Specializare (ex: Dans Sportiv, Hip-Hop):</label><br>
                            <input type="text" name="specializare" required><br><br>
                            
                            <label>Descriere (experienta, stil de predare):</label><br>
                            <textarea name="descriere" rows="4" required></textarea><br><br>
                            
                            <button type="submit">Salveaza Instructor</button>
                        </form>
                    </div>
                <?php endif; ?>

                <h4>Lista Instructori Existenti</h4>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nume</th>
                            <th>Specializare</th>
                            <th>Descriere</th>
                            <th>Actiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM instructori ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['specializare']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descriere']) . "</td>";
                                echo "<td>";
                                // Link pentru incarcarea in formularul de modificare de mai sus
                                echo "<a href='admin.php?sectiune=instructori&actiune=edit&id=" . $row['id'] . "' class='btn-edit'>Editeaza</a>";
                                
                                // Formular mic si sigur pentru operatiunea de stergere
                                echo "<form method='POST' action='admin.php?sectiune=instructori' style='display:inline;' onsubmit='return confirmaStergerea()'>";
                                echo "<input type='hidden' name='sterge_instructor' value='1'>";
                                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn-delete'>Sterge</button>";
                                echo "</form>";
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align: center;'>Nu exista instructori adaugati inca.</td></tr>";
                        }
                        ?>
                    </tbody>
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