<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/serviceType.class.php");
	require ("../includes/class/service.class.php");
	require ("../includes/class/resize/imagen.class.php5");

	$service = new Service();
	$serviceType = new ServiceType();
	$image = new Imagen();

	$titlePage = $messages["general_title_services_add"];
	
	$listServiceType = $serviceType->serviceTypeList("", ' ORDER BY sertype_status, sertype_order', 0, 0, 0, false, 'es');
	$countServiceType = count ($listServiceType);
	
	$data = NULL;

	$serv_code = "";
	$sertype_code = "";
	$serv_name = "";
	$serv_summary = "";
	$serv_description = "";
	$serv_image_element = '<img src="../images/broken-image.png" style="border:0px" width="620" height="465"/>';
	$serv_image = "";
	$serv_status = "";
	$serv_name_e = "";
	$serv_summary_e = "";
	$serv_description_e = "";
	$serv_image_e_element = '<img src="../images/broken-image.png" style="border:0px" width="620" height="465"/>';
	$serv_image_e = "";
	$serv_order = "";
	
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->serv_code = fieldSecure($_POST['serv_code']);
		$data->sertype_code = fieldSecure($_POST['sertype_code']);
		$data->use_code = fieldSecure((int) $_SESSION['use_code']);
		$data->serv_name = fieldSecure($_POST['serv_name']);
		$data->serv_summary = fieldSecure($_POST['serv_summary']);
		$data->serv_description = $_POST['serv_description'];
		$data->serv_image = fieldSecure($_POST['serv_image']);
		$data->serv_status = fieldSecure($_POST['serv_status']);		
		$data->serv_name_e = fieldSecure($_POST['serv_name_e']);
		$data->serv_summary_e = fieldSecure($_POST['serv_summary_e']);
		$data->serv_description_e = $_POST['serv_description_e'];
		$data->serv_image_e = fieldSecure($_POST['serv_image_e']);
		$data->serv_order = ($service->getMaxOrder($data->sertype_code) + 1);
		$data->serv_highlight = 0;
		
		$delImage = false;
		$pathPrev = "";
		$pathPrevSmall = "";
		
		$delImage_e = false;
		$pathPrev_e = "";
		$pathPrev_eSmall = "";
		
		if ((isset ( $_POST['serv_image'] ) && $_POST['serv_image'] != '' ) && ($_POST['serv_image'] != $_POST['serv_image_prev'])) {
			
			$copyImage = copy ("../file_upload/images_bank/".$_POST['serv_image'],'../file_upload/service/620x465/' . $_POST['serv_image']);
						
			if ( $copyImage ) {
				$image->redimensionarImagen(200, 150, '../file_upload/service/620x465/' . $_POST['serv_image'], '../file_upload/service/200x150/' . $_POST['serv_image'], "white");
				if ($_POST['serv_image'] != $_POST['serv_image_e']) {
					unlink ("../file_upload/images_bank/".$_POST['serv_image']);	
				}
				$data->serv_image = fieldSecure($_POST['serv_image']);
				$pathPrev = '../file_upload/service/620x465/' . $_POST['serv_image_prev'];
				$pathPrevSmall = '../file_upload/service/200x150/' . $_POST['serv_image_prev'];
				if (($_POST['serv_image_prev'] != $_POST['serv_image_e']) && file_exists ($pathPrev)) {
					$delImage = true;
				}
			}
		}
		
		if ((isset ( $_POST['serv_image_e'] ) && $_POST['serv_image_e'] != '' ) && ($_POST['serv_image_e'] != $_POST['serv_image_e_prev'])) {			
			$copyImage = copy ("../file_upload/images_bank/".$_POST['serv_image_e'],'../file_upload/service/620x465/'.$_POST['serv_image_e']);
						
			if ( $copyImage ) {
				$image->redimensionarImagen(200, 150, '../file_upload/service/620x465/' . $_POST['serv_image_e'], '../file_upload/service/200x150/' . $_POST['serv_image_e'], "white");
				unlink ("../file_upload/images_bank/".$_POST['serv_image_e']);
				$data->serv_image_e = fieldSecure($_POST['serv_image_e']);
				
				$pathPrev_e = '../file_upload/service/620x465/' . $_POST['serv_image_e_prev'];
				$pathPrev_eSmall = '../file_upload/service/200x150/' . $_POST['serv_image_e_prev'];
				if (($_POST['serv_image_e_prev'] != $_POST['serv_image']) && file_exists ($pathPrev_e)) {
					$delImage_e = true;
				}
			}
		}

		if (empty ($data->serv_code)) {
			if ($service->insertService($data)) {
				$_SESSION["messageValue"] = replaceMessage($messages["service_message_added"], array($data->serv_name)).'<br />';
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["service_message_errorAdding"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		} elseif ($data->serv_code > 0) {
			if ($service->updateService($data)) {
				$_SESSION["messageValue"] = replaceMessage($messages["service_message_updated"], array($data->serv_name));
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["service_message_errorUpdating"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		}
		
		if ($_SESSION["messageShow "] == 3) {
			if ($delImage) {
				unlink ($pathPrev);	
				if (file_exists($pathPrevSmall)) {
					unlink ($pathPrevSmall);
				}
			}
			
			if ($delImage_e && ($pathPrev != $pathPrev_e)) {
				unlink ($pathPrev_e);
				if (file_exists($pathPrev_eSmall)) {
					unlink ($pathPrev_eSmall);
				}
			}
		}
		
		echo "<script> window.location.href='listServices.php?sertype_code=".$data->sertype_code."'</script>";
	} elseif (isset ($_GET["serv_code"]) && (int) $_GET["serv_code"] > 0) {
		$serv_code = (int) $_GET["serv_code"];
		$titlePage = $messages["general_title_services_update"];
		
		$data = $service->getService($serv_code);

		$serv_code = $data->serv_code;
		$sertype_code = $data->sertype_code;
		$serv_name = $data->serv_name;
		$serv_summary = $data->serv_summary;
		$serv_description = $data->serv_description;
		$serv_image = $data->serv_image;
		$serv_status = $data->serv_status;
		$serv_name_e = $data->serv_name_e;
		$serv_summary_e = $data->serv_summary_e;
		$serv_description_e = $data->serv_description_e;
		$serv_image_e = $data->serv_image_e;
		
		if (! empty ($data->serv_image)) {
			$path_image = "../file_upload/service/620x465/".$data->serv_image;
			if (file_exists ($path_image)) {
				$serv_image_element = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_serv_image\')"><img src="images/delete.png" width="16" height="16" alt="'.$messages["general_remove"].'" /></a><br /><a class="fancytoImage" href="'.$path_image.'"><img src="'.$path_image.'" style="border:0px" width="620" height="465"/></a>';
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