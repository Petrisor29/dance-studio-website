<?php /** @var mysqli_result $cursuri */ ?>
<?php /** @var string $mesaj */ ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin: 0;">Gestionare Cursuri Existente</h3>
    <a href="admin.php?sectiune=cursuri&actiune=add" style="background-color: #2ecc71; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Adaugă Curs</a>
</div>

<?php echo $mesaj; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nume Curs</th>
            <th>Descriere</th>
            <th>Nivel</th>
            <th>Durata</th>
            <th>Acțiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($cursuri && $cursuri->num_rows > 0): ?>
            <?php while($row = $cursuri->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nume']); ?></td>
                    <td><?php echo htmlspecialchars($row['descriere']); ?></td>
                    <td><?php echo htmlspecialchars($row['nivel']); ?></td>
                    <td><?php echo htmlspecialchars($row['durata']); ?> min</td>
                    <td>
                        <a href="admin.php?sectiune=cursuri&actiune=edit&id=<?php echo $row['id']; ?>" style="text-decoration:none; background:#2980b9; color:white; padding:6px 12px; border-radius:4px; font-size:13px; margin-right:5px; font-weight:bold;">Editează</a>
                        <form method="POST" action="admin.php?sectiune=cursuri" style="display:inline;" onsubmit="return confirm('Sigur doriți să ștergeți acest curs?');">
                            <input type="hidden" name="sterge_curs" value="1">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-delete" style="background:#e74c3c; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; font-weight:bold; font-size:13px;">Șterge</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align: center;">Nu există cursuri adăugate.</td></tr>
        <?php endif; ?>
    </tbody>
</table>