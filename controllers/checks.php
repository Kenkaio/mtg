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
$deck = new deckManager();
$cards = new cards();
$lists = new lists();
$db = dataBase::dbConnect();

// Vérification si pseudo déjà présent bdd lors inscription (ajax)
if(isset($_POST['pseudo'])){

    $pseudo = $_POST['pseudo'];
    if(strlen($pseudo) == 0){
        echo ('empty');
    }
    else{
        $req = $db->query("SELECT pseudo FROM user WHERE pseudo='$pseudo'");

        $chk_pseudo = $req->fetch(PDO::FETCH_ASSOC);

        if($chk_pseudo == '1' || $chk_pseudo > '1'){
            echo ('no');
            $ok = false;
        }
        else{
            echo ('yes');
        }
    }
}

// Vérification si mail déjà présent bdd lors inscription (ajax)
if(isset($_POST['mail'])){

    $mail = $_POST['mail'];
    $req = $db->query("SELECT mail FROM user WHERE mail='$mail'");

    $chk_mail = $req->fetch(PDO::FETCH_ASSOC);

    if($chk_mail == '1' || $chk_mail > '1'){
        echo ('no');
        $ok = false;
    }
    else{
        echo ('yes');
    }
}

// retourne la liste des membres connectés
if(isset($_POST['members'])){
    $req = $userManager->connected();

    if($req != null){
        while($data = $req->fetch(PDO::FETCH_OBJ)){
            echo '<li>'. $data->pseudo .'</li>';
        }
    }
    else{
        echo ('0');
    }
}

// retourne le type de la carte (afin de les trier pour l'ajout dans la liste lors création deck)
if(isset($_POST['addCardToList'])){

    $cardName = $_POST['addCardToList'];
    $cardInfo = $cards->getCardByName($cardName);

    $cardInfo = $cardInfo->fetch(PDO::FETCH_OBJ);
    $type = strtolower($_SESSION['allDeckInformations']->getType());
    if (get_object_vars($cardInfo)[$type] == 'Legal' || get_object_vars($cardInfo)[$type] == 'Restricted') {
        if (strstr($cardInfo->type, "Creature")) {
            $type = 'creature';
        }
        else if(strstr($cardInfo->type, "Enchantment")) {
            $type = 'enchantment';
        }
        else if(strstr($cardInfo->type, "Sorcery") || strstr($cardInfo->type, "Instant")) {
            $type = 'spell';
        }
        else{
            $type = strtolower($cardInfo->type);
        }



        $json_source = file_get_contents('../public/assets/json/list.json');
        $var = json_decode($json_source, true);
        if(array_key_exists($type, $var)){
            if (in_array($cardInfo->name, $var[$type])) {
                echo 'added';
            }
            else{
                $var[$type] = is_array($var[$type]) ? array_merge($var[$type], [$cardInfo->name]) : [$var[$type], $cardInfo->name];
            }
        }
        else{
            $var[$type] = [$cardInfo->name];
        }

        $test = json_encode($var);
        file_put_contents('../public/assets/json/list.json', $test);
    }
}

// check si commander disponible lors de la création de liste
if(isset($_POST['selectCommander'])){
    $req = $deck->returnInfosCommanderCards($_POST['selectCommander']);
    $returnInfos = $req->fetchAll(PDO::FETCH_OBJ);
    if (count($returnInfos) != 0) {
        foreach($returnInfos as $data){
            echo '<li id="' . $data->name . '" class="commanderList">'. $data->name .'</li>';
        }
    }
    else{
        echo '<div class="errorNoCard">Not legal card</div>';
    }
}

// Ajoute commander bdd
if(isset($_POST['addCommander'])){
    $commanderName = $_POST['addCommander'];
    $req = $cards->getCardByName($commanderName);
    $card = $req->fetch(PDO::FETCH_OBJ);
    if($card->duel == "Legal"){
        $add = $lists->addCommanderToList($_SESSION['allDeckInformations'], $card);
    }else{
        echo 'notLegal';
    }
}

if(isset($_POST['confirmList'])){
    $req = $lists->getCardsLists($_SESSION['allDeckInformations']);
    $cardList = $req->fetch(PDO::FETCH_OBJ);
    $json_source = file_get_contents('../public/assets/json/list.json');
    $addCards = $lists->addCardsToList($_SESSION['allDeckInformations'], $json_source);
    if($cardList->cards != '' &&  $cardList->cards != $json_source){
        $addToOldList = $lists->addToOldList($_SESSION['allDeckInformations'], $cardList->cards);
    }

}
