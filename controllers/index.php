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
    if(isset($_GET['error'])){
        if ($_GET['error'] == 1) {
            echo "<script>errorCo();</script>";
        }
    }
}
else{
    redirect_to('location:controllers/admin.php');
}
