<?php
require_once __DIR__ . '/../models/CursModel.php';

class CursController {
    private $model;

    public function __construct($db) {
        $this->model = new CursModel($db);
    }

    public function index() {
        $mesaj = "";
        $mod_editare = false;
        $curs_edit = null;

        // Procesăm acțiunile trimise prin formulare (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['adauga_curs'])) {
                $nume = trim($_POST['nume']);
                $descriere = trim($_POST['descriere']);
                $nivel = trim($_POST['nivel']);
                $durata = intval($_POST['durata']);

                if (!empty($nume) && !empty($descriere) && !empty($nivel) && $durata > 0) {
                    if ($this->model->insert($nume, $descriere, $nivel, $durata)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Curs adăugat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['editeaza_curs'])) {
                $id = intval($_POST['id']);
                $nume = trim($_POST['nume']);
                $descriere = trim($_POST['descriere']);
                $nivel = trim($_POST['nivel']);
                $durata = intval($_POST['durata']);

                if (!empty($id) && !empty($nume) && !empty($descriere) && !empty($nivel) && $durata > 0) {
                    if ($this->model->update($id, $nume, $descriere, $nivel, $durata)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Cursul a fost actualizat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['sterge_curs'])) {
                $id = intval($_POST['id']);
                if ($this->model->delete($id)) {
                    $mesaj = "<p style='color: green; font-weight: bold;'>Curs șters cu succes!</p>";
                }
            }
        }

        // Verificăm dacă suntem în modul de editare (cerere GET)
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
            $id_cautat = intval($_GET['id']);
            $curs_edit = $this->model->getById($id_cautat);
            if ($curs_edit) {
                $mod_editare = true;
            }
        }

        // --- NOUA LOGICĂ DE RUTA RE CĂTRE FIȘIERE SEPARATE ---
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'add' && $_SERVER["REQUEST_METHOD"] != "POST") {
            // Afișăm doar ecranul de Adăugare
            require __DIR__ . '/../views/cursuri/adauga.php';
            
        } elseif ($mod_editare && $_SERVER["REQUEST_METHOD"] != "POST") {
            // Afișăm doar ecranul de Editare
            require __DIR__ . '/../views/cursuri/editeaza.php';
            
        } else {
            // Altfel, afișăm tabelul principal de listare
            $cursuri = $this->model->getAll();
            require __DIR__ . '/../views/cursuri/index.php';
        }
    }
}