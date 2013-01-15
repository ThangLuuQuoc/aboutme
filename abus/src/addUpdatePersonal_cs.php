<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/charge.class.php");
	require ("../includes/class/personal.class.php");
	
	$charge   = new Charge();
	$personal = new Personal();
	
	$titlePage = $messages["general_title_personal_add"];
	
	$listCharges = $charge->chargeList("", ' ORDER BY chg_status, pers_order', 0, 0, 0, false, 'es');
	$countCharges = count ($listCharges);
	
	$data = array ();

	$pers_code = "";
	$chg_code = "";
	$pers_name = "";
	$pers_lastname = "";
	$pers_profesional_objetive = "";
	$pers_image_element = '<img src="../images/broken-image.png" style="border:0px" width="620" height="465"/>';
	$pers_photo_rename = "";
	$pers_photo_original = "";
	$pers_status = "";
	$pers_order = "";
	
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->pers_code = fieldSecure($_POST['pers_code']);
		$data->chg_code = fieldSecure($_POST['chg_code']);
		$data->use_code = fieldSecure((int) $_SESSION['use_code']);
		$data->pers_name = fieldSecure($_POST['pers_name']);
		$data->pers_lastname = fieldSecure($_POST['pers_lastname']);
		$data->pers_profesional_objetive = fieldSecure($_POST['pers_profesional_objetive'], true, true, false);
		$data->pers_photo_rename = fieldSecure($_POST['pers_photo_rename']);
		$data->pers_photo_original = '';
		$data->pers_status = fieldSecure($_POST['pers_status']);		
		$data->pers_order = ($service->getMaxOrder($data->chg_code) + 1);
		
		$delImage = false;
		$pathPrev = "";
		
		$delImage_e = false;
		$pathPrev_e = "";
		
		if ((isset ( $_POST['pers_photo_rename'] ) && $_POST['pers_photo_rename'] != '' ) && ($_POST['pers_photo_rename'] != $_POST['pers_photo_rename_prev'])) {
			
			$copyImage = copy ("../file_upload/images_bank/".$_POST['pers_photo_rename'],'../file_upload/service/620x465/'.$_POST['pers_photo_rename']);
						
			if ( $copyImage ){
				if ($_POST['pers_photo_rename'] != $_POST['serv_image_e']) {
					unlink ("../file_upload/images_bank/".$_POST['pers_photo_rename']);	
				}
				$data->pers_photo_rename = fieldSecure($_POST['pers_photo_rename']);
				$pathPrev = '../file_upload/service/620x465/'.$_POST['pers_photo_rename_prev'];
				if (($_POST['pers_photo_rename_prev'] != $_POST['serv_image_e']) && file_exists ($pathPrev)) {
					$delImage = true;
				}
			}
		}
		
		if ((isset ( $_POST['serv_image_e'] ) && $_POST['serv_image_e'] != '' ) && ($_POST['serv_image_e'] != $_POST['serv_image_e_prev'])) {			
			$copyImage = copy ("../file_upload/images_bank/".$_POST['serv_image_e'],'../file_upload/service/620x465/'.$_POST['serv_image_e']);
						
			if ( $copyImage ) {
				unlink ("../file_upload/images_bank/".$_POST['serv_image_e']);
				$data->serv_image_e = fieldSecure($_POST['serv_image_e']);
				
				$pathPrev_e = '../file_upload/service/620x465/'.$_POST['serv_image_e_prev'];
				if (($_POST['serv_image_e_prev'] != $_POST['pers_photo_rename']) && file_exists ($pathPrev_e)) {
					$delImage_e = true;
				}
			}
		}
		
		if (empty ($data->pers_code)) {
			if ($service->insertService($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["service_message_added"], array($data->pers_name)).'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["service_message_errorAdding"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->pers_code > 0) {
			if ($service->updateService($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["service_message_updated"], array($data->pers_name));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["service_message_errorUpdating"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		}
		
		if ($_SESSION["message_show"] == 3) {
			if ($delImage) {
				unlink ($pathPrev);	
			}
			
			if ($delImage_e && ($pathPrev != $pathPrev_e)) {
				unlink ($pathPrev_e);
			}
		}
		
		echo "<script> window.location.href='listServices.php?chg_code=".$data->chg_code."'</script>";
	} elseif (isset ($_GET["pers_code"]) && (int) $_GET["pers_code"] > 0) {
		$pers_code = (int) $_GET["pers_code"];
		$titlePage = $messages["general_title_services_update"];
		
		$data = $service->getService($pers_code);

		$pers_code = $data->pers_code;
		$chg_code = $data->chg_code;
		$pers_name = $data->pers_name;
		$pers_lastname = $data->pers_lastname;
		$pers_profesional_objetive = $data->pers_profesional_objetive;
		$pers_photo_rename = $data->pers_photo_rename;
		$pers_status = $data->pers_status;
		$pers_name_e = $data->pers_name_e;
		$pers_lastname_e = $data->pers_lastname_e;
		$serv_description_e = $data->serv_description_e;
		$serv_image_e = $data->serv_image_e;
		
		if (! empty ($data->pers_photo_rename)) {
			$path_image = "../file_upload/service/620x465/".$data->pers_photo_rename;
			if (file_exists ($path_image)) {
				$pers_image_element = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_serv_image\')"><img src="images/delete.png" width="16" height="16" alt="'.$messages["general_remove"].'" /></a><br /><a class="fancytoImage" href="'.$path_image.'"><img src="'.$path_image.'" style="border:0px" width="620" height="465"/></a>';
			}
		}
		
		if (! empty ($data->serv_image_e)) {
			$path_image = "../file_upload/service/620x465/".$data->serv_image_e;
			if (file_exists ($path_image)) {
				$serv_image_e_element = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_serv_image_e\')"><img src="images/delete.png" width="16" height="16" alt="'.$messages["general_remove"].'" /></a><br /><a class="fancytoImage" href="'.$path_image.'"><img src="'.$path_image.'" style="border:0px" width="620" height="465"/></a>';
			}
		}
	}
	
?>