<?php
	define('DEBUG', true);

	Config::set('game_name', 'This is the game name');

	Config::set('logs_folder', './logs/');

	Config::set('database', array(
		'host' => 'localhost',
		'username' => 'roguelike',
		'password' => 'DCvafjGzKQcSqJCS',
		'database' => 'roguelike',
		'prefix' => '',
		'driver' => 'mysql'
	));