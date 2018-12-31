<?php
class UserManager{

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

    public function delete(user $id){
        // supprimera un utilisateur avec son id
    }

    public function update(user $infos){
        // updatera un utilisateur
    }

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
				$_SESSION['ouvert']=true;
                $_SESSION['id'] = $result['id'];
                $result = true;
                return $result;
                die;
			}
		}
    }

    public function logout()
	{
		$_SESSION = array();
		session_destroy();
	}
}
