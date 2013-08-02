<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/slider.class.php");
	
	$slider = new Slider();
	
	$titlePage = $messages["general_title_newItemSlider"];
	
	$slid_code = "";
	$slid_title = "";
	$slid_content = "";
	$slid_image_name = "";
	$slid_image_rename = "";
	$slid_url = "";
	$slid_status = "";
	$slid_last_modified = "";
	$slid_date_create = "";
	$slid_title_e = "";
	$slid_content_e = "";
	$slid_image_name_e = "";
	$slid_image_rename_e = "";
	$slid_image = '<img src="../images/broken-image.png" style="border:0px" width="750" height="320"/>';
	$slid_image_e = '<img src="../images/broken-image.png" style="border:0px" width="750" height="320"/>';
	
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->slid_code = fieldSecure($_POST['slid_code']);
		$data->use_code = (int) $_SESSION['use_code'];
		$data->slid_title = fieldSecure($_POST['slid_title']);
		$data->slid_content = fieldSecure($_POST['slid_content']);
		$data->slid_image_name = fieldSecure($_POST['slid_image_name']);
		$data->slid_image_rename = fieldSecure($_POST['slid_image_rename']);
		$data->slid_url = fieldSecure($_POST['slid_url']);
		$data->slid_status = (int) $_POST['slid_status'];
		$data->slid_title_e = fieldSecure($_POST['slid_title_e']);
		$data->slid_content_e = fieldSecure($_POST['slid_content_e']);
		$data->slid_image_name_e = fieldSecure($_POST['slid_image_name_e']);
		$data->slid_image_rename_e = fieldSecure($_POST['slid_image_rename_e']);
		$data->slid_order = ($slider->getMaxOrder() + 1);
		
		$delImage = false;
		$pathPrev = "";
		
		$delImage_e = false;
		$pathPrev_e = "";
		
		if ((isset ($_POST['slid_image_rename']) && $_POST['slid_image_rename'] != '') && ($_POST['slid_image_rename'] != $_POST['slid_image_rename_prev'])) {
			$copyImage = copy ("../file_upload/images_bank/".$_POST['slid_image_rename'], '../file_upload/slider/750x320/'.$_POST['slid_image_rename']);			
			
			if ( $copyImage ) {
				if ($_POST['slid_image_rename'] != $_POST['slid_image_rename_e']) {
					unlink ("../file_upload/images_bank/".$_POST['slid_image_rename']);	
				}
				$data->slid_image_rename = fieldSecure($_POST['slid_image_rename']);
				
				$pathPrev = '../file_upload/slider/750x320/'.$_POST['slid_image_rename_prev'];
				if (($_POST['slid_image_rename_prev'] != $_POST['slid_image_rename_e']) && file_exists ($pathPrev)) {
					$delImage = true;
				}
			}			
		}
		
		if ((isset ( $_POST['slid_image_rename_e'] ) && $_POST['slid_image_rename_e'] != '' ) && ($_POST['slid_image_rename_e'] != $_POST['slid_image_rename_e_prev'])) {			
			$copyImage = copy ("../file_upload/images_bank/".$_POST['slid_image_rename_e'], '../file_upload/slider/750x320/'.$_POST['slid_image_rename_e']);
						
			if ( $copyImage ){
				unlink ("../file_upload/images_bank/".$_POST['slid_image_rename_e']);
				$data->slid_image_rename_e = fieldSecure($_POST['slid_image_rename_e']);
				
				$pathPrev_e = '../file_upload/slider/750x320/'.$_POST['slid_image_rename_e_prev'];
				if (($_POST['slid_image_rename_e_prev'] != $_POST['slid_image_rename']) && file_exists ($pathPrev_e)) {
					$delImage_e = true;
				}
			}
		}
		
		if ($data->slid_code == 0) {
			if ($slider->insertItemSlider($data)) {
				$_SESSION["message_value"] = $messages["slider_message_addedItem"].'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["slider_message_errorAdding"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->slid_code > 0) {
			if ($slider->updateItemSlider($data)) {
				$_SESSION["message_value"] = $messages["slider_message_updatedItem"].'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["slider_message_errorUpdating"].'<br />';
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
		
		echo "<script> window.location.href='listItemsSlider.php'</script>";
	} elseif (isset ($_GET["slid_code"]) && (int) $_GET["slid_code"] > 0) {
		$slid_code = (int) $_GET["slid_code"];
		$titlePage = $messages["general_title_updateItemSlider"];
		
		$data = $slider->getItemSlider($slid_code);
		
		$slid_title = $data->slid_title;
		$slid_content = $data->slid_content;
		$slid_image_name = $data->slid_image_name;
		$slid_image_rename = $data->slid_image_rename;
		$slid_url = $data->slid_url;
		$slid_status = $data->slid_status;
		$slid_last_modified = $data->slid_last_modified;
		$slid_date_create = $data->slid_date_create;
		$slid_title_e = $data->slid_title_e;
		$slid_content_e = $data->slid_content_e;
		$slid_image_name_e = $data->slid_image_name_e;
		$slid_image_rename_e = $data->slid_image_rename_e;
		
		
		if (! empty ($data->slid_image_rename)) {
			$path_image = "../file_upload/slider/750x320/".$data->slid_image_rename;
			if (file_exists ($path_image)) {
				$slid_image = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_slid_image_rename\')"><img src="images/delete.png" width="16" height="16" alt="'.$messages["general_remove"].'" /></a><br /><a class="fancytoImage" href="'.$path_image.'"><img src="'.$path_image.'" style="border:0px" width="750" height="320"/></a>';
			}
		}
		
		if (! empty ($data->slid_image_rename_e)) {
			$path_image = "../file_upload/slider/750x320/".$data->slid_image_rename_e;
			if (file_exists ($path_image)) {
				$slid_image_e = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_slid_image_rename_e\')"><img src="images/delete.png" width="16" height="16" alt="'.$messages["general_remove"].'" /></a><br /><a class="fancytoImage" href="'.$path_image.'"><img src="'.$path_image.'" style="border:0px" width="750" height="320"/></a>';
			}
		}
	}
	
	$ordersSlider = $slider->getOrdersSlider();
	$countOrderSlider = count ($ordersSlider);
?>