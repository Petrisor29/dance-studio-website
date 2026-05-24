<?php
// --- LOGICA DE ADAUGARE, MODIFICARE SI STERGERE (CRUD) ---
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['adauga_instructor'])) {
        $nume = trim($_POST['nume']);
        $specializare = trim($_POST['specializare']);
        $descriere = trim($_POST['descriere']);

        if (!empty($nume) && !empty($specializare) && !empty($descriere)) {
            $stmt = $conn->prepare("INSERT INTO instructori (nume, specializare, descriere) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nume, $specializare, $descriere);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Instructor adaugat cu succes!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            $mesaj = "<p style='color: red; font-weight: bold;'>Toate campurile sunt obligatorii!</p>";
        }
    } elseif (isset($_POST['editeaza_instructor'])) {
        $id = intval($_POST['id']);
        $nume = trim($_POST['nume']);
        $specializare = trim($_POST['specializare']);
        $descriere = trim($_POST['descriere']);

        if (!empty($id) && !empty($nume) && !empty($specializare) && !empty($descriere)) {
            $stmt = $conn->prepare("UPDATE instructori SET nume = ?, specializare = ?, descriere = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nume, $specializare, $descriere, $id);
            if ($stmt->execute()) {
                $mesaj = "<p style='color: green; font-weight: bold;'>Date actualizate!</p>";
            } else {
                $mesaj = "<p style='color: red; font-weight: bold;'>Eroare: " . $conn->error . "</p>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['sterge_instructor'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM instructori WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mesaj = "<p style='color: green; font-weight: bold;'>Instructor sters!</p>";
        }
        $stmt->close();
    }
}
?>

<h3>Gestionare Instructori</h3>
<?php echo $mesaj; ?>

<?php
// Verificam daca suntem in modul de editare
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
?>

<?php if ($mod_editare): ?>
    <div class="form-box" style="border-left: 5px solid #3498db;">
        <h4>Modifica datele: <?php echo htmlspecialchars($edit_nume); ?></h4><br>
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
            <label>Specializare:</label><br>
            <input type="text" name="specializare" required><br><br>
            <label>Descriere:</label><br>
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
                echo "<a href='admin.php?sectiune=instructori&actiune=edit&id=" . $row['id'] . "' class='btn-edit'>Editeaza</a>";
                echo "<form method='POST' action='admin.php?sectiune=instructori' style='display:inline;' onsubmit='return confirmaStergerea()'>";
                echo "<input type='hidden' name='sterge_instructor' value='1'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='btn-delete'>Sterge</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align: center;'>Nu exista instructori adaugati.</td></tr>";
        }
        ?>
    </tbody>
</table>