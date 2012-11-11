<?php 
	@session_start();	
	if (!isset ($_SESSION['statusSession']) || !$_SESSION['statusSession'] || ($_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']) || 
				($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) ) {		
		echo "<script> window.location.href = 'logout.php' </script>";
		exit();
	}
?>