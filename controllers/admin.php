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

// chargement page admin perso
if (empty($_SESSION)) {
    redirect_to('location:../index.php');
}
else{
    $userManager = new userManager();
    $decks = new deckManager();
    $matches = new matches();

    $pseudo = $userManager->getPseudoById($_SESSION['id']);
    $getDecks = $decks->getAllDecksLimit($pseudo['id']);
    $getMatches = $matches->getAllMatchesLimit($pseudo['id']);
    if(isset($_POST['matches'])){
        $matches->matchesInJson($pseudo['id'], $_POST['matches']);
    }
    require('../views/dashboard.php');
}
