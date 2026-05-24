<?php /** @var array $ev_edit */ ?>
<?php /** @var string $mesaj */ ?>

<h3>Modificare Eveniment</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="border-left: 5px solid #2980b9; background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <h4>Editezi: <?php echo htmlspecialchars($ev_edit['nume']); ?></h4><br>
    
    <form method="POST" action="admin.php?sectiune=evenimente">
        <input type="hidden" name="editeaza_eveniment" value="1">
        <input type="hidden" name="id" value="<?php echo $ev_edit['id']; ?>">
        
        <label>Nume Eveniment:</label><br>
        <input type="text" name="nume" value="<?php echo htmlspecialchars($ev_edit['nume']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Data Eveniment:</label><br>
        <input type="date" name="data_eveniment" value="<?php echo htmlspecialchars($ev_edit['data_eveniment']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Locație:</label><br>
        <input type="text" name="locatie" value="<?php echo htmlspecialchars($ev_edit['locatie']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Tip Eveniment:</label><br>
        <select name="tip" required style="width:100%; padding:8px; margin-top:5px;">
            <option value="Competitie" <?php if($ev_edit['tip'] == 'Competitie') echo 'selected'; ?>>Competitie</option>
            <option value="Petrecere Sociala" <?php if($ev_edit['tip'] == 'Petrecere Sociala') echo 'selected'; ?>>Petrecere Sociala</option>
            <option value="Workshop" <?php if($ev_edit['tip'] == 'Workshop') echo 'selected'; ?>>Workshop</option>
            <option value="Examen" <?php if($ev_edit['tip'] == 'Examen') echo 'selected'; ?>>Examen</option>
        </select><br><br>
        
        <button type="submit" style="background-color: #2980b9; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salvează Modificările</button>
        <a href="admin.php?sectiune=evenimente" style="margin-left: 10px; color: #555; text-decoration: none;">Anulează</a>
    </form>
</div>