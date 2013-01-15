<?php
	@session_start();
	session_unset();
	$_SESSION = array();
	session_destroy();
	
	echo ("<script> window.location.href = 'index.php'</script>");
?>