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
    $list = new lists();
    $cards = new cards();

    $pseudo = $userManager->getPseudoById($_SESSION['id']);

    // ajout d'un deck
    if(isset($_POST['deckName'])){
        if($_POST['deckName'] != 'undefined'){
            $decks = new decks([
                'idUser' => htmlspecialchars($pseudo['id']),
                'name' => htmlspecialchars($_POST['deckName']),
                'type' => htmlspecialchars($_POST['type'])
            ]);
            $deck->addDeck($decks);
            redirect_to('location:deck.php?decks='.$name);
        }
        else{
            redirect_to("location:deck.php?decks=new");
        }
    }

    // sélection et affiche les infos du deck choisit par l'utilisateur
    if(isset($_GET['deck'])){
        $deckInfo = $deck->getDeckByName($_GET['deck'], $pseudo['id']);
        $returnDeck = $deckInfo->fetch(PDO::FETCH_OBJ);
        if (!empty($returnDeck)) {
            $decks = new decks([
                'id' => htmlspecialchars($returnDeck->id),
                'idUser' => htmlspecialchars($returnDeck->idUser),
                'name' => htmlspecialchars($returnDeck->name),
                'type' => htmlspecialchars($returnDeck->type)
            ]);
            if($decks->getType() == 'Duel'){
                $checkCommander = $list->getListByDeckId($decks->getId());
                $returnCommander = $checkCommander->fetchAll(PDO::FETCH_OBJ);
                $letters = array("U", "G", "R", "B", "W", "P");
                $afterLetters = array();
                for ($i=0; $i < count($letters); $i++) {
                    $afterLetters[$i] = "<img src='../public/images/mana/" . $letters[$i] . ".png'' width='40px'/>";
                }
                if(count($returnCommander) != 0){
                    $commanderSelected = false;
                    $color = str_replace($letters, $afterLetters, $returnCommander[0]->colors);
                    $color = str_replace(',', '', $color);
                }
                else{
                    $commanderSelected = true;
                }
                file_put_contents('../public/assets/json/list.json', $returnCommander[0]->cards);
                $_SESSION['allDeckInformations'] = $decks;
                require('../views/newList.php');
                echo'<script>seeDiv('.$returnCommander[0]->cards.');</script>';
                $history = $list->getOldList($decks)->fetchAll(PDO::FETCH_OBJ);
                for ($i=0; $i < count($history); $i++) {
                    $date = $history[$i]->date;
                    echo'<script>seeHistoric(\''.$date.'\');</script>';
                }
            }
        }
        else{
            redirect_to('location:../controllers/deck.php?decks');
        }
        echo '<script>addActive(decks);</script>';
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



