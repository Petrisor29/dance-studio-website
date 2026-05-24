<?php
class InstructorModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM instructori ORDER BY id DESC");
    }

    // Functie noua pentru a prelua un singur instructor
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM instructori WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($nume, $specializare, $descriere) {
        $stmt = $this->conn->prepare("INSERT INTO instructori (nume, specializare, descriere) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $specializare, $descriere);
        return $stmt->execute();
    }

    // Functie noua pentru a salva modificarile
    public function update($id, $nume, $specializare, $descriere) {
        $stmt = $this->conn->prepare("UPDATE instructori SET nume = ?, specializare = ?, descriere = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nume, $specializare, $descriere, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM instructori WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}