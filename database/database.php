<?php

class Database{


    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "draftly";
    private $conn;


    public function __construct(){

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if($this->conn->connect_error){
            die("Database Connectivity Error". $this->conn->connect_error);
        }
        

    }

    public function get_connection(){
        return $this->conn;
    }

}


?>