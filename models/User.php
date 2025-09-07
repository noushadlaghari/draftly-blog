<?php

require_once(__DIR__ . "/../database/database.php");

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


    public function findAll($data)
    {

        $sql = "SELECT * FROM users LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $data["offset"], $data["limit"]);
        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $data;
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


    public function update_password($id, $data)
    {

        $sql = "UPDATE users SET password = ? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data["new_password"], $id);
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
