<?php

class DeckManager{

    /**
     * récupère la liste des decks de l'utilisateur, limit 5
     *
     * @param [int] $userId
     * @return $req
     */
    public function getAllDecksLimit($userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ? LIMIT 5');
        $req->execute(array($userId));
        return $req;
    }

    /**
     * récupère la liste des decks de l'utilisateur
     *
     * @param [int] $userId
     * @return $req
     */
    public function getAllDecks($userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ?');
        $req->execute(array($userId));
        return $req;
    }

    /**
     * récupère un deck spécifique de l'utilisateur
     *
     * @param [string] $name
     * @param [int] $userId
     * @return void
     */
    public function getDeckByName($name, $userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ? AND name = ?');
        $req->execute(array($userId, $name));
        return $req;
    }

    /**
     * Ajopute un nouveau deck à l'utilisateur
     *
     * @param [int] $idUser
     * @param [string] $name
     * @param [string] $type
     * @return void
     */
    public function addDeck(decks $decks){
        $db = dataBase::dbConnect();
        $req = $db->prepare('INSERT INTO decks (idUser, name, type) VALUES (:idUser, :name, :type)');
        $req->bindValue(':idUser', $decks->getIdUser());
        $req->bindValue('name', $decks->getName());
        $req->bindValue('type', $decks->getType());
        $req->execute();

        $decks->hydrate([
            'idUser' => $decks->getIdUser(),
            'name' => $decks->getName(),
            'type' => $decks->getType(),
        ]);
    }

    /**
     * Récupère une liste de 10 cartes maximum en fonction du texte rentré par l'utilisateur (post)
     *
     * @param decks [object] $infos
     * @param [string] $post
     * @return void
     */
    public function returnInfosDeckDuel($post){
        $db = dataBase::dbConnect();

        $req = $db->query("SELECT * FROM cards WHERE name LIKE '%$post%' AND (duel ='Legal' || duel='Restricted') LIMIT 10");

        return $req;
    }

    /**
     * Récupère une liste de 10 cartes legendaires maximum en fonction du texte rentré par l'utilisateur (post)
     *
     * @param decks [object] $infos
     * @param [string] $post
     * @return void
     */
    public function returnInfosCommanderCards($post){
        $db = dataBase::dbConnect();

        $req = $db->query(
        "SELECT * FROM cards
        WHERE name LIKE '%$post%' AND (type LIKE '%Legendary Creature%' || type LIKE '%Legendary Enchantment Creature%') AND duel = 'legal'
        LIMIT 10");

        return $req;
    }
}
