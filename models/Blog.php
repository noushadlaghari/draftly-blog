<?php

require_once(__DIR__ . "/../database/database.php");

class Blog
{
    private $conn;
    public $id;
    public $title;
    public $content;
    public $excerpt;
    public $featured_image;
    public $category;
    public $user_id;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->get_connection();
    }

    public function findAll($data)
    {
        $sql = "SELECT b.*, c.name as category, u.name as author 
                    FROM blogs b 
                    JOIN categories c ON b.category_id = c.id 
                    JOIN users u ON b.user_id = u.id
                    ORDER BY b.id DESC 
                    LIMIT ?, ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $data["offset"], $data["limit"]);

        $stmt->execute();
        $result = $stmt->get_result();

        $blogs =  $result->fetch_all(MYSQLI_ASSOC) ?? [];

        $count_query = "SELECT COUNT(*) as total FROM blogs";
        $count_result = $this->conn->query($count_query);
        $total = $count_result->fetch_assoc()["total"]??0;

        return [
            "blogs" => $blogs,
            "total" => $total
        ];
    }

    public function search($data)
    {
        $query = "%" . $data["query"] . "%";
        $category_id = $data["category_id"];
        $offset = $data["offset"];
        $limit = $data["limit"];

        // Base SQL for rows
        if ($category_id == 0) {
            $sql = "SELECT b.id, b.title, b.status, b.featured_image, b.created_at,
                       c.name AS category, u.name AS author
                FROM blogs b
                JOIN categories c ON b.category_id = c.id
                JOIN users u ON b.user_id = u.id
                WHERE b.title LIKE ?
                ORDER BY b.id DESC
                LIMIT ?, ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $query, $offset, $limit);

            // Count query
            $countSql = "SELECT COUNT(*) as total
                     FROM blogs b
                     JOIN categories c ON b.category_id = c.id
                     WHERE b.title LIKE ?";
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->bind_param("s", $query);
        } else {
            $sql = "SELECT b.id, b.title, b.status, b.featured_image, b.created_at,
                       c.name AS category, u.name AS author
                FROM blogs b
                JOIN categories c ON b.category_id = c.id
                JOIN users u ON b.user_id = u.id
                WHERE b.title LIKE ? AND c.id = ?
                ORDER BY b.id DESC
                LIMIT ?, ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("siii", $query, $category_id, $offset, $limit);

            // Count query with category filter
            $countSql = "SELECT COUNT(*) as total
                     FROM blogs b
                     JOIN categories c ON b.category_id = c.id
                     WHERE b.title LIKE ? AND c.id = ?";
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->bind_param("si", $query, $category_id);
        }

        // Execute main query
        $stmt->execute();
        $result = $stmt->get_result();
        $blogs = $result->fetch_all(MYSQLI_ASSOC)??[];

        // Execute count query
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $total = $countResult->fetch_assoc()["total"]??0;

        return [
            "blogs" => $blogs,
            "total" => $total
        ];
    }



    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM blogs";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int) $row['total'];
    }



    public function findById($id)
    {
        $sql = "SELECT b.*, u.name as author,u.username,u.id as user_id FROM blogs b JOIN users u ON b.user_id = u.id  WHERE b.id=?";
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

    public function findByUserId($id)
    {
        $sql = "SELECT b.*, c.name as category FROM blogs b JOIN categories c ON b.category_id = c.id  WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function findByTitle($title)
    {

        $sql = "SELECT * FROM blogs WHERE title LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $query = "%" . $title . "%";
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function findByCategory($data)
    {


        $sql = "SELECT b.*, c.name as category, u.name as author, u.profile_image as author_image FROM blogs b JOIN categories c ON b.category_id = c.id JOIN users u ON b.user_id = u.id WHERE category_id = ? LIMIT ?,?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $data["category_id"], $data["offset"], $data["limit"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function findFeatured()
    {
        $featured = "on";
        $sql = "SELECT b.*, u.name as author, u.profile_image as user_image, c.name as category FROM blogs b JOIN users u ON b.user_id = u.id JOIN categories c ON b.category_id = c.id WHERE featured = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $featured);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function create()
    {
        $sql = "INSERT INTO blogs (title, content,excerpt featured_image, category_id, user_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssii", $this->title, $this->content, $this->excerpt, $this->featured_image, $this->category, $this->user_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return $this;
        } else {
            return false;
        }
    }
    public function update($id, $data)
    {


        $sql = "UPDATE blogs SET title=?,content=?, excerpt=?, featured_image=?,category_id=?, status = ?, featured=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssissi", $data["title"], $data["content"], $data["excerpt"], $data["featured_image"], $data["category"], $data["status"], $data["featured"], $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {

            return false;
        }
    }
    public function delete($id)
    {

        $sql = "DELETE FROM blogs WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {

            return false;
        }
    }
}
