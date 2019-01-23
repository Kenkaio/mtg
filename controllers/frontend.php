<?php

/* -------- Page d'admin --------- */
function viewAdmin($deck, $matches, $pseudo){
    $getDecks = $deck->getAllDecksLimit($pseudo->id);
    $getMatches = $matches->getAllMatchesLimit($pseudo->id);
    require('views/dashboard.php');
}

/* -------- Liste de tous les decks de l'utilisateur --------- */
function allDecks($pseudo, $deck, $userManager){

    $getAllDecks = $deck->getAllDecks($pseudo->id);

    $arrayName = [];
    while($getAllDeck = $getAllDecks->fetch(PDO::FETCH_OBJ)){
        if (!array_key_exists($getAllDeck->type, $arrayName)) {
            $arrayName[$getAllDeck->type] = [];
        }
        $arrayName[$getAllDeck->type][] = $getAllDeck;
    }
    require('views/decks.php');
    echo '<script>addActive(decks);</script>';
}

/* -------- Détail d'un deck --------- */
function detailDeck($deck, $list, $pseudo, $id){
    $deckInfo = $deck->getDeckById($pseudo->id, $id);
    $returnDeck = $deckInfo->fetch(PDO::FETCH_OBJ);
    // si aucun deck présent, renvoi vers la liste de tous les decks
    if (!empty($returnDeck)) {
        $decks = new decks([
            'id' => htmlspecialchars($returnDeck->id),
            'idUser' => htmlspecialchars($returnDeck->idUser),
            'name' => htmlspecialchars($returnDeck->name),
            'type' => htmlspecialchars($returnDeck->type)
        ]);
        $type = $decks->getType();
        $reqDeckList = $list->getListByDeckId($decks->getId());
        $deckList = $reqDeckList->fetchAll(PDO::FETCH_OBJ);

        // si le deck comporte une liste
        if(count($deckList) != 0){
            $_SESSION['allDeckInformations'] = $decks;
            if ($type == 'Multi' || $type == 'Duel') {
                $req = $deck->changeStringByImg($deckList);
                require('views/newListCommander.php');
            }
            else{
                require('views/newList.php');
            }
            echo'<script>seeDiv('.$deckList[0]->cards.');</script>';
            $history = $list->getOldList($decks)->fetchAll(PDO::FETCH_OBJ);
            for ($i=0; $i < count($history); $i++) {
                $date = $history[$i]->date;
                echo'<script>seeHistoric(\''.$date.'\',\''.$history[$i]->id.'\');</script>';
            }
        }
        else{
            $_SESSION['allDeckInformations'] = $decks;
            if ($type == 'Multi' || $type == 'Duel') {
                require('views/newListCommander.php');
            }
            else{
                require('views/newList.php');
            }
        }
    }
    else{
        header('location:index.php?action=viewDecks');
    }
    echo '<script>addActive(decks);</script>';
}

/* -------- Affiche la liste des cartes --------- */
function cardList($deck, $list, $post){
    $infos = $_SESSION['allDeckInformations'];
    switch ($infos->getType()) {
        case 'Multi':
            $type = 'commander';
            break;
        case 'Duel':
            $type = 'duel';
            break;
        default:
            $type = 'error';
            break;
    }

    $card = $list->getListByDeckId($_SESSION['allDeckInformations']->getId());
    $color = explode(',', $card->fetch(PDO::FETCH_OBJ)->colors);

    $req = $deck->returnInfosDeckDuel($post, $type);
    $beforeNumbers = array();
    $afterNumbers = array();
    $beforeLetters = array();
    $afterLetters = array();
    $beforeLetter = array();

    $letters = array("U", "G", "R", "B", "W", "P", "2", "T", "X");

    for ($i=0; $i < 20; $i++) {
        $beforeNumbers[$i]  = '{'.$i.'}';
        $afterNumbers[$i] = "<img src='public/images/mana/" . $i . ".png'' width='20px'/>";
    }
    $a= 0;
    for ($i=0; $i < (count($letters)*8); $i+=8) {
        $beforeLetters[$i]  = ''.$letters[$a].'';
        $beforeLetters[$i+1]  = ''.$letters[$a].'U';
        $beforeLetters[$i+2]  = ''.$letters[$a].'G';
        $beforeLetters[$i+3]  = ''.$letters[$a].'R';
        $beforeLetters[$i+4]  = ''.$letters[$a].'B';
        $beforeLetters[$i+5]  = ''.$letters[$a].'W';
        $beforeLetters[$i+6]  = ''.$letters[$a].'P';
        $beforeLetters[$i+7]  = '2'.$letters[$a].'';
        $beforeLetters[$i+8]  = ''.$letters[$a].'X';

        $beforeLetter[$i]  = '{'.$letters[$a].'}';
        $beforeLetter[$i+1]  = '{'.$letters[$a].'U}';
        $beforeLetter[$i+2]  = '{'.$letters[$a].'G}';
        $beforeLetter[$i+3]  = '{'.$letters[$a].'R}';
        $beforeLetter[$i+4]  = '{'.$letters[$a].'B}';
        $beforeLetter[$i+5]  = '{'.$letters[$a].'W}';
        $beforeLetter[$i+6]  = '{'.$letters[$a].'P}';
        $beforeLetter[$i+7]  = '{2'.$letters[$a].'}';
        $beforeLetter[$i+8]  = '{'.$letters[$a].'X}';

        $afterLetters[$i] = "<img src='public/images/mana/" . $beforeLetters[$i] . ".png'' width='20px'/>";
        $afterLetters[$i+1] = "<img src='public/images/mana/" . $beforeLetters[$i+1]. ".png'' width='20px'/>";
        $afterLetters[$i+2] = "<img src='public/images/mana/" . $beforeLetters[$i+2] . ".png'' width='20px'/>";
        $afterLetters[$i+3] = "<img src='public/images/mana/" . $beforeLetters[$i+3] . ".png'' width='20px'/>";
        $afterLetters[$i+4] = "<img src='public/images/mana/" . $beforeLetters[$i+4] . ".png'' width='20px'/>";
        $afterLetters[$i+5] = "<img src='public/images/mana/" . $beforeLetters[$i+5] . ".png'' width='20px'/>";
        $afterLetters[$i+6] = "<img src='public/images/mana/" . $beforeLetters[$i+6] . ".png'' width='20px'/>";
        $afterLetters[$i+7] = "<img src='public/images/mana/" . $beforeLetters[$i+7] . ".png'' width='20px'/>";
        $afterLetters[$i+8] = "<img src='public/images/mana/" . $beforeLetters[$i+8] . ".png'' width='20px'/>";
        $a++;
    }
    $returnInfos = $req->fetchAll(PDO::FETCH_OBJ);
    if (count($returnInfos) != 0) {
        foreach($returnInfos as $data){
            if($data->toughness != null){
                $data->toughness = '/' . $data->toughness;
            }
            $verifyColor = explode(',', $data->colorIdentity);
            $correctColor = false;
            for ($i=0; $i < count($verifyColor) ; $i++) {
                if (in_array($verifyColor[$i], $color)) {
                    $correctColor = true;
                }
                else{
                    $correctColor = false;
                    break;
                }
            }
            if($correctColor){

                $data->manaCost = str_replace($beforeNumbers, $afterNumbers, $data->manaCost);
                $data->text = str_replace($beforeNumbers, $afterNumbers, $data->text);
                $letters = str_replace($beforeLetter, $afterLetters, $data->manaCost);
                $text = str_replace($beforeLetter, $afterLetters, $data->text);
                echo '<li id="' . $data->name . '" class="cardList">'. $data->name .'</li>';
                echo '
                    <div id="li' . $data->name . '" class="listCard">
                        <div id="nameCard">
                            <div id="titleCard">' .$data->name. '</div>
                            <div id="manaImg">' . $letters . '</div>
                        </div>
                        <div id="cardType">' .$data->type. '</div>
                        <div id="cardText">' .nl2br($text). '</div>
                        <div id="atkToug">' .$data->power.''.$data->toughness.'</div>
                    </div>
                ';
            }
        }
    }
    else{
        echo '<div class="errorNoCard">No cards match</div>';
    }
}

function matchesByYear($pseudo, $matches, $year){
    $matches->matchesInJson($pseudo->id, $year);
}


function listCommander($deck, $commander){
    $req = $deck->returnInfosCommanderCards($commander);
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


function oldList($lists, $post){
    $id = substr($post, 4);
    $req = $lists->getOldListById($id);
    $re = $req->fetch(PDO::FETCH_OBJ);
    echo $re->cards;
}
