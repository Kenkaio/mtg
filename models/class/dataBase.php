<?php

class DataBase{

	public static function dbConnect()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=matega;charset=utf8', 'root', '');
			/* $db = new PDO('mysql:host=db767580380.hosting-data.io;dbname=db767580380;charset=utf8', 'dbo767580380', 'aM3lie<33'); */
			return $db;
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}
	}
}

