<?php

require_once(__DIR__ ."/../database/database.php");

class Category{
    public $id;
    public $name;
    public $slug;

    private $conn;

    public function __construct(){
        $this->conn = (new Database())->get_connection();
    }

    public function findById($id){
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }
        return false;
    }

public function findAll() {
    $sql = "SELECT c.*, COUNT(b.id) as total_blogs 
            FROM categories c 
            LEFT JOIN blogs b ON c.id = b.category_id 
            GROUP BY c.id ORDER BY total_blogs DESC";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return false;
}

}

?>