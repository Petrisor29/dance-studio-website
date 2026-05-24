<?php
// --- LOGICA C.R.U.D. PENTRU CURSURI ---
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['adauga_curs'])) {
        $nume = trim($_POST['nume']);
        $descriere = trim($_POST['descriere']);
        $nivel = trim($_POST['nivel']);
        $durata = intval($_POST['durata']);

        if (!empty($nume) && !empty($descriere) && !empty($nivel) && $durata > 0) {
            $stmt = $conn->prepare("INSERT INTO cursuri (nume, descriere, nivel, durata) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nume, $descriere, $nivel, $durata);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Curs adaugat cu succes!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Date invalide! Verifica toate campurile.</p>";
        }
    } elseif (isset($_POST['editeaza_curs'])) {
        $id = intval($_POST['id']);
        $nume = trim($_POST['nume']);
        $descriere = trim($_POST['descriere']);
        $nivel = trim($_POST['nivel']);
        $durata = intval($_POST['durata']);

        if (!empty($id) && !empty($nume) && !empty($descriere) && !empty($nivel) && $durata > 0) {
            $stmt = $conn->prepare("UPDATE cursuri SET nume = ?, descriere = ?, nivel = ?, durata = ? WHERE id = ?");
            $stmt->bind_param("sssii", $nume, $descriere, $nivel, $durata, $id);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Cursul a fost actualizat!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['sterge_curs'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM cursuri WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Curs sters cu succes!</p>";
        }
        $stmt->close();
    }
}
?>

<script>
    function valideazaCurs(form) {
        if (form.nume.value.trim().length < 3) {
            alert("Numele cursului trebuie sa aiba minim 3 caractere!");
            return false;
        }
        if (form.durata.value <= 0) {
            alert("Durata trebuie sa fie un numar mai mare decat 0!");
            return false;
        }
        return true;
    }
</script>

<h3>Gestionare Cursuri</h3>
<?php echo $mesaj; ?>

<?php
// Extragerea datelor pentru editare
$mod_editare = false;
$edit_id = ""; $edit_nume = ""; $edit_descriere = ""; $edit_nivel = ""; $edit_durata = "";

if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
    $id_cautat = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM cursuri WHERE id = ?");
    $stmt->bind_param("i", $id_cautat);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows === 1) {
        $curs_edit = $res->fetch_assoc();
        $mod_editare = true;
        $edit_id = $curs_edit['id'];
        $edit_nume = $curs_edit['nume'];
        $edit_descriere = $curs_edit['descriere'];
        $edit_nivel = $curs_edit['nivel'];
        $edit_durata = $curs_edit['durata'];
    }
    $stmt->close();
}
?>

<?php if ($mod_editare): ?>
    <div class="form-box" style="border-left: 5px solid #2ecc71;">
        <h4>Modifica Cursul: <?php echo htmlspecialchars($edit_nume); ?></h4><br>
        <form method="POST" action="admin.php?sectiune=cursuri" onsubmit="return valideazaCurs(this)">
            <input type="hidden" name="editeaza_curs" value="1">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            
            <label>Nume Curs:</label><br>
            <input type="text" name="nume" value="<?php echo htmlspecialchars($edit_nume); ?>" required><br><br>
            
            <label>Descriere (stil de dans):</label><br>
            <textarea name="descriere" rows="3" required><?php echo htmlspecialchars($edit_descriere); ?></textarea><br><br>
            
            <label>Nivel:</label><br>
            <select name="nivel" required>
                <option value="Incepatori" <?php if($edit_nivel == 'Incepatori') echo 'selected'; ?>>Incepatori</option>
                <option value="Intermediari" <?php if($edit_nivel == 'Intermediari') echo 'selected'; ?>>Intermediari</option>
                <option value="Avansati" <?php if($edit_nivel == 'Avansati') echo 'selected'; ?>>Avansati</option>
                <option value="Toate nivelurile" <?php if($edit_nivel == 'Toate nivelurile') echo 'selected'; ?>>Toate nivelurile</option>
            </select><br><br>
            
            <label>Durata (minute):</label><br>
            <input type="number" name="durata" value="<?php echo htmlspecialchars($edit_durata); ?>" required><br><br>
            
            <button type="submit" style="background-color: #2ecc71; color: white;">Actualizeaza Curs</button>
            <a href="admin.php?sectiune=cursuri" style="margin-left: 10px; color: #555;">Anuleaza</a>
        </form>
    </div>
<?php else: ?>
    <div class="form-box">
        <h4>Adauga un curs nou</h4><br>
        <form method="POST" action="admin.php?sectiune=cursuri" onsubmit="return valideazaCurs(this)">
            <input type="hidden" name="adauga_curs" value="1">
            
            <label>Nume Curs:</label><br>
            <input type="text" name="nume" required><br><br>
            
            <label>Descriere (stil de dans):</label><br>
            <textarea name="descriere" rows="3" required></textarea><br><br>
            
            <label>Nivel:</label><br>
            <select name="nivel" required>
                <option value="Incepatori">Incepatori</option>
                <option value="Intermediari">Intermediari</option>
                <option value="Avansati">Avansati</option>
                <option value="Toate nivelurile">Toate nivelurile</option>
            </select><br><br>
            
            <label>Durata (minute):</label><br>
            <input type="number" name="durata" required><br><br>
            
            <button type="submit">Salveaza Curs</button>
        </form>
    </div>
<?php endif; ?>

<h4>Lista Cursuri Existente</h4>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nume Curs</th>
            <th>Descriere</th>
            <th>Nivel</th>
            <th>Durata</th>
            <th>Actiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM cursuri ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
                echo "<td>" . htmlspecialchars($row['descriere']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nivel']) . "</td>";
                echo "<td>" . htmlspecialchars($row['durata']) . " min</td>";
                echo "<td>";
                echo "<a href='admin.php?sectiune=cursuri&actiune=edit&id=" . $row['id'] . "' class='btn-edit'>Editeaza</a>";
                // Folosim functia confirmaStergerea() din admin.js
                echo "<form method='POST' action='admin.php?sectiune=cursuri' style='display:inline;' onsubmit='return confirmaStergerea()'>";
                echo "<input type='hidden' name='sterge_curs' value='1'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='btn-delete'>Sterge</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>Nu exista cursuri adaugate.</td></tr>";
        }
        ?>
    </tbody>
</table>