<?php

class Decks{

    public function getAllDecks($userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ?');
        $req->execute(array($userId));
        return $req;
    }
}
