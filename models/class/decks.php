<?php

class Decks extends Construct{

    private $_id;
    private $_idUser;
    private $_name;
    private $_type;

    public function __construct(array $donnees){
        $this->hydrate($donnees);
    }

	public function getId(){
		return $this->_id;
	}

	public function getIdUser(){
		return $this->_idUser;
	}

	public function getName(){
		return $this->_name;
	}

	public function getType(){
		return $this->_type;
	}

	public function setId($id){
		$id = (int) $id;
		if($id > 0){
			$this->_id = $id;
		}
	}

	public function setIdUser($idUser){
        $idUser = (int) $idUser;
		if($idUser > 0){
			$this->_idUser = $idUser;
		}
	}

    public function setName($name){
		if(is_string($name)){
			$this->_name = $name;
		}
    }

    public function setType($type){
		if(is_string($type)){
			$this->_type = $type;
		}
	}
}
