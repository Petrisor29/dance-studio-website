<?php /** @var string $mesaj */ ?>

<h3>Adăugare Eveniment Nou</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <form method="POST" action="admin.php?sectiune=evenimente">
        <input type="hidden" name="adauga_eveniment" value="1">
        
        <label>Nume Eveniment:</label><br>
        <input type="text" name="nume" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Data Eveniment:</label><br>
        <input type="date" name="data_eveniment" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Locație:</label><br>
        <input type="text" name="locatie" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Tip Eveniment:</label><br>
        <select name="tip" required style="width:100%; padding:8px; margin-top:5px;">
            <option value="Competitie">Competitie</option>
            <option value="Petrecere Sociala">Petrecere Sociala</option>
            <option value="Workshop">Workshop</option>
            <option value="Examen">Examen</option>
        </select><br><br>
        
        <button type="submit" style="background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salvează Eveniment</button>
        <a href="admin.php?sectiune=evenimente" style="margin-left: 10px; color: #555; text-decoration: none;">Anulează</a>
    </form>
</div>