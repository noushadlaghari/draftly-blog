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

    public function findAll($offset=0,$limit=8)
    {
        $sql = "SELECT c.*, u.name as author, b.id as blog_id, b.title as blog_title FROM comments c JOIN users u ON c.user_id = u.id JOIN blogs b ON c.blog_id = b.id LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $offset,$limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC)??[];

        $count_query = "SELECT COUNT(*) as total FROM comments";
        $result = $this->conn->query($count_query);
        $total = $result->fetch_assoc()["total"];

        return [
            "comments"=> $comments,
            "total"=> $total
        ];
      
    }

        public function count(){
        $sql = "SELECT COUNT(*) as total FROM comments";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()["total"]??0;

        return $total;

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
        
        return $result->fetch_assoc()??[];
      
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

    public function approve($id){
        $status = "approved";
        $sql = "UPDATE comments SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        if($stmt->affected_rows> 0){
            return true;
        }
        return false;
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
