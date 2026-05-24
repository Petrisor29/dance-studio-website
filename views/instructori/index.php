<?php /** @var mysqli_result $instructori */ ?>
<?php /** @var string $mesaj */ ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin: 0;">Gestionare Instructori</h3>
    <a href="admin.php?sectiune=instructori&actiune=add" style="background-color: #2ecc71; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Adauga Instructor</a>
</div>

<?php echo $mesaj; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Specializare</th>
            <th>Actiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($instructori && $instructori->num_rows > 0): ?>
            <?php while($row = $instructori->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nume']); ?></td>
                    <td><?php echo htmlspecialchars($row['specializare']); ?></td>
                    <td>
                        <a href="admin.php?sectiune=instructori&actiune=edit&id=<?php echo $row['id']; ?>" style="text-decoration:none; background:#2980b9; color:white; padding:6px 12px; border-radius:4px; font-size:13px; margin-right:5px; font-weight:bold;">Editeaza</a>
                        <form method="POST" action="admin.php?sectiune=instructori" style="display:inline;" onsubmit="return confirm('Sigur doriti sa stergeti acest instructor?');">
                            <input type="hidden" name="sterge_instructor" value="1">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-delete" style="background:#e74c3c; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; font-weight:bold; font-size:13px;">Sterge</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align: center;">Nu exista instructori.</td></tr>
        <?php endif; ?>
    </tbody>
</table>