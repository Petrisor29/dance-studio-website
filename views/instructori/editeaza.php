<?php /** @var array $inst_edit */ ?>
<?php /** @var string $mesaj */ ?>

<h3>Modificare Instructor</h3>
<?php echo $mesaj; ?>

<div class="form-box" style="border-left: 5px solid #2980b9; background: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <h4>Editezi instructorul: <?php echo htmlspecialchars($inst_edit['nume']); ?></h4><br>
    
    <form method="POST" action="admin.php?sectiune=instructori">
        <input type="hidden" name="editeaza_instructor" value="1">
        <input type="hidden" name="id" value="<?php echo $inst_edit['id']; ?>">
        
        <label>Nume Instructor:</label><br>
        <input type="text" name="nume" value="<?php echo htmlspecialchars($inst_edit['nume']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>

        <label>Specializare:</label><br>
        <input type="text" name="specializare" value="<?php echo htmlspecialchars($inst_edit['specializare']); ?>" required style="width:100%; padding:8px; margin-top:5px;"><br><br>
        
        <button type="submit" style="background-color: #2980b9; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Salveaza Modificarile</button>
        <a href="admin.php?sectiune=instructori" style="margin-left: 10px; color: #555; text-decoration: none;">Anuleaza</a>
    </form>
</div>