<?php
// --- LOGICA C.R.U.D. PENTRU EVENIMENTE ---
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['adauga_eveniment'])) {
        $nume = trim($_POST['nume']);
        $data_ev = trim($_POST['data_eveniment']);
        $locatie = trim($_POST['locatie']);
        $tip = trim($_POST['tip']);

        if (!empty($nume) && !empty($data_ev) && !empty($locatie) && !empty($tip)) {
            $stmt = $conn->prepare("INSERT INTO evenimente (nume, data_eveniment, locatie, tip) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nume, $data_ev, $locatie, $tip);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Eveniment adaugat cu succes!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Toate campurile sunt obligatorii!</p>";
        }
    } elseif (isset($_POST['editeaza_eveniment'])) {
        $id = intval($_POST['id']);
        $nume = trim($_POST['nume']);
        $data_ev = trim($_POST['data_eveniment']);
        $locatie = trim($_POST['locatie']);
        $tip = trim($_POST['tip']);

        if (!empty($id) && !empty($nume) && !empty($data_ev) && !empty($locatie) && !empty($tip)) {
            $stmt = $conn->prepare("UPDATE evenimente SET nume = ?, data_eveniment = ?, locatie = ?, tip = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nume, $data_ev, $locatie, $tip, $id);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Evenimentul a fost actualizat!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['sterge_eveniment'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM evenimente WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Eveniment sters din calendar!</p>";
        }
        $stmt->close();
    }
}
?>

<script>
    function valideazaEveniment(form) {
        if (form.nume.value.trim().length < 3) {
            alert("Numele evenimentului trebuie sa aiba minim 3 caractere!");
            return false;
        }
        if (form.locatie.value.trim().length < 3) {
            alert("Te rugam sa introduci o locatie valida!");
            return false;
        }
        return true;
    }
</script>

<h3>Gestionare Evenimente</h3>
<?php echo $mesaj; ?>

<?php
$mod_editare = false;
$edit_id = ""; $edit_nume = ""; $edit_data = ""; $edit_locatie = ""; $edit_tip = "";

if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
    $id_cautat = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM evenimente WHERE id = ?");
    $stmt->bind_param("i", $id_cautat);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows === 1) {
        $ev_edit = $res->fetch_assoc();
        $mod_editare = true;
        $edit_id = $ev_edit['id'];
        $edit_nume = $ev_edit['nume'];
        $edit_data = $ev_edit['data_eveniment'];
        $edit_locatie = $ev_edit['locatie'];
        $edit_tip = $ev_edit['tip'];
    }
    $stmt->close();
}
?>

<?php if ($mod_editare): ?>
    <div class="form-box" style="border-left: 5px solid #9b59b6;">
        <h4>Modifica Evenimentul: <?php echo htmlspecialchars($edit_nume); ?></h4><br>
        <form method="POST" action="admin.php?sectiune=evenimente" onsubmit="return valideazaEveniment(this)">
            <input type="hidden" name="editeaza_eveniment" value="1">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            
            <label>Nume Eveniment:</label><br>
            <input type="text" name="nume" value="<?php echo htmlspecialchars($edit_nume); ?>" required><br><br>
            
            <label>Data Eveniment (ex: 15 Martie 2026):</label><br>
            <input type="text" name="data_eveniment" value="<?php echo htmlspecialchars($edit_data); ?>" required><br><br>
            
            <label>Locatie:</label><br>
            <input type="text" name="locatie" value="<?php echo htmlspecialchars($edit_locatie); ?>" required><br><br>
            
            <label>Tip Eveniment:</label><br>
            <select name="tip" required>
                <option value="Competitie" <?php if($edit_tip == 'Competitie') echo 'selected'; ?>>Competitie</option>
                <option value="Petrecere Sociala" <?php if($edit_tip == 'Petrecere Sociala') echo 'selected'; ?>>Petrecere Sociala</option>
                <option value="Workshop" <?php if($edit_tip == 'Workshop') echo 'selected'; ?>>Workshop</option>
                <option value="Examen" <?php if($edit_tip == 'Examen') echo 'selected'; ?>>Examen</option>
            </select><br><br>
            
            <button type="submit" style="background-color: #9b59b6; color: white;">Actualizeaza Eveniment</button>
            <a href="admin.php?sectiune=evenimente" style="margin-left: 10px; color: #555;">Anuleaza</a>
        </form>
    </div>
<?php else: ?>
    <div class="form-box">
        <h4>Adauga un eveniment nou</h4><br>
        <form method="POST" action="admin.php?sectiune=evenimente" onsubmit="return valideazaEveniment(this)">
            <input type="hidden" name="adauga_eveniment" value="1">
            
            <label>Nume Eveniment:</label><br>
            <input type="text" name="nume" required><br><br>
            
            <label>Data Eveniment (ex: 15 Martie 2026):</label><br>
            <input type="text" name="data_eveniment" required><br><br>
            
            <label>Locatie:</label><br>
            <input type="text" name="locatie" required><br><br>
            
            <label>Tip Eveniment:</label><br>
            <select name="tip" required>
                <option value="Competitie">Competitie</option>
                <option value="Petrecere Sociala">Petrecere Sociala</option>
                <option value="Workshop">Workshop</option>
                <option value="Examen">Examen</option>
            </select><br><br>
            
            <button type="submit">Salveaza Eveniment</button>
        </form>
    </div>
<?php endif; ?>

<h4>Calendar Evenimente</h4>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Nume Eveniment</th>
            <th>Locatie</th>
            <th>Tip</th>
            <th>Actiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM evenimente ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['data_eveniment']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nume']) . "</td>";
                echo "<td>" . htmlspecialchars($row['locatie']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tip']) . "</td>";
                echo "<td>";
                echo "<a href='admin.php?sectiune=evenimente&actiune=edit&id=" . $row['id'] . "' class='btn-edit'>Editeaza</a>";
                echo "<form method='POST' action='admin.php?sectiune=evenimente' style='display:inline;' onsubmit='return confirmaStergerea()'>";
                echo "<input type='hidden' name='sterge_eveniment' value='1'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='btn-delete'>Sterge</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>Nu exista evenimente in calendar.</td></tr>";
        }
        ?>
    </tbody>
</table>