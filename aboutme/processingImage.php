<?php
	require ("includes/secure.php");
	
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
					require ("../includes/config.php");
					require ("../includes/class/gallery.class.php");					
					
					$gallery = new Gallery();
					
					$path = "../file_upload/gallery/200x120/";
					$images = $gallery->getGalleryImages((int) $_GET['id']);
					$countImages = $gallery->countGalleryImages((int) $_GET['id']);
					
					for ($i = 0; $i < $countImages; $i++) {
						$pathImage = "../file_upload/gallery/200x120/";
						if (!file_exists ($pathImage.$images[$i]->img_rename)) {
							continue;
						}
						
						echo  '
						<li style="display: block;">
							<a href="javascript:;" id="'.$images[$i]->img_code.'"><img src="../images/delete.png"></a>
							<img src="'.$pathImage.$images[$i]->img_rename.'">
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
					<a href="javascript:;" id="'.$imageRename.'"><img src="../images/delete.png"></a>
					<img src="'.$path_to.'thumb-'.$imageRename.'" style="border:0px;">
					'.$inputHidden.'
				</li>';
			}
		}
	}
	
?>