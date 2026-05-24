<?php
// 1. Conexiunea la baza de date (fundatia)
require_once 'db_connect.php';

// 2. Incarcam partea de sus si meniul de navigare
include 'header.php';
?>

<main>
    <section>
        <h2>Cunoaste-ne Echipa</h2>
        <p>Instructorii nostri sunt profesionisti dedicati, cu ani de experienta pe scena si in sala de curs.</p>

        <?php
        // 3. Extragem datele din MySQL
        $sql = "SELECT nume, specializare, descriere FROM instructori ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        // 4. Afisam dinamic rezultatele
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div>";
                echo "<h3>" . htmlspecialchars($row['nume']) . "</h3>";
                echo "<p><strong>Specializare: </strong>" . htmlspecialchars($row['specializare']) . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['descriere'])) . "</p>";
                echo "</div>";
                echo "<hr>";
            }
        } else {
            // Mesaj afisat cand nu exista date inca in baza de date
            echo "<p style='color: #666; font-style: italic;'>Momentan construim echipa. Va rugam sa reveniti curand!</p>";
        }
        ?>

    </section>
</main>

<?php
// 5. Incarcam subsolul paginii si inchidem tag-urile HTML
include 'footer.php';
?>