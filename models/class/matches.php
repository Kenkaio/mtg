<?php

class Matches{

    /**
     * Sélectionne les matches jouées par l'utilisateur
     *
     * @param [type] $userId
     * @return $req
     */
    public function getAllMatches($userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM matches WHERE idUser = ? ORDER BY id DESC LIMIT 5');
        $req->execute(array($userId));
        return $req;
    }

    /**
     * Sélectionne nom adversarie
     *
     * @param [type] $nameOpponent
     * @return $req
     */
    public function getNameOpponent($nameOpponent){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT pseudo FROM user WHERE id = ?');
        $req->execute(array($nameOpponent));
        return $req;
    }
}
