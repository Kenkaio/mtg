<?php
session_start();
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

require '../models/class/autoloader.php';
Autoloader::registerChecks();

$userManager = new userManager();

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

if (isset($_POST['pseudoCo'])) {
    $user = new user([
        'pseudo' => htmlspecialchars($_POST['pseudoCo']),
        'pass' => htmlspecialchars($_POST['pass'])
    ]);
    if($userManager->connect($user)){
        redirect_to('location:admin.php');
    }
    else{
        echo 'merde alors';
    }
}

if(isset($_GET['deco'])){
    $userManager->logout();
    redirect_to('location:../index.php');
}
