<?php
// 1. Includem conexiunea
require_once 'db_connect.php';

// 2. Incarcam antetul modular
include 'header.php';
?>

<main>
    <section>
        <h2>Evenimente si Competitii</h2>
        <p>Aici gasesti calendarul evenimentelor noastre viitoare, atat petreceri interne cat si competitii nationale.</p>

        <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 10px;">Data</th>
                    <th style="padding: 10px;">Nume Eveniment</th>
                    <th style="padding: 10px;">Locatie</th>
                    <th style="padding: 10px;">Tip Eveniment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 3. Extragem evenimentele din baza de date
                // Folosim ASC pentru a afisa evenimentele in ordinea in care au fost adaugate (sau poti folosi id DESC)
                $sql = "SELECT data_eveniment, nume, locatie, tip FROM evenimente ORDER BY id ASC";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    // 4. Generam randurile tabelului dinamic
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row['data_eveniment']) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row['nume']) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row['locatie']) . "</td>";
                        echo "<td style='padding: 10px;'>" . htmlspecialchars($row['tip']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Daca nu sunt evenimente, afisam un rand care se intinde pe toate cele 4 coloane (colspan="4")
                    echo "<tr><td colspan='4' style='padding: 15px; text-align: center; color: #666; font-style: italic;'>Momentan nu sunt evenimente programate.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

<?php
// 5. Incarcam subsolul modular
include 'footer.php';
?>