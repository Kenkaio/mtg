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

// si pas de session retour à la page de connexion
if (empty($_SESSION)) {
    redirect_to('location:../index.php');
}
else{
    // chargement des classes
    $userManager = new userManager();
    $deck = new deckManager();
    $cards = new cards();

    $pseudo = $userManager->getPseudoById($_SESSION['id']);

    // ajout d'un deck
    if(isset($_POST['formDeckName'])){

    }



    // récupère la liste de tous les decks de l'utilisateur
    if (isset($_GET['decks'])) {
        $getAllDecks = $deck->getAllDecks($pseudo['id']);

        $arrayName = [];
        while($getAllDeck = $getAllDecks->fetch(PDO::FETCH_OBJ)){
            if (!array_key_exists($getAllDeck->type, $arrayName)) {
                $arrayName[$getAllDeck->type] = [];
            }
            $arrayName[$getAllDeck->type][] = $getAllDeck;
        }
        if ($_GET['decks'] != null && $_GET['decks'] != 'new' && $_GET['decks'] != 'newDuel') {
            $deck = $deck->getDeckByName($_GET['decks'], $pseudo['id']);
            require('../views/detailDeck.php');
        }
        else if ($_GET['decks'] == 'new') {
            require('../views/chooseList.php');
        }
        else{
            require('../views/decks.php');
        }
        echo '<script>addActive(decks);</script>';
    }
}
