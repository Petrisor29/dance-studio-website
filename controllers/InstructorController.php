<?php
require_once __DIR__ . '/../models/InstructorModel.php';

class InstructorController {
    private $model;

    public function __construct($db) {
        $this->model = new InstructorModel($db);
    }

    public function index() {
        $mesaj = "";
        $mod_editare = false;
        $inst_edit = null;

        // Procesam actiunile POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['adauga_instructor'])) {
                $nume = trim($_POST['nume']);
                $specializare = trim($_POST['specializare']);
                $descriere = "Descriere nedefinita"; 

                if (!empty($nume) && !empty($specializare)) {
                    if ($this->model->insert($nume, $specializare, $descriere)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Instructor adaugat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['editeaza_instructor'])) {
                $id = intval($_POST['id']);
                $nume = trim($_POST['nume']);
                $specializare = trim($_POST['specializare']);
                $descriere = "Descriere nedefinita";

                if (!empty($id) && !empty($nume) && !empty($specializare)) {
                    if ($this->model->update($id, $nume, $specializare, $descriere)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Instructor actualizat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['sterge_instructor'])) {
                $id = intval($_POST['id']);
                if ($this->model->delete($id)) {
                    $mesaj = "<p style='color: green; font-weight: bold;'>Instructor sters!</p>";
                }
            }
        }

        // Verificam modul de editare prin GET
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
            $id_cautat = intval($_GET['id']);
            $inst_edit = $this->model->getById($id_cautat);
            if ($inst_edit) {
                $mod_editare = true;
            }
        }

        // Rutare catre fisierele View
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'add' && $_SERVER["REQUEST_METHOD"] != "POST") {
            require __DIR__ . '/../views/instructori/adauga.php';
        } elseif ($mod_editare && $_SERVER["REQUEST_METHOD"] != "POST") {
            require __DIR__ . '/../views/instructori/editeaza.php';
        } else {
            $instructori = $this->model->getAll();
            require __DIR__ . '/../views/instructori/index.php';
        }
    }
}