<?php
//function redirection éviter les erreurs header
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

// autoloader
require 'models/class/autoloader.php';
Autoloader::register();

session_start();

// chargement classes
$userManager = new userManager();

//si pas de et demande de création, alors on affiche la page en question,
//sinon c'est que session présente et redirection vers page d'admin
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
