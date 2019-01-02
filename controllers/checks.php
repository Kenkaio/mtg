<?php

require '../models/class/autoloader.php';
Autoloader::registerChecks();
$userManager = new userManager();

if(isset($_POST['pseudo'])){

    $pseudo = $_POST['pseudo'];
    if(strlen($pseudo) == 0){
        echo ('empty');
    }
    else{
        $req = $userManager->getPseudoById($pseudo);

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

if(isset($_POST['mail'])){

    $mail = $_POST['mail'];
    $req = $userManager->getPseudoById($pseudo);

    $chk_mail = $req->fetch(PDO::FETCH_ASSOC);

    if($chk_mail == '1' || $chk_mail > '1'){
        echo ('no');
        $ok = false;
    }
    else{
        echo ('yes');
    }
}

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
