<?php
session_start();
require_once 'core/Database.php';

// 1. Verificam autentificarea (Partea de login/protectie)
if (!isset($_SESSION['admin_logat']) || $_SESSION['admin_logat'] !== true) {
    header("Location: login.php");
    exit;
}

// 2. Initializam baza de date
$db = (new Database())->getConnection();

// 3. Dirijam cererea (Router)
$sectiune = isset($_GET['sectiune']) ? $_GET['sectiune'] : 'dashboard';

// Includem controllerele necesare
require_once 'controllers/InstructorController.php';
require_once 'controllers/CursController.php';
require_once 'controllers/EvenimentController.php';

?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Panou Administrare - Școala de Dans</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="sidebar" style="width: 250px; height: 100vh; background: #2c3e50; position: fixed; left: 0; top: 0; padding-top: 20px;">
        <h2 style="color: white; text-align: center; margin-bottom: 30px;">Admin Panel</h2>
        <a href="admin.php?sectiune=dashboard" style="display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #34495e;">Dashboard</a>
        <a href="admin.php?sectiune=instructori" style="display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #34495e; <?php if($sectiune=='instructori') echo 'background: #34495e;'; ?>">Gestionare Instructori</a>
        <a href="admin.php?sectiune=cursuri" style="display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #34495e; <?php if($sectiune=='cursuri') echo 'background: #34495e;'; ?>">Gestionare Cursuri</a>
        <a href="admin.php?sectiune=evenimente" style="display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #34495e; <?php if($sectiune=='evenimente') echo 'background: #34495e;'; ?>">Calendar Evenimente</a>
        <a href="index.php" target="_blank" style="display: block; color: #3498db; padding: 15px 20px; text-decoration: none; margin-top: 20px;">🌐 Vezi Site-ul Public</a>
    </div>

    <div class="main-content" style="margin-left: 250px; padding: 20px;">
        
        <div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; background: #ecf0f1; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="margin: 0;">Bun venit, Administrator!</h3>
            <a href="logout.php" style="background: #e74c3c; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Deconectare</a>
        </div>

        <div class="admin-body">
            <?php
            switch ($sectiune) {
                case 'instructori':
                    $ctrl = new InstructorController($db);
                    $ctrl->index();
                    break;
                case 'cursuri':
                    $ctrl = new CursController($db);
                    $ctrl->index();
                    break;
                case 'evenimente':
                    $ctrl = new EvenimentController($db);
                    $ctrl->index();
                    break;
                case 'dashboard':
                default:
                    echo "<h3>Alege o secțiune din meniul din stânga pentru a începe.</h3>";
                    break;
            }
            ?>
        </div>
    </div>
    <div class="admin-body">
            <?php
            // ... (aici ramane blocul switch intact) ...
            ?>
        </div>
    </div>

    <script src="assets/js/validare_admin.js"></script>
</body>
</html>