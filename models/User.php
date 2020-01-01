<?php

class User
{
    // DB details
    private $conn;
    private $table = 'users';

    // object properties
    public $id;
    public $uid;
    public $firstname;
    public $lastname;
    public $email;
    public $phoneNo;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    // create user
    public function create()
    {

        // Insert Query
        $query = "INSERT INTO " . $this->table . " (uid ,firstname, lastname, email, phoneNo) VALUES (:uid, :firstname, :lastname, :mail, :phone)";

        //prepare
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->uid = htmlspecialchars(strip_tags($this->uid));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phoneNo = htmlspecialchars(strip_tags($this->phoneNo));

        // Bind Data
        $stmt->bindParam(':uid', $this->uid);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':mail', $this->email);
        $stmt->bindParam(':phone', $this->phoneNo);

        $checkQuery = "SELECT * FROM " . $this->table . " WHERE email = :mail";

        $chk = $this->conn->prepare($checkQuery);
        $chk->bindParam(':mail', $this->email);
        $chk->execute();
        if ($chk->rowCount() > 0) {
            return false;
        } else {
            // Execute
            if ($stmt->execute()) {
                return true;
            }
        }
    }

    // Get User Details
    public function getUserDetails()
    {
        // query to get user details
        $query = 'SELECT `id`, `uid`, `firstname`, `lastname`, `email`, `phoneNo` FROM ' . $this->table . ' WHERE uid = ?';

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->uid);

        // execute query
        $stmt->execute();

        // retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user = $row;
        $this->id = $row['id'];
        $this->email = $row['email'];
    }

    // Get User UID
    public function getUserUID()
    {
        // query to get user details
        $query = 'SELECT `id`, `uid`, `firstname`, `lastname`, `email`, `phoneNo` FROM ' . $this->table . ' WHERE email = ?';

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->email);
        // $stmt->bindParam(':email', $email);

        // execute query
        $stmt->execute();

        // retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user = $row;
        $this->id = $row['id'];
        $this->uid = $row['uid'];
    }
}
