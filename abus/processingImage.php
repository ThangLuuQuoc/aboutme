<?php
	
	require ("includes/secure.php");
	include_once ("../includes/config.php");
	
	if (!empty ($_GET['action'])) {
		$result = 0;		
		switch ($_GET['action']) {
			case 'delete':
				if (!empty($_GET['id'])) {
					$path = "../file_upload/images_bank/".$_GET['id'];
					if (file_exists ($path)) {
						unlink ($path);						
					}
					
					$path = "../file_upload/images_bank/thumb-".$_GET['id'];
					if (file_exists ($path)) {
						unlink ($path);						
					}
				}
			break;
			
			case 'getImages':
				if (!empty($_GET['id'])) {
					require ("../includes/class/gallery.class.php");					
					
					$gallery = new Gallery();
					
					$path = "../file_upload/gallery/200x120/";
					$images = $gallery->getGalleryImages((int) $_GET['id']);
					$countImages = $gallery->countGalleryImages((int) $_GET['id']);
					
					for ($i = 0; $i < $countImages; $i++) {
						$pathImage = "../file_upload/gallery/200x120/" . $images[$i]->img_rename;
						if (!file_exists ($pathImage)) {
							continue;
						}
						
						echo  '
						<li style="display: block;">
							<input type="hidden" name="img_name[]" id="img_name_' . $images[$i]->img_code . '" value="' . $images[$i]->img_name . ' " />
							<input type="hidden" name="img_name_e[]" id="img_name_e_' . $images[$i]->img_code . '" value="' . $images[$i]->img_name_e . ' " />
							<input type="hidden" id="img_path_' . $images[$i]->img_code . '" value="' . $pathImage . '" />
							<a href="javascript:;" class="to_delete" id="'.$images[$i]->img_code.'" title="' . $messages['general_remove'] . '"><img src="../images/delete.png"></a>
							<a href="javascript:;" onclick="updateIMageInformation(' . $images[$i]->img_code.')" id="info_img_' . $images[$i]->img_code.'" title="' . $messages['general_information'] . '" class="info"><img src="../images/info.png" width="16" height="16"></a>
							<img id="img_elem_' . $images[$i]->img_code . '" src="'.$pathImage.'" title="[' . $messages['general_es'] . ': '. $images[$i]->img_name .'] [' . $messages['general_en'] . ': '. $images[$i]->img_name_e .']">
							<input type="hidden" name="array_images[]" value="'.$images[$i]->img_rename.', '.$images[$i]->img_code.'" />
							<input type="hidden" name="array_images_valid[]" id="hidden_'.$images[$i]->img_code.'" value="1" />
						</li>';
					}
				}
			break;
		}
	}
	
	//cargar image		
	if (isset ($_FILES['image'])) {
		$allow_extensions = array(".jpg", ".gif", ".png");
		$filename = basename($_FILES['image']['name']);
		$file_ext = strtolower ( substr ( $filename, strrpos ( $filename, '.') ) );
		
		if ( ! in_array ($file_ext, $allow_extensions) ){
			echo -1;
		} else {			
			require ("../includes/class/fileManagement.class.php");
			require ("../includes/class/resize/imagen.class.php5");
			
			$file = new fileManagement();
			$image = new Imagen();
					
			$path_to = "../file_upload/images_bank/";
			$imageRename = $file->subirArchivo($_FILES['image']['tmp_name'], $_FILES['image']['name'], $path_to);

			if ($imageRename != ".") {
				$image->redimensionarImagen(500, 300, $path_to.$imageRename, $path_to."thumb-".$imageRename, "white");
				$inputHidden = '';
				
				if ($_POST[0] == 1) {//es
					$inputHidden = '<input type="hidden" name="app_background" id="app_background" value="'.$imageRename.'"/>';
				} elseif ($_POST[0] == 2) {//en
					$inputHidden = '<input type="hidden" name="app_background_e" id="app_background_e" value="'.$imageRename.'"/>';
				}
				
				echo '
				<li style="display: block;">
					<input type="hidden" id="img_name_0" value="" />
					<input type="hidden" id="img_name_e_0" value="" />
					<input type="hidden" id="img_path_0" value="' . $path_to . 'thumb-' . $imageRename . '" />
					<a href="javascript:;" id="'.$imageRename.'"><img src="../images/delete.png"></a>
					<img src="'.$path_to.'thumb-'.$imageRename.'" style="border:0px;">
					'.$inputHidden.'
				</li>';
			}
		}
	}
	
?>