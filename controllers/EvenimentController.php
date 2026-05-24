<?php
require_once __DIR__ . '/../models/EvenimentModel.php';

class EvenimentController {
    private $model;

    public function __construct($db) {
        $this->model = new EvenimentModel($db);
    }

    public function index() {
        $mesaj = "";
        $mod_editare = false;
        $ev_edit = null;

        // Procesarea acțiunilor prin POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['adauga_eveniment'])) {
                $nume = trim($_POST['nume']);
                $data_ev = trim($_POST['data_eveniment']);
                $locatie = trim($_POST['locatie']);
                $tip = trim($_POST['tip']);

                if (!empty($nume) && !empty($data_ev) && !empty($locatie) && !empty($tip)) {
                    if ($this->model->insert($nume, $data_ev, $locatie, $tip)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Eveniment adăugat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['editeaza_eveniment'])) {
                $id = intval($_POST['id']);
                $nume = trim($_POST['nume']);
                $data_ev = trim($_POST['data_eveniment']);
                $locatie = trim($_POST['locatie']);
                $tip = trim($_POST['tip']);

                if (!empty($id) && !empty($nume) && !empty($data_ev) && !empty($locatie) && !empty($tip)) {
                    if ($this->model->update($id, $nume, $data_ev, $locatie, $tip)) {
                        $mesaj = "<p style='color: green; font-weight: bold;'>Eveniment actualizat cu succes!</p>";
                    }
                }
            } elseif (isset($_POST['sterge_eveniment'])) {
                $id = intval($_POST['id']);
                if ($this->model->delete($id)) {
                    $mesaj = "<p style='color: green; font-weight: bold;'>Eveniment șters din calendar!</p>";
                }
            }
        }

        // Verificarea modului de editare prin GET
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'edit' && isset($_GET['id'])) {
            $id_cautat = intval($_GET['id']);
            $ev_edit = $this->model->getById($id_cautat);
            if ($ev_edit) {
                $mod_editare = true;
            }
        }

        // --- DECIZIA DE RUTARE CĂTRE NOILE FIȘIERE ---
        if (isset($_GET['actiune']) && $_GET['actiune'] == 'add' && $_SERVER["REQUEST_METHOD"] != "POST") {
            // Arătăm formularul de Adăugare
            require __DIR__ . '/../views/evenimente/adauga.php';
            
        } elseif ($mod_editare && $_SERVER["REQUEST_METHOD"] != "POST") {
            // Arătăm formularul de Editare
            require __DIR__ . '/../views/evenimente/editeaza.php';
            
        } else {
            // Arătăm Tabelul principal
            $evenimente = $this->model->getAll();
            require __DIR__ . '/../views/evenimente/index.php';
        }
    }
}