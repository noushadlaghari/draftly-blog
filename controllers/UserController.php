<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../middlewares/Auth.php");
require_once(__DIR__ . "/../middlewares/Admin.php");


class UserController
{


    public function index()
    {

        // $users = (new User())->findAll();

        require("./../admin/index.php");
    }
    public function register($data = array())
    {

        $errors  = array();

        $response = array();


        if (empty($data["username"])) {
            $errors["username"] = "Username Field is required!";
        }
        if (empty($data["password"])) {
            $errors["password"] = "Password Field is required!";
        }
        if (empty($data["confirm_password"])) {
            $errors["confirm_password"] = "Confirm Password Field is required!";
        }

        if (!empty($data["password"]) && !empty($data['confirm_password'])) {

            if ($data["password"] != $data["confirm_password"]) {
                $errors["confirm_password"] = "confirm Password Should Match Password!";
            }
        }

        if (empty($data["email"])) {
            $errors["email"] = "Email field is required!";
        } else {
            if ($this->validate_email($data["email"])) {
                $errors["email"] = "Invalid Email!";
            }
        }

        if (sizeof($errors) > 0) {

            $response = [
                "errors" => $errors
            ];

            return $response;
        } else {

            $user = new User();
            $user->username = $data["username"];
            $user->email = $data["email"];
            $user->password = $data["password"];

            if ($user->create()) {
                return  [
                    "status" => "success",
                    "message" => "You've Successfully Registered!"
                ];
            } else {

                return [
                    "status" => "error",
                    "message" => "Unknown Error During Registration!"
                ];
            }
        }
    }


    public function login($data = array())
    {

        $response = array();

        if (isset($data["email"]) && isset($data["password"])) {

            $user = (new User())->findByEmail(trim($data["email"]));


            if ($user) {

                if ($data["password"] == $user["password"]) {


                    $_SESSION["id"] = $user["id"];

                    return [
                        "status" => "success",
                        "message" => "You've Successfully Logged In!"
                    ];
                } else {

                    return [
                        "status" => "error",
                        "message" => "Invalid Email or Password!",
                    ];
                }
            } else {

                return [
                    "status" => "error",
                    "message" => "Invalid Email or Password!"
                ];
            }
        } else {

            return [
                "status" => "error",
                "message" => "Email and Password are required!"
            ];
        }
    }

    public function findById($id)
    {
        $user = (new User())->findById($id);
        if ($user) {
            return $user;
        }
        return false;
    }

    public function findAll($data = array())
    {
        $Users = (new User())->findAll($data);
        if ($Users) {
            return [
                "status" => "success",
                "users" => $Users
            ];
        }
        return [
            "status" => "error",
            "message" => "Not Found!",
            "code" => 404

        ];
    }

    public function update_details($data = array())
    {

        if (!auth()) {
            return [
                "code" => 401,
                "status" => "error",
                "message" => "Unauthorized Access"
            ];
        }



        $id = $_SESSION['id'];

        $errors = array();
        // Validation
        if (empty($data["email"])) {
            $errors["email"] = "Email Field is required!";
        }
        if (empty($data["username"])) {
            $errors["username"] = "Username Field is required!";
        }
        if (empty($data["name"])) {
            $errors["name"] = "Name field is required!";
        }

        $profile_image = null;

        $previous_image = null;

        // ✅ Handle File Upload
        if (isset($data["profile_image"]) && $data["profile_image"]["error"] === 0) {
            $file = $data["profile_image"];
            $target_dir = __DIR__ . "/../public/images/profiles/";

            // ensure folder exists
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));


            // validate file is image
            $check = getimagesize($file["tmp_name"]);
            if ($check === false) {
                $errors["profile_image"] = "File is not a valid image!";
            }

            // allow only specific types
            $allowed_types = ["jpg", "jpeg", "png"];
            if (!in_array($imageFileType, $allowed_types)) {
                $errors["profile_image"] = "Only JPG, JPEG & PNG allowed";
            }

            if ($file["size"] > 2 * 1024 * 1024) {
                $errors["profile_image"] = "File size must be under 2MB.";
            }


            if (empty($errors)) {
                // generate unique filename
                $newFileName = uniqid("profile_", true) . "." . $imageFileType;
                $target_file = $target_dir . $newFileName;

                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    // save relative path for DB
                    $profile_image = "images/profiles/" . $newFileName;
                    $user = (new User())->findById($_SESSION["id"]);


                    if (!empty($user["profile_image"])) {
                        $previous_image = __DIR__ . "/../public/" . $user["profile_image"];
                        if ($previous_image) {

                            if (file_exists($previous_image)) {
                                unlink($previous_image);
                            }
                        }
                    }
                } else {
                    $errors["profile_image"] = "Error uploading file!";
                }
            }
        }

        if (!empty($errors)) {
            return [
                "status" => "error",
                "errors" => $errors
            ];
        }

        if ($profile_image != null || !empty($profile_image)) {
            $data["profile_image"] = $profile_image;
        } else {
            unset($data["profile_image"]);
        }


        // Call Model
        $user = new User();
        if ($user->update_details($id, $data)) {
            return [
                "status" => "success",
                "message" => "Details Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Update Details!"
            ];
        }
    }

    public function update_user($data = array())
    {

        if (!checkAdmin()) {
            return [
                "status" => "error",
                "message" => "Unauthorized Access!",
                "code" => 401
            ];
        }

            $user = new User();

            if($user->update_user($data)){
                return [
                    "status"=> "success",
                    "message"=> "User Details Update Successfully!"
                    ];
            }else{
                return [
                    "status"=> "error",
                    "message"=> "No Changes were made!"
                    ];
            }

        }

     
    

    public function update_password($data = array())
    {

        if (!auth()) {
            return [
                "code" => 401,
                "status" => "error",
                "message" => "Unauthorized Access"
            ];
        }

        $id = $_SESSION["id"];
        $user = (new User())->findById($id);
        $errors = array();

        if (empty($data["current_password"])) {
            $errors["current_password"] = "Current password is required!";
        } else if ($data["current_password"] != $user["password"]) {
            $errors["current_password"] = "Incorrect Current Password";
        }

        if (empty($data["new_password"])) {
            $errors["new_password"] = "New Password is required!";
        }

        if (empty($data["confirm_password"])) {
            $errors["confirm_password"] = "Confirm Password is Required";
        }

        if ($data["new_password"] != $data["confirm_password"]) {
            $errors["confirm_password"] = "Confirm Password Should Match New Password!";
        }



        if (!empty($errors)) {
            return [
                "status" => "error",
                "errors" => $errors
            ];
        }

        $user = new User();

        if ($user->update_password($id, $data)) {
            return [
                "status" => "success",
                "message" => "Password Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Your new password same as Old password"
            ];
        }
    }

    private function validate_email($email)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    public function delete($id)
    {
        if ($id == null) {
            return [
                "status" => "error",
                "message" => "Invalid Parameters!"
            ];
        }

        $user = new User();


        if ($user->delete($id)) {
            return [
                "status" => "success",
                "message" => "User Account Successfully Deleted!"
            ];
        } else {

            return [
                "status" => "error",
                "message" => "Unable to Delete Account!"
            ];
        }
    }

    public function deleteProfileImage($id)
    {

        if ($id == null || $id == "" || empty($id)) {
            return [
                "status" => "error",
                "message" => "User not found!",
                "code" => 404
            ];
        }

        if ($id != $_SESSION["id"] && !checkAdmin()) {

            return [
                "status" => "error",
                "message" => "Unauthorized Access!",
                "code" => 401
            ];
        }

        $user = (new User())->findById($id);

        if (!$user) {
            return [
                "status" => "error",
                "message" => "User not found!",
                "code" => 404
            ];
        }


        $userModel = new User();


        if (!empty($user["profile_image"])) {

            $baseDir = realpath(__DIR__ . "/../public/images/profiles");
            $filePath = realpath(__DIR__ . "/../public/" . $user["profile_image"]);

            if ($filePath && strpos($filePath, $baseDir) === 0 && file_exists($filePath)) {
                unlink($filePath);
            }

            if ($userModel->deleteProfileImage($id)) {
                return [
                    "status" => "success",
                    "message" => "Profile Picture Successfully Deleted!"
                ];
            } else {

                return [
                    "status" => "error",
                    "message" => "Unable to Delete Profile Picture!"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "No profile image found for this user!"
            ];
        }
    }
}
