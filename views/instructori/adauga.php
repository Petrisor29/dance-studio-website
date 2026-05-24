<?php /** @var string $mesaj */ ?>

<h3>Adaugare Instructor Nou</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <form method="POST" action="admin.php?sectiune=instructori">
        <input type="hidden" name="adauga_instructor" value="1">
        
        <label>Nume Instructor:</label><br>
        <input type="text" name="nume" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <label>Specializare:</label><br>
        <input type="text" name="specializare" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <button type="submit" style="background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salveaza Instructor</button>
        <a href="admin.php?sectiune=instructori" style="margin-left: 10px; color: #555; text-decoration: none;">Anuleaza</a>
    </form>
</div>