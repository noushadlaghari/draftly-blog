<?php

require_once(__DIR__ ."/../database/database.php");
require_once(__DIR__ ."/../models/Category.php");

class CategoriesController{

    private $conn;
    public function __construct(){

        $db = new Database();
        $this->conn = $db->get_connection();
    }
    public function getAll(){
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function findAll(){
        $categories = (new Category())->findAll();
        if($categories){
            return $categories;
        }
        return false;
    }

    public function findById($id){

        $category = (new Category())->findById($id);

        if($category){
            return $category;
        }
        return false;


    }
    
}

?>