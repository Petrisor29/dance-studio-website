<?php
class InstructorModel {
    private $conn;
    // Constructorul
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Citirea datelor(fara parametri)
    // Query simplu fiindca nu primim date de la user
    public function getAll() {
        return $this->conn->query("SELECT * FROM instructori ORDER BY id DESC");
    }

    // Citire securizata(cu parametri)
    public function getById($id) {
        //'prepare' trimite structura la MySQL(fara date).Baza de date o compileaza
        $stmt = $this->conn->prepare("SELECT * FROM instructori WHERE id = ?");
        $stmt->bind_param("i", $id); //Trimite valoarea separat integer "i". Protectie SQL Injection
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
 
    public function insert($nume, $specializare, $descriere) {
        $stmt = $this->conn->prepare("INSERT INTO instructori (nume, specializare, descriere) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $specializare, $descriere); //string, string, string
        return $stmt->execute();
    }

    // Modificare securizata
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