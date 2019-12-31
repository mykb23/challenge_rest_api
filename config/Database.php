<?php
class Database
{
    //DB 
    private $host = 'localhost';
    private $db_name = 'challenge_crud';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'connection error' . $e->getMessage();
        }

        return $this->conn;
    }
}
