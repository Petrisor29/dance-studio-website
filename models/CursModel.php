<?php
class CursModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM cursuri ORDER BY id DESC");
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM cursuri WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($nume, $descriere, $nivel, $durata) {
        $stmt = $this->conn->prepare("INSERT INTO cursuri (nume, descriere, nivel, durata) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nume, $descriere, $nivel, $durata);
        return $stmt->execute();
    }

    public function update($id, $nume, $descriere, $nivel, $durata) {
        $stmt = $this->conn->prepare("UPDATE cursuri SET nume = ?, descriere = ?, nivel = ?, durata = ? WHERE id = ?");
        $stmt->bind_param("sssii", $nume, $descriere, $nivel, $durata, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM cursuri WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}