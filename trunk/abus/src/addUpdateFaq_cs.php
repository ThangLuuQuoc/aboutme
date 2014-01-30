<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/faq.class.php");	
	
	$faq = new Faq();
	
	$titlePage = $messages["general_title_faqs_add"];
	
	$faq_code = "";
	$faq_query = "";
	$faq_answer = "";
	$faq_query_e = "";
	$faq_answer_e = "";
	$faq_status = "";
	
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->faq_code = fieldSecure($_POST['faq_code']);
		
		$data->faq_query = fieldSecure($_POST['faq_query']);
		$data->faq_answer = fieldSecure($_POST['faq_answer'], true, true, false);
		
		$data->faq_query_e = fieldSecure($_POST['faq_query_e']);
		$data->faq_answer_e = fieldSecure($_POST['faq_answer_e'], true, true, false);
		
		$data->faq_status = fieldSecure($_POST['faq_status']);
		
		$data->faq_order = ($faq->getMaxOrder() + 1);
		if ($data->faq_code == 0) {
			if ($faq->insertFaq($data)) {
				$_SESSION["messageValue"] = $messages["faq_message_addedItem"].'<br />';
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["faq_message_errorAdding"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		} elseif ($data->faq_code > 0) {
			if ($faq->updateFaq($data)) {
				$_SESSION["messageValue"] = $messages["faq_message_updatedItem"].'<br />';
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["faq_message_errorUpdating"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		}
		echo "<script> window.location.href='listFaq.php'</script>";
	} elseif (isset ($_GET["faq_code"]) && (int) $_GET["faq_code"] > 0) {
		$faq_code = (int) $_GET["faq_code"];
		$titlePage = $messages["general_title_faqs_update"];
		
		$data = $faq->getFaq($faq_code);

		$faq_code = $data->faq_code;
		$faq_query = $data->faq_query;
		$faq_answer = $data->faq_answer;
		$faq_status = $data->faq_status;
		$faq_query_e = $data->faq_query_e;
		$faq_answer_e = $data->faq_answer_e;
		
	}	
?>