<?php
// 1. Includem conexiunea la baza de date
require_once 'db_connect.php';

// 2. Incarcam antetul modular
include 'header.php';
?>

<main>
    <section>
        <h2>Stiluri de dans oferite</h2>
        <p>Alege stilul care ti se potriveste cel mai bine. Oferim cursuri de grup, dar si sedinte private.</p>

        <?php
        // 3. Interogarea pentru a extrage cursurile
        // Presupunem ca vom avea coloanele: nume, descriere, nivel, durata
        $sql = "SELECT nume, descriere, nivel, durata FROM cursuri ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // 4. Generam fiecare articol in mod dinamic
            while($row = mysqli_fetch_assoc($result)) {
                echo "<article>";
                echo "<h3>" . htmlspecialchars($row['nume']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['descriere'])) . "</p>";
                echo "<ul>";
                echo "<li>Nivel: " . htmlspecialchars($row['nivel']) . "</li>";
                echo "<li>Durata sedinta: " . htmlspecialchars($row['durata']) . " minute</li>";
                echo "</ul>";
                echo "</article>";
            }
        } else {
            echo "<p style='color: #666; font-style: italic;'>Momentan actualizam programa cursurilor. Revino in curand!</p>";
        }
        ?>

    </section>
</main>

<?php
// 5. Incarcam subsolul modular
include 'footer.php';
?>