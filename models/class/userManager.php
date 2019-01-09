<?php
class UserManager{

    /**
     * Ajouter un utilisateur à la bdd
     *
     * @param user $user
     * @return void
     */
    public function add(user $user){
        $db = dataBase::dbConnect();
        $req = $db->prepare('INSERT INTO user (pseudo, mail, pass) VALUES (:pseudo, :mail, :pass)');
        $req->bindValue(':pseudo', ucfirst($user->getPseudo()));
        $req->bindValue(':mail', $user->getMail());
        $req->bindValue(':pass', password_hash($user->getPass(),  PASSWORD_DEFAULT));
        $req->execute();

        $user->hydrate([
            'pseudo' => $user->getPseudo(),
            'mail' => $user->getMail(),
            'pass' => $user->getPass(),
        ]);
    }

    /**
     * Verification pseudo / mail si présent bdd
     *
     * @param user $user
     * @return $result
     */
    public function verifInscription(user $user){
        $db = dataBase::dbConnect();
        $req = $db->prepare('SELECT * FROM user WHERE pseudo= :pseudo');
        $req->execute(array(':pseudo' => $user->getPseudo()));
        $resultP = $req->fetch();
        if(!$resultP){
            $req = $db->prepare('SELECT * FROM user WHERE mail= :mail');
            $req->execute(array(':mail' => $user->getMail()));
            $resultM = $req->fetch();
            if(!$resultM){
                $result = true;
                return $result;
            }
            else{
                $result = false;
                return $result;
            }
        }
        else{
            $result = false;
            return $result;
        }
    }

    /**
     * connecte l'utilisateur
     *
     * @param user $user
     * @return $result
     */
    public function connect(user $user){
        $db = dataBase::dbConnect();
		$req = $db->prepare('SELECT * FROM user WHERE pseudo= :pseudo');
		$req->execute(array(':pseudo' => $user->getPseudo()));
		$result = $req->fetch();
        $Verif_Pass = password_verify($user->getPass(), $result["pass"]);
		if (!$result) {
            return $result;
		}
		else
		{	/* ---- Si connecté, création variable session ----- */
			if ($Verif_Pass) {
                $req = $db->prepare('UPDATE user SET connected=? WHERE pseudo=?');
                $req->execute(array(
                    true,
                    $user->getPseudo()
                ));
				$_SESSION['ouvert']=true;
                $_SESSION['id'] = $result['id'];
                $result = true;
                return $result;
			}
		}
    }

    /**
     * Récupère l'id, pseudo, mail de l'utilisateur
     *
     * @param [type] $pseudoId
     * @return $pseudo
     */
    public function getPseudoById($pseudoId)
    {
        $db = dataBase::dbConnect();
        $req = $db->query("SELECT id, pseudo, mail FROM user WHERE id=" . $pseudoId);
        $pseudo = $req->fetch();
        return $pseudo;
    }

    /**
     * Sélectionne membres connectés
     *
     * @return void
     */
    public function connected()
    {
        $db = dataBase::dbConnect();
        $req = $db->query("SELECT pseudo FROM user WHERE connected = true");
        return $req;
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @return void
     */
    public function logout($userId)
	{
        $db = dataBase::dbConnect();
        $req = $db->prepare('UPDATE user SET connected=? WHERE id=?');
        $req->execute(array(
            0,
            $userId
        ));
		$_SESSION = array();
		session_destroy();
    }
}
