<?php
session_start();

// Distrugem toate variabilele de sesiune (rupem ecusonul)
session_unset();
session_destroy();

// Il trimitem pe utilizator inapoi la login
header("Location: login.php");
exit;
?>