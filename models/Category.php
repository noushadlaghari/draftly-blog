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

    public function create($data){
        $sql = "INSERT INTO categories(name,slug) VALUES(?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss",$data["category_name"],$data["category_slug"]);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }
        return false;
    }

public function findById($id){
    $sql = "SELECT c.*, COUNT(b.id) as total_blogs 
            FROM categories c 
            LEFT JOIN blogs b ON c.id = b.category_id 
            WHERE c.id = ?
            GROUP BY c.id";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?? [];
}


public function findAll($offset=0, $limit=8) {
    $sql = "SELECT c.*, COUNT(b.id) as total_blogs 
            FROM categories c 
            LEFT JOIN blogs b ON c.id = b.category_id 
            GROUP BY c.id ORDER BY total_blogs DESC LIMIT ?,?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC)??[];
   

    $count_query = "SELECT COUNT(*) as total FROM categories";
    $stmt = $this->conn->prepare($count_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()["total"]??0;

    return [
        "categories"=> $categories,
        "total"=>$total
    ];

}

public function delete($id){
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if($stmt->affected_rows>0){
        return true;
    }
    return false;
}

public function update($data){

    $sql = "UPDATE categories SET name =?, slug= ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssi",$data["category_name"],$data["category_slug"],$data["category_id"]);
    $stmt->execute();
    if($stmt->affected_rows> 0){
        return true;
    }
    return false;
}

}

?>