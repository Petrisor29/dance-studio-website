<?php
session_start();

// Protectia panoului de administrare
if (!isset($_SESSION['admin_logat']) || $_SESSION['admin_logat'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panou Administrare</title>
    <link rel="stylesheet" href="assets/css/style.css">
    
    <script src="assets/js/admin.js"></script>

    <style>
        .admin-container { max-width: 1000px; margin: 40px auto; padding: 20px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .admin-nav { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eee; }
        .admin-nav a { margin-right: 15px; text-decoration: none; color: #2c3e50; font-weight: bold; }
        .admin-nav a:hover { color: #e74c3c; }
        .btn-logout { float: right; background-color: #333; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none;}
        .btn-logout:hover { background-color: #000; }
        .form-box { background: #f9f9f9; padding: 15px; border: 1px solid #ccc; margin-bottom: 20px; border-radius: 5px;}
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .admin-table th, .admin-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .admin-table th { background: #2c3e50; color: white; }
        .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-delete { background: none; border: none; color: #e74c3c; font-weight: bold; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit; }
    </style>
</head>
<body>

    <div class="admin-container">
        <a href="logout.php" class="btn-logout">Delogare</a>
        <h2>Bun venit, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <div class="admin-nav">
            <a href="admin.php?sectiune=instructori">Gestionare Instructori</a>
            <a href="admin.php?sectiune=cursuri">Gestionare Cursuri</a>
            <a href="admin.php?sectiune=evenimente">Gestionare Evenimente</a>
            <a href="index.php" target="_blank">Vezi Site-ul Public</a>
        </div>

        <div class="admin-content">
            <?php
            // SISTEMUL DE RUTARE (ROUTER)
            // SISTEMUL DE RUTARE (ROUTER)
            $sectiune = isset($_GET['sectiune']) ? $_GET['sectiune'] : 'dashboard';

            // Verificam ce buton s-a apasat in meniu si incarcam modulul corespunzator
            switch ($sectiune) {
                case 'instructori':
                    include 'admin_modules/instructori.php';
                    break;
                case 'cursuri':
                    include 'admin_modules/cursuri.php'; // Am activat includerea!
                    break;
                case 'evenimente':
                    include 'admin_modules/evenimente.php';
                    break;
                case 'dashboard':
                default:
                    echo "<h3>Alege o sectiune din meniul de mai sus pentru a incepe.</h3>";
                    break;
            }
            ?>
        </div>
    </div>

</body>
</html>