<?php
class Database
{
    //DB 
    private $host = 'localhost';
    private $db_name =  'id12101189_challenge_crud';
    private $username = 'id12101189_root';
    private $password = 'maxwell23';
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
