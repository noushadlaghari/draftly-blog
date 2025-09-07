<?php

require_once(__DIR__ ."/middlewares/Auth.php");

session_start();

if(auth()){
    session_destroy();
    header("location: index.php");
}else{
    header("location: login.php");
}

?>