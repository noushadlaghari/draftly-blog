<?php

require_once(__DIR__ . "/../database/database.php");

class Comment
{
    public $id;
    public $user_id;
    public $blog_id;
    public $content;

    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->get_connection();
    }

    public function create()
    {
        $sql = "INSERT INTO comments(blog_id,user_id,content) VALUES(?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $this->blog_id, $this->user_id, $this->content);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $this;
        }
        return false;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM comments";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function findByBlogId($id)
    {
        $sql = "SELECT c.*, u.name as author, u.id as user_id, u.profile_image, u.role FROM comments c JOIN users u ON c.user_id=u.id WHERE c.blog_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function update($id,$data){

        $sql = "UPDATE comments SET content=?, status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $data["content"],$data["status"],$id);

        $stmt->execute();

        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }

    }
    public function delete($id){
        $sql = "DELETE FROM comments WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if( $stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
