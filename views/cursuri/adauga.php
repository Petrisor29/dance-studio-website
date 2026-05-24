<?php /** @var string $mesaj */ ?>

<h3>Adăugare Curs Nou</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <form method="POST" action="admin.php?sectiune=cursuri">
        <input type="hidden" name="adauga_curs" value="1">
        
        <label>Nume Curs:</label><br>
        <input type="text" name="nume" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Descriere (stil de dans):</label><br>
        <textarea name="descriere" rows="3" required style="width:100%; padding:8px; margin-top:5px;"></textarea><br><br>
        
        <label>Nivel:</label><br>
        <select name="nivel" required style="width:100%; padding:8px; margin-top:5px;">
            <option value="Incepatori">Incepatori</option>
            <option value="Intermediari">Intermediari</option>
            <option value="Avansati">Avansati</option>
            <option value="Toate nivelurile">Toate nivelurile</option>
        </select><br><br>
        
        <label>Durata (minute):</label><br>
        <input type="number" name="durata" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <button type="submit" style="background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salvează Curs</button>
        <a href="admin.php?sectiune=cursuri" style="margin-left: 10px; color: #555; text-decoration: none;">Anulează</a>
    </form>
</div>