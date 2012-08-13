<?php

class DB{

	private $db;

	function __construct(){
		$dbConf = Config::get('database');
		try{
			self::$db = new PDO("mysql:host={$dbConf['host']};dbname={$dbConf['database']}", $dbConf['username'], $dbConf['password']);
			self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $e){
			file_put_contents(Config::get('logs_folder') . '/pdo-errors.txt', $e->getMessage(), FILE_APPEND | LOCK_EX);
		}
	}


}