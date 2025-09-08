<?php
require_once(__DIR__ . "/../database/database.php");

class Contact
{


    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->get_connection();
    }

    public function create($data)
    {

        $sql = "INSERT INTO contacts(name,email,subject,message) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $data["name"], $data["email"], $data["subject"], $data["message"]);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc() ?? [];

        return $data;
    }

    public function findAll($offset, $limit)
    {
        $sql = "SELECT * FROM contacts LIMIT ?,?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC) ?? [];

        $count_query = "SELECT COUNT(*) as total FROM contacts";
        $stmt = $this->conn->prepare($count_query);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()["total"]??0;

        return [
            "total"=> $total,
            "data"=> $data
        ];
    }

        public function count(){
        $sql = "SELECT COUNT(*) as total FROM contacts";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()["total"]??0;

        return $total;

    }
    public function updateStatus($data)
    {

        $sql = "UPDATE contacts SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data["status"], $data["id"]);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM contacts WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
