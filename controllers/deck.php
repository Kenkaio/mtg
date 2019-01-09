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
    $decks = new decks();

    $pseudo = $userManager->getPseudoById($_SESSION['id']);

    if(isset($_POST['deckName'])){
        if($_POST['deckName'] != 'undefined'){
            $name = htmlspecialchars($_POST['deckName']);
            $decks->addDeck($pseudo['id'], $name, $_POST['type']);
            redirect_to('location:deck.php?decks='.$name);
        }
        else{
            redirect_to("location:deck.php?decks=new");
        }
    }

    if(isset($_GET['deck'])){
        $deckInfo = $decks->getDeckByName($_GET['deck'], $pseudo['id']);
        $deckType = $deckInfo->fetch();

        if ($_GET['deck'] === $deckType['name']) {
            require('../views/newList.php');
        }
        else{
            redirect_to('location:../controllers/deck.php?decks');
        }


        echo '<script>addActive(decks);</script>';
    }

    if (isset($_GET['decks'])) {
        $getAllDecks = $decks->getAllDecks($pseudo['id']);

        $arrayName = [];

        while($getAllDeck = $getAllDecks->fetch(PDO::FETCH_OBJ)){
            if (!array_key_exists($getAllDeck->type, $arrayName)) {
                $arrayName[$getAllDeck->type] = [];
            }
            $arrayName[$getAllDeck->type][] = $getAllDeck;
        }
        if ($_GET['decks'] != null && $_GET['decks'] != 'new' && $_GET['decks'] != 'newDuel') {
            $deck = $decks->getDeckByName($_GET['decks'], $pseudo['id']);
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



