<?php

/* -------- Ajoute et connecte un utilisateur si infos correctes --------- */
function insertPseudo($post){
    $userManager = new userManager();
    $user = new user([
        'pseudo' => htmlspecialchars($post['pseudo']),
        'mail' => htmlspecialchars($post['email']),
        'pass' => htmlspecialchars($post['pass'])
    ]);
    if($userManager->verifInscription($user)){
        $userManager->add($user);
        $userManager->connect($user);
        header('location:index.php?action=connected');
    }else{
        header('location:index.php?action=viewCreateUser');
    }
}

/* -------- Tentative connection utilisateur --------- */
function tryConnect($post){
    $userManager = new userManager();
    $user = new user([
        'pseudo' => htmlspecialchars($post['pseudoCo']),
        'pass' => htmlspecialchars($post['pass'])
    ]);
    if($userManager->connect($user)){
        header('location:index.php?action=connected');
    }
    else{
        header('location:index.php?action=errorCo');
    }

}

/* -------- Déconnexion utilisateur --------- */
function disconnect(){
    $userManager = new userManager();
    $userManager->logout($_SESSION['id']);
    header('location:index.php?action=authentification');
}

/* -------- Vérification pseudo non présent BDD --------- */
function checkPseudo($db, $pseudo){
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

/* -------- Vérification mail non présent BDD --------- */
function checkMail($db, $mail){

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


function membersList($userManager){
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


function addCardToList($cards, $cardName){
    $cardInfo = $cards->getCardByName($cardName);
    $changeNumber = false;

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
        else if(strstr($cardInfo->type, "Land")) {
            $type = 'land';
        }
        else{
            $type = strtolower($cardInfo->type);
        }

        if (strstr($cardInfo->type, "Basic Land")) {
            $changeNumber = true;
        }

        $json_source = file_get_contents('public/assets/json/list.json');
        $var = json_decode($json_source, true);

        $jsonNumberCards = file_get_contents('public/assets/json/numbersCards.json');
        $varNumber = json_decode($jsonNumberCards, true);

        $dontChangeNumber = false;

        if(array_key_exists($type, $var)){
            if (in_array($cardInfo->name, $var[$type]) || in_array($cardInfo->name . '(Number1)', $var[$type])) {
                echo 'added';
                $dontChangeNumber = true;
            }
            else{
                if($changeNumber){
                    $value = $cardInfo->name . '(Number1)';
                }
                else{
                    $value = $cardInfo->name;
                }
                $var[$type] = is_array($var[$type]) ? array_merge($var[$type], [$value]) : [$var[$type], $value];
            }

        }
        else{
            if($changeNumber){
                    $value = $cardInfo->name . '(Number1)';
                }
                else{
                    $value = $cardInfo->name;
                }
            $var[$type] = [$value];

        }

        if (!$dontChangeNumber) {
            if(array_key_exists($type, $varNumber)){
                $varNumber[$type] = $varNumber[$type] + 1;
            }
            else{
                $varNumber[$type] = 1;
            }
        }

        $put = json_encode($var);
        file_put_contents('public/assets/json/list.json', $put);

        $putNumber = json_encode($varNumber);
        file_put_contents('public/assets/json/numbersCards.json', $putNumber);
    }
}

function addCommander($cards, $lists, $commanderName){
    $type = $_SESSION['allDeckInformations']->getType();
    switch ($type) {
        case 'Multi':
            $type = 'commander';
            break;
        case 'Duel':
            $type = 'duel';
            break;
        default:
            break;
    }

    $req = $cards->getCardByName($commanderName);
    $card = $req->fetch(PDO::FETCH_OBJ);
    if($card->{$type} == "Legal"){
        $add = $lists->addCommanderToList($_SESSION['allDeckInformations'], $card);
    }else{
        echo 'notLegal';
    }
}

function confirmList($lists){

    $req = $lists->getCardsLists($_SESSION['allDeckInformations']);
    $cardList = $req->fetch(PDO::FETCH_OBJ);

    $json_source = file_get_contents('public/assets/json/list.json');
    $numbers = file_get_contents('public/assets/json/numbersCards.json');
    $addCards = $lists->addCardsToList($_SESSION['allDeckInformations'], $json_source, $numbers);
    if($cardList->cards != '' &&  $cardList->cards != $json_source){
        $addToOldList = $lists->addToOldList($_SESSION['allDeckInformations'], $cardList->cards, $numbers);
    }
}


function changeNumber($numberId, $newNumber){
    $id = substr($numberId, 6);
    $numberPost = $newNumber - 1;
    $json_source = file_get_contents('public/assets/json/list.json');
    $var = json_decode($json_source, true);

    $number = $numberPost + count($var['land']);
    $numbers = file_get_contents('public/assets/json/numbersCards.json');
    $varNumbers = json_decode($numbers, true);
    for ($i=0; $i < count($var['land']); $i++) {
        if (strstr($var['land'][$i], $id.'(Number')) {
            $var['land'][$i] = $id.'(Number'.$number.')';
        }
    }
    $put = json_encode($var);
    file_put_contents('public/assets/json/list.json', $put);

    $varNumbers['land'] = intval($number);
    $putNumbers = json_encode($varNumbers);
    file_put_contents('public/assets/json/numbersCards.json', $putNumbers);
}

function addNewDeck($pseudo, $deck, $name, $type){
    if($name != 'undefined'){
        $verify = $deck->getDeckByNameAndType($name, $type, $pseudo->id);
        if(!$verify->fetch()){
            $decks = new decks([
                'idUser' => htmlspecialchars($pseudo->id),
                'name' => htmlspecialchars($name),
                'type' => htmlspecialchars($type)
            ]);
            $deck->addDeck($decks);
            $req = $deck->getDeckByNameAndType($name, $type, $pseudo->id);
            $id = $req->fetch(PDO::FETCH_OBJ);
            header('location:index.php?action=detailDeck&id='.$id->id);
        }
        else{
            header("location:index.php?action=newDeck&error=1");
        }
    }
    else{
        header("location:index.php?action=newDeck");
    }
}
