<?php

/* Include the important files */
includePHP('./core/');
includePHP('./conf/');

/* Set up the database connection */
$dbConf = Config::get('database');
include_once('./core/drivers/' . $dbConf['driver'] . '.php');

/* Function to include all .php files in a directory
 * Won't include files named "core.php" for recursion-avoidance
 */
function includePHP($dir){
	if ($handle = opendir($dir)){
		while (false !== ($entry = readdir($handle))){
			if (!(false === strpos($entry, '.php'))
				&& false === strpos($entry, 'core.php')
				&& is_file($dir . '/' . $entry)){
				include_once($dir . '/' . $entry);
			}
		}
		closedir($handle);
	}
}

/* Function to set the flash message for the next page load
 * 
 */
function addFlash($msg, $class = false){
	if(!isset($_SESSION)){
		error('$_SESSION not set for addFlash(). Message: ' . $msg);
	} else{
		if(!isset($_SESSION['flash'])) $_SESSION['flash'] = array();
		$_SESSION['flash'][] = array(
			'message' => $msg,
			'class' => $class
		);
	}
}

/* Function to log an error*/
function error($msg){
	file_put_contents(Config::get('logs_folder') . '/errors.txt', $msg, FILE_APPEND | LOCK_EX);
}

function checkInstall(){
	if(!DB::checkInstall()){
		DB::createTables(array(
			'users' => array(
				'id' => array(
					'type' => 'int(11)',
					'auto_increment' => true
				),
				'username' => array(
					'type' => 'varchar(255)',
				),
				'password' => array(
					'type' => 'varchar(64)',
				),
				'hash' => array(
					'type' => 'varchar(64)',
				),
				'created' => array(
					'type' => 'datetime',
					'default' => 'CURRENT_TIMESTAMP'
				),
				'modified' => array(
					'type' => 'datetime',
				),
				'lastlogin' => array(
					'type' => 'datetime'
				),
				'PRIMARY KEY' => 'id',
				'KEY' => array('username', 'username')
			),
			'locations' => array(
				'id' => array(
					'type' => 'int(11)',
					'auto_increment' => true
				),
				'title' => array(
					'type' => 'varchar(255)'
				),
				'contents' => array(
					'type' => 'text'
				),
				'north_id' => array(
				
				),
				'PRIMARY KEY' => 'id'
			)
		));
	}
}

/*

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `north_id` int(11) NOT NULL,
  `south_id` int(11) NOT NULL,
  `east_id` int(11) NOT NULL,
  `west_id` int(11) NOT NULL,
  `up_id` int(11) NOT NULL,
  `down_id` int(11) NOT NULL,
  `pos_x` int(11) DEFAULT NULL,
  `pos_y` int(11) DEFAULT NULL,
  `pos_z` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/