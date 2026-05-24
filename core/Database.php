<?php
class Database {
    private $host = "localhost";
    private $db_name = "scoala_dans";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $this->conn->set_charset("utf8mb4");
        } catch(Exception $e) {
            die("Eroare conexiune: " . $e->getMessage());
        }
        return $this->conn;
    }
}