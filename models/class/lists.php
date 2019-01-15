<?php

class Lists {

    /**
     * Sélectionne la liste d'un deck
     *
     * @param [string] $deckId
     * @return req
     */
    public function getListByDeckId($deckId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM lists WHERE idDeck = ?');
        $req->execute(array($deckId));
        return $req;
    }

    /**
     * Insère un nouveau commandeur au deck de l'utilisateur
     *
     * @param decks $decks
     * @param [string] $commanderInfos
     * @return void
     */
    public function addCommanderToList(decks $decks, $commanderInfos){
        $db = dataBase::dbConnect();
        $req = $db->prepare('INSERT INTO lists (idDeck, commander, colors) VALUES (:idDeck, :commander, :colors)');
        $req->bindValue(':idDeck', $decks->getId());
        $req->bindValue('commander', $commanderInfos->name);
        $req->bindValue('colors', $commanderInfos->colors);
        $req->execute();
    }

    /**
     * Insère les cartes de la liste en tableau
     *
     * @param decks $decks
     * @param [serialize(array)] $data
     * @return void
     */
    public function addCardsToList(decks $decks, $data){
        $db = dataBase::dbConnect();
        $req = $db->prepare('UPDATE lists SET cards=? WHERE idDeck=?');
        $req->execute(array(
            $data,
            $decks->getId()
        ));
    }

    public function getCardsLists(decks $decks){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT cards FROM lists WHERE idDeck = ?');
        $req->execute(array(
            $decks->getId()
        ));
        return $req;
    }

    public function addToOldList(decks $decks, $data){
        $db = dataBase::dbConnect();
        $req = $db->prepare('INSERT INTO oldlist (idDeck, cards) VALUES (:idDeck, :cards)');
        $req->bindValue(':idDeck', $decks->getId());
        $req->bindValue(':cards', $data);
        $req->execute();
    }

    public function getOldList(decks $decks){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM oldlist WHERE idDeck = ? ORDER BY id DESC');
        $req->execute(array(
            $decks->getId()
        ));
        return $req;
    }
}
