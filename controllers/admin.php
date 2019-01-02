<?php
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

require '../models/class/autoloader.php';
Autoloader::registerChecks();

if (empty($_SESSION)) {
    redirect_to('location:../index.php');
}
else{
    $userManager = new userManager();
    $pseudo = $userManager->getPseudoById($_SESSION['id']);
    $decks = new decks();
    $matches = new matches();
    $getDecks = $decks->getAllDecks($pseudo['id']);
    $getMatches = $matches->getAllMatches($pseudo['id']);
    require('../views/dashboard.php');
}


