<?php

class User {

	private $_id;
	private $_pseudo;
	private $_mail;
	private $_pass;

	public function __construct(array $donnees){
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
	}

	public function getId(){
		return $this->_id;
	}

	public function getPseudo(){
		return $this->_pseudo;
	}

	public function getMail(){
		return $this->_mail;
	}

	public function getPass(){
		return $this->_pass;
	}

	public function setId($id){
		$id = (int) $id;
		if($id > 0){
			$this->_id = $id;
		}
	}

	public function setPseudo($pseudo){
		if(is_string($pseudo)){
			$this->_pseudo = $pseudo;
		}
	}

	public function setMail($mail){
		if(is_string($mail)){
			if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $mail)) {
				$this->_mail = $mail;
			}
		}
	}

	public function setPass($pass){
		if(is_string($pass)){
			$this->_pass = $pass;
		}
	}
}





