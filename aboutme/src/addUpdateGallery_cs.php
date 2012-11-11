<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/gallery.class.php");
	require ("../includes/class/resize/imagen.class.php5");
	
	$gallery = new Gallery();
	$image = new Imagen();
	
	$titlePage = $messages["general_title_galleries_add"];
		
	$gall_code = "";
	$img_code = 0;
	$gall_name = "";
	$gall_description = "";
	$gall_name_e = "";
	$gall_description_e = "";
	$gall_status = 0;	
		
	$gall_image_dafault = '<img src="../images/broken-image.png" style="border:0px" width="200" height="120"/>';	
	$gall_order = "";
	
	$amountImages = 0;
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		
		$data->gall_code = fieldSecure($_POST['gall_code']);
		$data->img_code = fieldSecure($_POST['img_code']);
		$data->use_code = fieldSecure((int) $_SESSION['use_code']);
		$data->gall_name = fieldSecure($_POST['gall_name']);
		$data->gall_description = fieldSecure($_POST['gall_description']);
		$data->gall_name_e = fieldSecure($_POST['gall_name_e']);
		$data->gall_description_e = fieldSecure($_POST['gall_description_e']);
		$data->gall_status = fieldSecure($_POST['gall_status']);		
		
		$action = "";
		if (empty ($data->gall_code)) {
			$action = "add";
			$data->gall_order = ((int) $gallery->getMaxOrder() + 1);
			
			if ($data->gall_code = $gallery->insertGallery($data)) {				
				$_SESSION["message_value"] = replaceMessage($messages["gallery_message_added"], array($data->gall_name)).'<br />';
				$_SESSION["message_show"] = 3;				
			} else {
				$_SESSION["message_value"] = $messages["gallery_message_errorAdding"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->gall_code > 0) {
			$action = "update";
			if ($gallery->updateGallery($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["gallery_message_updated"], array($data->gall_name));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["gallery_message_errorUpdating"].'<br />';
				$_SESSION["message_show"] = 1;
			}
		}
		
		if (isset ($_SESSION["message_show"]) && ($_SESSION["message_show"] == 3)) {
			$count_images = count ($_POST["array_images"]);
			$image_path = "../file_upload/images_bank/";
			$image_path_gallery = "../file_upload/gallery/";
			$errorImages = false;
			$updatedFront = false;
			
			for ($i = 0; $i < $count_images; $i++) {
				$aux = explode (",", $_POST["array_images"][$i]);
				$img_rename = $aux[0];
				$img_code = $aux[1];				
				
				if (!file_exists ($image_path.$img_rename) || ! $_POST["array_images_valid"][$i]) {					
					if (! $_POST["array_images_valid"][$i] && $img_code && $gallery->isImageValid($data->gall_code, $img_code)) {//eliminar una image existente
						if ($gallery->deleteImageGallery($img_code)) {
							if ( file_exists($image_path_gallery.'870x522/'.$img_rename)) {
								unlink ($image_path_gallery.'870x522/'.$img_rename);
							}
							
							if ( file_exists($image_path_gallery.'200x120/'.$img_rename)) {
								unlink ($image_path_gallery.'200x120/'.$img_rename);
							}
						}
					}
					
					continue;
				}
				
				list ($width, $height, $type, $attr) = getimagesize ($image_path.$img_rename);
				
				$data->img_rename = $img_rename;
				$data->img_original_name = "";
				$data->img_width = $width;
				$data->img_high = $height;
				$data->img_name	= "";
				$data->img_name_e = "";
				$data->img_description = "";
				$data->img_description_e = "";
				
				if (!$img_code) {					
					if ($img_code = $gallery->insertImage($data)) {						
						if (!$updatedFront) {
							$data->img_code = $img_code;
							if ($gallery->updateGalleryFront($data)) {
								$updatedFront = true;
							}
						}
						
						$copyImage = copy ("../file_upload/images_bank/".$img_rename, '../file_upload/gallery/870x522/'.$img_rename);
						
						if ( $copyImage ) {
							$image->redimensionarImagen(200, 120, '../file_upload/gallery/870x522/'.$img_rename, '../file_upload/gallery/200x120/'.$img_rename, "white");
							unlink ("../file_upload/images_bank/".$img_rename);							
						}
					} else {
						$errorImages = true;
					}
				}
			}
			
			if ($errorImages) {
				$_SESSION["message_value"] = $messages["gallery_message_successWarningImages"].'<br />';
				$_SESSION["message_show"] = 2;
			}
		}
		
		echo "<script> window.location.href='listGalleries.php'</script>";
	} elseif (isset ($_GET["gall_code"]) && (int) $_GET["gall_code"] > 0) {
		$gall_code = (int) $_GET["gall_code"];
		$titlePage = $messages["general_title_galleries_update"];
		$amountImages = $countImages = $gallery->countGalleryImages($gall_code);	
		
		$data = $gallery->getGallery($gall_code);

		$img_code = $data->img_code;
		$gall_name = $data->gall_name;
		$gall_description = $data->gall_description;
		$gall_name_e = $data->gall_name_e;
		$gall_description_e = $data->gall_description_e;
		$gall_status = $data->gall_status;
		
	}
	
?>