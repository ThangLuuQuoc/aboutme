<?php
	@session_start();
	if (isset ($_GET['lang']) && ($_GET['lang'] == 'es' || $_GET['lang'] == 'en') && count($_GET)==1 && count($_POST)==0) {
		$_SESSION['lang'] = $_GET['lang'];	
	}
		
	$actualScript = $_SERVER['HTTP_REFERER'];
	if ($actualScript == '') {
		$actualScript = 'index.php';
	}
	
	header("location: ".$actualScript);
?>