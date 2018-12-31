<?php
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require 'models/class/autoloader.php';
Autoloader::register();
$userManager = new userManager();

if (empty($_SESSION['ouvert'])) {
    if(isset($_GET['creat'])){
        require 'views/createUser.php';
    }
    else{
        require 'views/index.php';
    }
}
else{
    redirect_to('location:controllers/admin.php');
}

