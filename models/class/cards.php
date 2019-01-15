<?php

class Cards {

    /**
     * Récupère les infos de la carte en fonction du nom de celle ci
     *
     * @param [string] $infos
     * @return req
     */
    public function getCardByName($infos){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM cards WHERE name = ?');
        $req->execute(array($infos));
        return $req;
    }
}
