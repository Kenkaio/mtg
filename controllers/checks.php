<?php

require '../models/class/autoloader.php';
Autoloader::registerChecks();

if(isset($_POST['pseudo'])){
    $db = dataBase::dbConnect();

    $pseudo = $_POST['pseudo'];
    if(strlen($pseudo) == 0){
        echo ('empty');
    }
    else{
        // On récupère la liste des membres et on check si le pseudo existe déjà
        $req = $db->query("SELECT pseudo FROM user WHERE pseudo='$pseudo'");

        // On déroule la liste
        $chk_pseudo = $req->fetch(PDO::FETCH_ASSOC);

        // Si le pseuo existe déjà on retourne non
        if($chk_pseudo == '1' || $chk_pseudo > '1'){
            echo ('no');
            $ok = false;
        }
        else{
            echo ('yes');
        }
    }
}

if(isset($_POST['mail'])){
    $db = dataBase::dbConnect();

    $mail = $_POST['mail'];
    // On récupère la liste des membres et on check si le mail existe déjà
    $req = $db->query("SELECT mail FROM user WHERE mail='$mail'");

    // On déroule la liste
    $chk_mail = $req->fetch(PDO::FETCH_ASSOC);

    // Si le mail existe déjà on retourne non
    if($chk_mail == '1' || $chk_mail > '1'){
        echo ('no');
        $ok = false;
    }
    else{
        echo ('yes');
    }
}
