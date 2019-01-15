<?php
//function redirection éviter les erreurs header
function redirect_to($url){
    header($url);
    exit();
}
error_reporting(E_ALL);
ini_set("display_errors", 1);

//autloader
require '../models/class/autoloader.php';
Autoloader::registerChecks();

session_start();

// chargement des classes
$userManager = new userManager();
$deck = new deckManager();
$cards = new cards();
$lists = new lists();
$db = dataBase::dbConnect();

// les différentes listes en fonction du type de deck
if(isset($_POST['cardList'])){

    $infos = $_SESSION['allDeckInformations'];
    $post = $_POST['cardList'];
    switch($infos->getType()){
        case "Duel":

            $card = $lists->getListByDeckId($_SESSION['allDeckInformations']->getId());
            $color = explode(',', $card->fetch(PDO::FETCH_OBJ)->colors);

            $req = $deck->returnInfosDeckDuel($post);
            $beforeNumbers = array();
            $afterNumbers = array();
            $beforeLetters = array();
            $afterLetters = array();
            $beforeLetter = array();

            $letters = array("U", "G", "R", "B", "W", "P", "2", "T", "X");

            for ($i=0; $i < 20; $i++) {
                $beforeNumbers[$i]  = '{'.$i.'}';
                $afterNumbers[$i] = "<img src='../public/images/mana/" . $i . ".png'' width='20px'/>";
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

                $afterLetters[$i] = "<img src='../public/images/mana/" . $beforeLetters[$i] . ".png'' width='20px'/>";
                $afterLetters[$i+1] = "<img src='../public/images/mana/" . $beforeLetters[$i+1]. ".png'' width='20px'/>";
                $afterLetters[$i+2] = "<img src='../public/images/mana/" . $beforeLetters[$i+2] . ".png'' width='20px'/>";
                $afterLetters[$i+3] = "<img src='../public/images/mana/" . $beforeLetters[$i+3] . ".png'' width='20px'/>";
                $afterLetters[$i+4] = "<img src='../public/images/mana/" . $beforeLetters[$i+4] . ".png'' width='20px'/>";
                $afterLetters[$i+5] = "<img src='../public/images/mana/" . $beforeLetters[$i+5] . ".png'' width='20px'/>";
                $afterLetters[$i+6] = "<img src='../public/images/mana/" . $beforeLetters[$i+6] . ".png'' width='20px'/>";
                $afterLetters[$i+7] = "<img src='../public/images/mana/" . $beforeLetters[$i+7] . ".png'' width='20px'/>";
                $afterLetters[$i+8] = "<img src='../public/images/mana/" . $beforeLetters[$i+8] . ".png'' width='20px'/>";
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
            break;
        case "Vintage":
            $deck->returnInfosDeckVintage($infos, $post);
            break;
        case "Standard":
            $deck->returnInfosDeckStandard($infos, $post);
            break;
        case "Commander":
            $deck->returnInfosDeckCommander($infos, $post);
            break;
        case "MTGO":
            $deck->returnInfosDeckMTGO($infos, $post);
            break;
        case "Legacy":
            $deck->returnInfosDeckLegacy($infos, $post);
            break;
        case "Modern":
            $deck->returnInfosDeckModern($infos, $post);
            break;
        default:
            echo 'Incorrect type !';
    }
}
