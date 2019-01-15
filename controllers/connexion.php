<?php
//function redirection éviter les erreurs header
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

// autoloader
require '../models/class/autoloader.php';
Autoloader::registerChecks();

session_start();

// chargement des classes
$userManager = new userManager();

// ajout et connexion membre si infos ok
if(isset($_POST['pseudo'])) {
    $user = new user([
        'pseudo' => htmlspecialchars($_POST['pseudo']),
        'mail' => htmlspecialchars($_POST['email']),
        'pass' => htmlspecialchars($_POST['pass'])
    ]);
    if($userManager->verifInscription($user)){
        $userManager->add($user);
        $userManager->connect($user);
        redirect_to('location:admin.php');
    }else{
        redirect_to('location:../index.php?creat');
    }

}

// Vérification et connexion de l'utilisateur si infos ok
if (isset($_POST['pseudoCo'])) {
    $user = new user([
        'pseudo' => htmlspecialchars($_POST['pseudoCo']),
        'pass' => htmlspecialchars($_POST['pass'])
    ]);
    if($userManager->connect($user)){
        redirect_to('location:admin.php');
    }
    else{
        redirect_to('location:../index.php?error=1');
    }
}

// Déconnecte l'utilisateur
if(isset($_GET['deco'])){
    $userManager->logout($_SESSION['id']);
    redirect_to('location:../index.php');
}
