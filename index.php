<?php

require 'models/class/autoloader.php';
Autoloader::register();

session_start();

require('controllers/backend.php');
require('controllers/frontend.php');

try {

    if(isset($_GET['action'])){

        $db = dataBase::dbConnect();

        if (empty($_SESSION)) {
            switch ($_GET['action']) {

                case 'tryConnect':
                    tryConnect($_POST);
                    break;

                case 'viewCreateUser':
                    require('views/createUser.php');
                    break;

                case 'errorCo':
                    require('views/index.php');
                    echo "<script>errorCo()</script>";
                    break;

                case 'checkPseudo':
                    checkPseudo($db, $_POST['pseudo']);
                    break;

                case 'checkMail':
                    checkMail($db, $_POST['mail']);
                    break;

                default:
                    require('views/index.php');
                    break;
            }
        }
        else{
            $userManager = new userManager();
            $deck = new deckManager();
            $matches = new matches();
            $list = new lists();
            $cards = new cards();

            $pseudo = $userManager->getPseudoById($_SESSION['id']);

            switch ($_GET['action']) {

                case 'connected':
                    if (empty($_SESSION)) {
                        header('location:index.php?action=authentification');
                    }
                    else{
                        viewAdmin($deck, $matches, $pseudo);
                    }
                    break;

                case 'createUser':
                    insertPseudo($_POST);
                    break;

                case 'disconnect':
                    disconnect();
                    break;

                case 'viewDecks':
                    allDecks($pseudo, $deck, $userManager);
                    break;

                case 'newDeck':
                    require('views/chooseList.php');
                    if ($_GET['error'] == 1) {
                        echo '<script>errorDeckName();</script>';
                    }
                    break;

                case 'addNewDeck':
                    addNewdeck($pseudo, $deck, $_POST['formDeckName'], $_POST['type']);
                    break;

                case 'detailDeck':
                    detailDeck($deck, $list, $pseudo, $_GET['id']);
                    break;

                case 'cardList':
                    cardList($deck, $list, $_POST['cardList']);
                    break;

                case 'membersList':
                    membersList($userManager);
                    break;

                case 'matchesByYear':
                    matchesByYear($pseudo, $matches, $_POST['matches']);
                    break;

                case 'addCardToList':
                    addCardToList($cards, $_POST['addCardToList']);
                    break;

                case 'listCommander':
                    listCommander($deck, $_POST['selectCommander']);
                    break;

                case 'addCommander':
                    addCommander($cards, $list, $_POST['addCommander']);
                    break;

                case 'confirmList':
                    confirmList($list);
                    break;

                case 'oldList':
                    oldList($list, $_POST['oldList']);
                    break;

                case 'changeNumber':
                    changeNumber($_POST['numberId'], $_POST['changeNumber']);
                    break;

                default:
                    require('views/error404.php');
                    break;
            }
        }
    }
    else{
        header('location:index.php?action=connected');
    }

}
catch(Exception $e) {
	echo 'Erreur: ' . $e->getMessage();
}
