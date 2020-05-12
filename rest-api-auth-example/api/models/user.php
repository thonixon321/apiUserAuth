<?php

class User {
    //db connect and table name
    private $conn;
    private $table_name = "users";

    //object props
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //create the user
    public function create() {
        //insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET 
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    password = :password";
        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        //bind
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        //hash the password before saving to db
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        //execute query while making sure it is successful
        //sending back true on success
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //email exists method
}