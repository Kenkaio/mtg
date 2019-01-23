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
    public function getDeckById($userId, $id){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ? AND id = ?');
        $req->execute(array($userId, $id));
        return $req;
    }

    /**
     * récupère un deck spécifique de l'utilisateur avec son nom et son type
     *
     * @param [string] $name
     * @param [int] $userId
     * @return void
     */
    public function getDeckByNameAndType($name, $type, $userId){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM decks WHERE idUser = ? AND name = ? AND type = ?');
        $req->execute(array($userId, $name, $type));
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
    }

    /**
     * Récupère une liste de 10 cartes maximum en fonction du texte rentré par l'utilisateur (post)
     *
     * @param decks [object] $infos
     * @param [string] $post
     * @return void
     */
    public function returnInfosDeckDuel($post, $type){
        $db = dataBase::dbConnect();

        $req = $db->query("SELECT * FROM cards WHERE name LIKE '%$post%' AND ($type ='Legal' || $type='Restricted') LIMIT 10");

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

    /**
     * Change les lettres par des images
     *
     * @param [array] $deckList
     * @return $commanderSelected, $color (array)
     */
    public function changeStringByImg($deckList){
        $letters = array("U", "G", "R", "B", "W", "P");
        $afterLetters = array();
        for ($i=0; $i < count($letters); $i++) {
            $afterLetters[$i] = "<img src='public/images/mana/" . $letters[$i] . ".png'' width='40px'/>";
        }
        if(count($deckList) != 0){
            $commanderSelected = false;
            $color = str_replace($letters, $afterLetters, $deckList[0]->colors);
            $color = str_replace(',', '', $color);
        }
        else{
            $commanderSelected = true;
        }
        file_put_contents('public/assets/json/list.json', $deckList[0]->cards);
        file_put_contents('public/assets/json/numbersCards.json', $deckList[0]->number);
        return array($commanderSelected, $color);
    }
}
