<?php

class DB{

	private $connection;
	private static $dbInstance;

	private function __construct(){
		$error = false;
		$dbConf = Config::get('database');
		try{
			$this->connection = new PDO("mysql:host={$dbConf['host']};dbname={$dbConf['database']}", $dbConf['username'], $dbConf['password']);
			$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $e){
			error($e->getMessage());
		}
	}
	
	private function construct(){
		if(!(self::$dbInstance)){
			self::$dbInstance = new DB();
		}
		return self::$dbInstance;
	}
	
	public static function status(){
		$db = self::construct();
		return !!($db->connection);
	}
	
	public static function checkInstall(){
		$db = self::construct();
		$result = $db->connection->query("show tables");
		return empty($result);
	}
	
	public static function install($tables){
		$db = self::construct();
	}

	public static function createTables($tables){
		$db = self::construct();
		$endString = 'ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
		$query = '';
		foreach($tables as $tableName => $cols){
			echo('Creating Table "' . $tableName . '"');
			$query .= 'CREATE TABLE IF NOT EXISTS `' . $tableName . '`(';
			$keys = array();
			foreach($cols as $colName => $col){
				if($colName == 'PRIMARY KEY'){
					$keys['primary'] = $col;
				} else if($colName == 'KEY'){
					$keys['key'][] = $col; 
				} else{
					$query .= '`' . $colName . '` ' . $col['type'] . (isset($col['null']) && $col['null'] ? ' NOT NULL' : '') . ',';
				}
			}
			$query .= 'PRIMARY KEY (`' . $keys['primary'] . '`),';
			foreach($keys['key'] as $key){
				$query .= 'KEY `' . $key[0] .'` (`' . $key[1] . '`)';
			}
			$query .= ")\r\n";
		}
		$db->connection->query($query . $endString);
	}
}