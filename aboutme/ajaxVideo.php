<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/video.class.php");
	
	$video = new Video();
		
	if (isset ($_POST["vid_code"]) && (int) $_POST["vid_code"] > 0 && isset ($_POST["vid_order"]) && count ($_POST) == 2){
		$vid_code = (int) $_POST["vid_code"];
		$vid_order = (int) $_POST["vid_order"];
		
		if ($video->updateOrder($vid_code, $vid_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["vid_code"]) && (int) $_POST["vid_code"] > 0) && (isset($_POST["vid_status"]) && (int) $_POST["vid_status"] > 0) && count($_POST) == 2) {
		$vid_code = (int) $_POST["vid_code"];
		$vid_status = (int) $_POST["vid_status"];
		
		if ($video->changeStatus($vid_code, $vid_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>