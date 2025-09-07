<?php
require_once(__DIR__."/../controllers/UserController.php");
require_once(__DIR__."/Auth.php");

function checkAdmin(){

    if(auth()){
        $id = $_SESSION["id"];
        $user = (new UserController())->findById($id);

        if($user["role"] == "admin"){
            return true;
        }else{
            return false;
        }
    
    }else{
        return false;
    }
}