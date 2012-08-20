<?php
	session_start();
	require_once('./core/core.php');
	if(DB::status()){
		checkInstall();
	} else{
		addFlash('Could not connect to Database');
	}
	
	if(isset($_SESSION['flash'])){
		foreach($_SESSION['flash'] as $flash){
			echo('<div class="flash ' . $flash['class'] . '">' . $flash['message'] . '</div>');
		}
		unset($_SESSION['flash']);
	}
		