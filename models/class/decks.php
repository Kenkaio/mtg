<?php

class Decks{

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
    public function addDeck($idUser, $name, $type){
        $db = dataBase::dbConnect();
        $req = $db->prepare('INSERT INTO decks (idUser, name, type) VALUES (:idUser, :name, :type)');
        $req->execute(array(
            ':idUser' => $idUser,
            'name' => $name,
            'type' => $type
        ));
    }
}
