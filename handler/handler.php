<?php


if(!isset($_REQUEST["action"]) || !isset($_REQUEST["controller"])){

    header("location: not-found.php");

}


$action = $_REQUEST["action"];
$controller = $_REQUEST["controller"];
// User Controller Section
if ($controller == "UserController") {

    require_once(__DIR__."/../controllers/UserController.php");
    $controller = new UserController();


    switch ($action) {
        case "register":
            $data = [
                "username" => $_REQUEST["username"],
                "email" => $_REQUEST["email"],
                "password" => $_REQUEST["password"],
                "confirm_password" => $_REQUEST["confirm_password"]
            ];
            echo json_encode($controller->register($data));
            break;

        case "login":
            $data = [
                "email" => $_REQUEST["email"],
                "password" => $_REQUEST["password"],
            ];
            echo json_encode($controller->login($data));
            break;
        case "update_details":
            $data = [
                "email"=> $_REQUEST["email"],
                "username"=> $_REQUEST["username"],
                "name"=> $_REQUEST["name"],
                "bio"=> $_REQUEST["bio"],
                "profile_image"=> $_FILES["profile_image"]??"",
            ];
            echo json_encode($controller->update_details($data));
            break;

        case "update_password":
            $data = [
                "current_password"=> $_REQUEST["current_password"],
                "new_password"=> $_REQUEST["new_password"],
                "confirm_password"=> $_REQUEST["confirm_password"],
            ];
            echo json_encode($controller->update_password($data));
            break;

       
    }
}


// Blog Controller Section

if ($controller=="BlogController") {

    require_once(__DIR__."/../controllers/BlogController.php");

    $controller = new BlogController();


    switch ($action) {

        case "create":
            $data = [
                "title" => $_REQUEST["title"]??"",
                "category" => $_REQUEST["category"]??"",
                "content" => $_REQUEST["content"]??"",
                "excerpt" => $_REQUEST["excerpt"]??"",
                "featured_image" => $_FILES["featured_image"] ?? ""
            ];
            echo json_encode($controller->create($data));
            break;

        case "findById":
            $id = $_POST["id"];
            echo json_encode($controller->findById($id));
            break;

        case "findByUserId":
            echo json_encode($controller->findByUserId());
            break;

        case "findAll":
            $data = [
                "limit"=> $_REQUEST["limit"]??9,
                "offset"=> $_REQUEST["offset"]??0,
                "query"=> $_REQUEST["query"]??"",
                "category_id"=> $_REQUEST["category_id"]??0
            ];
            echo json_encode($controller->findAll($data));
            break;

        case "findByCategory":
            $data = [
                "category_id"=>$_REQUEST["category_id"],
                "offset"=> $_REQUEST["offset"],
                "limit"=> $_REQUEST["limit"]
            ];
           
            echo json_encode($controller->findByCategory($data));
            break;

        case "update":
            $id = $_POST["id"];
            $data = [
                "title" => $_POST["title"]??"",
                "content" => $_POST["content"]??"",
                "excerpt"=> $_POST["excerpt"]??"",
                "featured_image" => $_FILES["featured_image"]??"",
                "category" => $_POST["category"]??"",
            ];
            echo json_encode($controller->update($id, $data));
            break;
        case "delete":
            $id = $_POST["id"];
            echo json_encode($controller->delete($id));
            break;
    }
}

if ($controller == "CategoriesController") {


}

if ($controller=="CommentsController") {

    require_once(__DIR__."/../controllers/CommentsController.php");
    $controller = new CommentsController();

    switch($action){
        case "create":
            $data = [
                "content"=> $_POST["comment"],
                "blog_id"=> $_POST["blog_id"],
            ];
            echo json_encode($controller->create($data));
            break;

        case "findAll":
            $blog_id = $_POST["blog_id"];
            echo json_encode($controller->findByBlogId($blog_id));
            break;
    }


}

if ($controller == "ContactsController") {

    require_once(__DIR__ ."/../controllers/ContactsController.php");
    $contact_controller = new ContactsController();

    switch($action){
        case "create":
            $data = [
                "name"=>$_POST["name"]??"",
                "email"=>$_POST["email"]??"",
                "subject"=>$_POST["subject"]??"",
                "message"=>$_POST["message"]??""
                ];
                
            echo json_encode($contact_controller->create($data));
            break;

    }
}
