<?php
session_start();
    function auth(){
        if(isset($_SESSION["id"])){
            return true;
        }else{
            return false;
        }
    }


?>