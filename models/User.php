<?php

require_once(__DIR__ . "/../database/database.php");

date_default_timezone_set("Asia/Karachi");



class User
{

    private $conn;
    public $id;
    public $name;
    public $username;
    public $email;
    public $password;

    public $profile_image;

    public $role;


    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->get_connection();
    }

    public function findById($id)
    {

        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        return $data;
    }
    public function findByEmail($email)
    {

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data;
        }

        return false;
    }


    public function findAll($offset=0, $limit=8)
    {

        $sql = "SELECT * FROM users LIMIT ?,?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();       
        $users = $result->fetch_all(MYSQLI_ASSOC)??[];
        $stmt->close();

        $count_query = "SELECT COUNT(*) as total FROM users";
        $result = $this->conn->query($count_query);
        $total = $result->fetch_assoc()["total"]??0;


        return [
            "users"=> $users,
            "total"=> $total
        ];
    }

    public function count(){
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()["total"]??0;

        return $total;

    }

    public function create()
    {
        $sql = "INSERT INTO users(username,email,password) VALUES(?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $this->username, $this->email, $this->password);
        $stmt->execute();
        return $this;
    }


    public function update_user($data)
    {

        $sql = "UPDATE users SET name=?, username =?, email=?, bio=?, role = ?, status=?, email_verified=? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi", $data["name"], $data["username"], $data["email"], $data["bio"], $data["role"], $data["status"], $data["email_verified"], $data["user_id"]);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateLoginStatus($id){
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET last_login = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si",$date, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
        
    }


    public function update_details($id, $data)
    {
        if (!empty($data["profile_image"])) {
            // Update including profile image
            $sql = "UPDATE users SET name=?, username=?, email=?, bio=?, profile_image=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssi", $data["name"], $data["username"], $data["email"], $data["bio"], $data["profile_image"], $id);
        } else {
            // Update without profile image
            $sql = "UPDATE users SET name=?, username=?, email=?, bio=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $data["name"], $data["username"], $data["email"], $data["bio"], $id);
        }

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function update_password($id, $password)
    {

        $sql = "UPDATE users SET password = ? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $this;
        } else {
            return false;
        }
    }

    public function delete($id)
    {

        $sql = "DELETE FROM users WHERE id=?";


        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);


        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProfileImage($id)
    {
        $sql = "UPDATE users SET profile_image='' WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
