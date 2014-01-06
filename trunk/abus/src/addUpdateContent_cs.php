<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/content.class.php");	
	
	$content = new Content();
	
	$titlePage = $messages["general_title_contents_add"];
	
	$cont_code = "";
	$cont_name = "";
	$cont_text = "";
	$cont_status = "";
	$cont_name_e = "";
	$cont_text_e = "";
	
//	die(print_r($_POST));
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->cont_code = fieldSecure($_POST['cont_code']);
		
		$data->cont_name = fieldSecure($_POST['cont_name']);
		$data->cont_text = $_POST['cont_text'];
		
		$data->cont_status = fieldSecure($_POST['cont_status']);
		$data->cont_name_e = fieldSecure($_POST['cont_name_e']);
		$data->cont_text_e = $_POST['cont_text_e'];
		
		$data->cont_order = ($content->getMaxOrder() + 1);
		if ($data->cont_code == 0) {
			if ($content->insertContent($data)) {
				$_SESSION["message_value"] = $messages["content_message_addedItem"].'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["content_message_errorAdding"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->cont_code > 0) {
			if ($content->updateContent($data)) {
				$_SESSION["message_value"] = $messages["content_message_updatedItem"].'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["content_message_errorUpdating"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		}
		echo "<script> window.location.href='listContents.php'</script>";
	} elseif (isset ($_GET["cont_code"]) && (int) $_GET["cont_code"] > 0) {
		$cont_code = (int) $_GET["cont_code"];
		$titlePage = $messages["general_title_contents_update"];
		
		$data = $content->getContent($cont_code);

		$cont_code = $data->cont_code;
		$cont_name = $data->cont_name;
		$cont_text = $data->cont_text;
		$cont_status = $data->cont_status;
		$cont_name_e = $data->cont_name_e;
		$cont_text_e = $data->cont_text_e;
		
	}	
?>