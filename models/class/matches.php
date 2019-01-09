<?php

class Matches{

    /**
     * Sélectionne les matches jouées par l'utilisateur
     *
     * @param [type] $userId
     * @return $req
     */
    public function getAllMatchesByYear($userId, $year){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM matches WHERE idUser = ? AND year(date) = ? ORDER BY id');
        $req->execute(array($userId, $year));
        return $req;
    }

    /**
     * Sélectionne les matches jouées par l'utilisateur limit 5
     *
     * @param [type] $userId
     * @return $req
     */
    public function getAllMatchesLimit($userId){
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

    public function matchesInJson($userId, $year){
        $matches = self::getAllMatchesByYear($userId, $year);
        $arrayMatches = "";
        fclose(fopen('../public/assets/json/arrayMatches.json', 'w'));
        $i=0;
        while ($matche = $matches->fetch(PDO::FETCH_OBJ))
        {
            $arrayMatches = $matche;
            $js = file_get_contents('../public/assets/json/arrayMatches.json');

            $js = json_decode($js, true);

            $js[] = $arrayMatches;

            $js = json_encode($js);
            file_put_contents('../public/assets/json/arrayMatches.json', $js);
        }
    }
}
