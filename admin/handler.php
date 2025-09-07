<?php 
require_once(__DIR__ ."/../middlewares/Admin.php");
if (!checkAdmin()) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized Access!",
        "code" => 403
    ]);
    exit; // stop execution immediately
}



if(!isset($_POST["controller"])&&!isset($_POST["action"])){
    echo json_encode(["status"=>"error","message"=> "Unauthorized Access!"]);
    }
    $controller = $_POST["controller"];
    $action = $_POST["action"];
    
    if($controller=="UserController"){
        
        require_once(__DIR__ ."/../controllers/UserController.php");
        $controller = new UserController();
        
        switch($action){
            case "findAll":
                $data = [
                    "offset"=> $_POST["offset"]??0,
                    "limit"=> $_POST["limit"]??6
                ];
                echo json_encode($controller->findAll($data));
                break;
            case "findById":
                $user_id = $_POST["user_id"]??null;
                echo json_encode($controller->findById($user_id));
                break;
            case "update":
                $data = [
                    "user_id"=> $_POST["user_id"]??null,
                    "username"=> $_POST["username"]??"",
                    "email"=> $_POST["email"]??"",
                    "name"=> $_POST["name"]??"",
                    "bio"=> $_POST["bio"]??"",
                    "role"=> $_POST["role"]??"user",
                    "status"=> $_POST["status"]??"active",
                    "email_verified"=> !empty($_POST["email_verified"])?"true":"false",
                ];
                echo json_encode($controller->update_user($data));
                break;
            case "delete":
                $user_id = $_POST["user_id"]??null;
                echo json_encode($controller->delete($user_id));
                break;

            case "deleteProfileImage":
                $user_id = $_POST["user_id"]??null;
                echo json_encode($controller->deleteProfileImage($user_id));
                break;
                        
            
                        
                    }

    }

    if($controller == "BlogController"){
        require_once(__DIR__ ."/../controllers/BlogController.php");
        $controller = new BlogController();
        switch($action){
            case "findAll":
                $data = [
                    "offset"=> $_POST["offset"]??0,
                    "limit"=> $_POST["limit"]??6,
                ];
                echo json_encode($controller->findAll($data));
                break;
            case "delete":
                $blog_id = $_POST["blog_id"]??null;
                echo json_encode($controller->delete($blog_id));
                break;

            case "findById":
                $blog_id = $_POST["blog_id"]??null;
                echo json_encode($controller->findById($blog_id));
                break;

            case "update":
                $blog_id = $_POST["blog_id"]??null;
                $data = [
                    "title"=> $_POST["title"]??"",
                    "content"=> $_POST["content"]??"",
                    "excerpt"=> $_POST["excerpt"]??"",
                    "category"=> $_POST["category"]??"",
                    "status"=> $_POST["status"]??"pending",
                    "featured_image"=> $_FILES["featured_image"]??"",
                    "featured"=> $_POST["featured"]??"off",
                ];
                echo json_encode($controller->update($blog_id,$data));
              
                break;

            

            }
    }

?>