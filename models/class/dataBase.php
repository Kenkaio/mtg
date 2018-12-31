<?php

class DataBase{

	public static function dbConnect()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=matega;charset=utf8', 'root', '');
			/* $db = new PDO('mysql:host=db761958864.hosting-data.io;dbname=db761958864;charset=utf8', 'dbo761958864', 'Polo<555'); */
			return $db;
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}
	}
}

