<?php
	include("includes/secure.php");
	include("../includes/config.php");

	// imágenes banner publicitario
	if (isset($_POST['array_images'])) {
		require ("../includes/class/banner.class.php");
		require ("../includes/class/resize/imagen.class.php5");
		
		$image = new Imagen();
		$banner = new Banner();

		$count_images = count ($_POST["array_images"]);
		$image_path = "../file_upload/images_bank/";
		$imagePathBanner = "../file_upload/banner/520x880/";
		$imagePathBannerSmall = "../file_upload/banner/118x200/";

		$errorImages = false;

		$width = NULL;
		$height = NULL;
		$type = NULL;
		$attr = NULL;

		// Se verifica que existan las carpetas para las images
		// y se les da los permisos necesarios
		if (!is_dir($imagePathBanner)) {
			mkdir($imagePathBanner, 0777);
		}

		if (!is_dir($imagePathBannerSmall)) {
			mkdir($imagePathBannerSmall, 0777);
		}

		chmod($imagePathBanner, 0777);
		chmod($imagePathBannerSmall, 0777);

		for ($i = 0; $i < $count_images; $i++) {
			$aux = explode (",", $_POST["array_images"][$i]);
			$imgb_rename = $aux[0];
			$imgb_code = $aux[1];

			if (!file_exists ($image_path . $imgb_rename) || ! $_POST["array_images_valid"][$i]) {
				if (! $_POST["array_images_valid"][$i] && $imgb_code && $banner->isImageValid($imgb_code)) {//eliminar una image existente
					if ($banner->deleteImage($imgb_code)) {
						if ( file_exists($imagePathBanner . $imgb_rename)) {
							unlink ($imagePathBanner . $imgb_rename);
						}
						
						if ( file_exists($imagePathBannerSmall . $imgb_rename)) {
							unlink ($imagePathBannerSmall . $imgb_rename);
						}
					}
					continue;
				}
			}
			
			if (file_exists ($image_path.$imgb_rename)) {
				list ($width, $height, $type, $attr) = getimagesize ($image_path.$imgb_rename);					
			}

			$data->use_code = fieldSecure((int) $_SESSION['use_code']);
			$data->imgb_rename = $imgb_rename;
			$data->imgb_original_name = "";
			$data->imgb_width = $width;
			$data->imgb_heigh = $height;
			$data->imgb_name = fieldSecure($_POST["imgb_name"][$i]);
			$data->imgb_name_e = fieldSecure($_POST["imgb_name_e"][$i]);
			$data->imgb_description = "";
			$data->imgb_description_e = "";
			
			if ($imgb_code) { // actualizar información de la imagen
				$data->imgb_code = $imgb_code;
				if (!$banner->updateImageInfo($data)) {
					$errorImages = true;						
				}
			} else { // agregar nueva imagen
				if ($imgb_code = $banner->insertImage($data)) {

					$copyImage = copy ($image_path . $imgb_rename, $imagePathBanner . $imgb_rename);
					
					if ( $copyImage ) {
						$image->redimensionarImagen(118, 200, $imagePathBanner . $imgb_rename, $imagePathBannerSmall . $imgb_rename, "white");
						unlink ($image_path . $imgb_rename);
					} else {
						echo $image_path . $imgb_rename . "<br>";	
						echo $imagePathBanner . $imgb_rename . "<br>";	die;
					}
				} else {
					$errorImages = true;
				}
			}
		}

		if ($errorImages) {
			$_SESSION["messageValue"] = $messages["gallery_message_successWarningImages"] . '<br />';
			$_SESSION["messageShow "] = 2;
		} else {
			// se cambia el tipo de publicidad
			Application :: updateInformationApp('app_advertising_type', '1'/* banner */);
		}
		echo "<script> window.location.href='home.php'</script>";
	}

	$dataApp = Application :: getInformationApp();

	$maxlength_app_information_office = 350;
	$maxlength_app_information_office_e = 350;
	
	$maxlength_app_keywords = 160;
	$maxlength_app_keywords_e = 160;
	
	$appFullMenu = Application :: getAppMenu();
	$countFullMenu = count ($appFullMenu);
	
	$amountBannerImages = 0;

	$app_background = '<input type="hidden" name="app_background" id="app_background" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	$app_background_e = '<input type="hidden" name="app_background_e" id="app_background_e" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	
	$app_information_office   = NULL;
	$app_information_office_e = NULL;
	$app_background_type      = NULL;
	$app_background_color 	  = NULL;
	$app_code 				  = NULL;
	$app_slogan 			  = NULL;
	$app_slogan_e 			  = NULL;
	$app_information_office_e = NULL;
	$app_keywords 			  = NULL;
	$app_keywords_e 		  = NULL;
	
	$app_advertising_type = 1; // banner
	$checkedSocial = '';
	$checkedBanner = '';
	$app_facebook = '';


	if (! empty ($dataApp->app_background)) {
		$path_image = "../file_upload/background/" . $dataApp->app_background;
		$path_image_thumb = "../file_upload/background/thumb-" . $dataApp->app_background;
		if (file_exists ($path_image) && file_exists ($path_image_thumb)) {
			$app_background = '<li>'
							. '<img src="' . $path_image_thumb . '" style="border:0px; width=500; height=300;"/>'
							. '<input type="hidden" name="app_background" id="app_background" value="' . $dataApp->app_background . '"/>'
							. '</li>';
		}


	}
	
	if (! empty ($dataApp->app_background_e)) {
		$path_image = "../file_upload/background/" . $dataApp->app_background_e;
		$path_image_thumb = "../file_upload/background/thumb-" . $dataApp->app_background_e;
		if (file_exists ($path_image) && file_exists ($path_image_thumb)) {
			$app_background_e = '<li style="display: block;">'
							  . '<img src="' . $path_image_thumb . '" style="border:0px; width=500; height=300;"/>'
							  . '<input type="hidden" name="app_background_e" id="app_background_e" value="' . $dataApp->app_background_e . '"/>'
							  . '</li>';
		}
	}
	$checked1 = '';
	$checked2 = '';
	$checked3 = '';
	if (isset ($dataApp)) {
		if ($dataApp->app_background_type == 1) {
			$checked1 = 'checked="checked"';
			$checked2 = '';
			$checked3 = '';
		} elseif ($dataApp->app_background_type == 2) {
			$checked1 = '';
			$checked2 = 'checked="checked"';
			$checked3 = '';
		} elseif ($dataApp->app_background_type == 3) {
			$checked1 = '';
			$checked2 = '';
			$checked3 = 'checked="checked"';
		}

		// tipo de publicidad

		if ($dataApp->app_advertising_type == 1) {
			$checkedBanner = 'checked="checked"';
			$checkedSocial = '';
		} elseif ($dataApp->app_advertising_type == 2) {
			$checkedBanner = '';
			$checkedSocial = 'checked="checked"';
		}

		$app_information_office = $dataApp->app_information_office;
		$app_background_type = $dataApp->app_background_type;
		$app_background_color = $dataApp->app_background_color;
		$app_code = $dataApp->app_code;		
		$app_slogan = $dataApp->app_slogan;
		$app_slogan_e = $dataApp->app_slogan_e;
		$app_information_office_e = $dataApp->app_information_office_e;
		$app_keywords = $dataApp->app_keywords;
		$app_keywords_e = $dataApp->app_keywords_e;
		$app_advertising_type = $dataApp->app_advertising_type;
		$app_facebook = $dataApp->app_facebook;

	}


?>