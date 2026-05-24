<?php
class EvenimentModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM evenimente ORDER BY id DESC");
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM evenimente WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($nume, $data_ev, $locatie, $tip) {
        $stmt = $this->conn->prepare("INSERT INTO evenimente (nume, data_eveniment, locatie, tip) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nume, $data_ev, $locatie, $tip);
        return $stmt->execute();
    }

    public function update($id, $nume, $data_ev, $locatie, $tip) {
        $stmt = $this->conn->prepare("UPDATE evenimente SET nume = ?, data_eveniment = ?, locatie = ?, tip = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nume, $data_ev, $locatie, $tip, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM evenimente WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}