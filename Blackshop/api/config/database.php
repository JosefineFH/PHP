<?php
class Database {
    private $host = 'Your host';
    private $dbname = 'Your db name';
    private $username = 'Your username';
    private $password = 'Your password';
    public $conn;

    // DB connect
    public function connect(){
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname,
            $this ->username,
            $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch ( PDOException $e) {
            echo 'Connection Error' . $e->getMessage();
        }
        return $this->conn;
    }

}
