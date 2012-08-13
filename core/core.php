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