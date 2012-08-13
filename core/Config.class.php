<?php

class Config{

	private static $configInstance;
	private static $vars;

	private function __construct(){}

	private function construct(){
		if(!(self::$configInstance)){
			self::$configInstance = new Config();
		}
		return self::$configInstance;
	}

	public static function get($key){
		$conf = self::construct();
		return $conf->vars[$key];
	}

	public static function set($key, $value){
		$conf = self::construct();
		$conf->vars[$key] = $value;
	}

	public static function dump(){
		if(DEBUG > 0){
			$conf = self::construct();
			print_r($conf);
		}
	}
}