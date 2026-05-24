<?php
// Incarcam antetul modular
include 'header.php';
?>

<main>
    <section>
        <h2>Contacteaza-ne</h2>
        <p>Ai o intrebare sau vrei sa te inscrii la un curs? Lasa-ne un mesaj si te vom contacta in cel mai scurt timp.</p>

        <form action="#" method="POST">
            <div>
                <label for="nume">Numele tau:</label><br>
                <input type="text" id="nume" name="nume" required>
            </div>
            <br>
            <div>
                <label for="email">Adresa de Email:</label><br>
                <input type="email" id="email" name="email" required>
            </div>
            <br>
            <div>
                <label for="subiect">Subiect:</label><br>
                <input type="text" id="subiect" name="subiect" required>
            </div>
            <br>
            <div>
                <label for="mesaj">Mesajul tau:</label><br>
                <textarea name="mesaj" id="mesaj" rows="5" required></textarea>
            </div>
            <br>
            <button type="submit">Trimite Mesajul</button>
        </form>

        <hr>

        <h3>Alte date de contact:</h3>
        <p><strong>Telefon:</strong> 0722 123 456</p>
        <p><strong>Email:</strong> info@scoala-dans.ro</p>
        <p><strong>Adresa:</strong> Str. Mihai Eminescu, nr. 123, Craiova</p>
    </section>      
</main>

<?php
// Incarcam subsolul modular
include 'footer.php';
?>