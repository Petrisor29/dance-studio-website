<?php /** @var array $curs_edit */ ?>
<?php /** @var string $mesaj */ ?>

<h3>Modificare Curs</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="border-left: 5px solid #2980b9; background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <h4>Editezi cursul: <?php echo htmlspecialchars($curs_edit['nume']); ?></h4><br>
    
    <form method="POST" action="admin.php?sectiune=cursuri">
        <input type="hidden" name="editeaza_curs" value="1">
        <input type="hidden" name="id" value="<?php echo $curs_edit['id']; ?>">
        
        <label>Nume Curs:</label><br>
        <input type="text" name="nume" value="<?php echo htmlspecialchars($curs_edit['nume']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Descriere (stil de dans):</label><br>
        <textarea name="descriere" rows="3" required style="width:100%; padding:8px; margin-top:5px;"><?php echo htmlspecialchars($curs_edit['descriere']); ?></textarea><br><br>
        
        <label>Nivel:</label><br>
        <select name="nivel" required style="width:100%; padding:8px; margin-top:5px;">
            <option value="Incepatori" <?php if($curs_edit['nivel'] == 'Incepatori') echo 'selected'; ?>>Incepatori</option>
            <option value="Intermediari" <?php if($curs_edit['nivel'] == 'Intermediari') echo 'selected'; ?>>Intermediari</option>
            <option value="Avansati" <?php if($curs_edit['nivel'] == 'Avansati') echo 'selected'; ?>>Avansati</option>
            <option value="Toate nivelurile" <?php if($curs_edit['nivel'] == 'Toate nivelurile') echo 'selected'; ?>>Toate nivelurile</option>
        </select><br><br>
        
        <label>Durata (minute):</label><br>
        <input type="number" name="durata" value="<?php echo htmlspecialchars($curs_edit['durata']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <button type="submit" style="background-color: #2980b9; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salvează Modificările</button>
        <a href="admin.php?sectiune=cursuri" style="margin-left: 10px; color: #555; text-decoration: none;">Anulează</a>
    </form>
</div>