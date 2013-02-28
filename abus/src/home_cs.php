<?php
	include("includes/secure.php");
	include("../includes/config.php");
	
	$dataApp = Application :: getInformationApp();
	
	$maxlength_app_information_office = 350;
	$maxlength_app_information_office_e = 350;
	
	$maxlength_app_keywords = 160;
	$maxlength_app_keywords_e = 160;
	
	$appFullMenu = Application :: getAppMenu();
	$countFullMenu = count ($appFullMenu);
	
	$app_background = '<input type="hidden" name="app_background" id="app_background" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	$app_background_e = '<input type="hidden" name="app_background_e" id="app_background_e" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	
	$app_information_office = NULL;
	$app_background_type = NULL;
	$app_background_color = NULL;
	$app_code = NULL;
	$app_background = NULL;
	$app_background_e = NULL;
	$app_slogan = NULL;
	$app_slogan_e = NULL;
	$app_information_office_e = NULL;
	$app_keywords = '';
	$app_keywords_e = '';

	if (! empty ($dataApp->app_background)) {
		$path_image = "../file_upload/background/".$dataApp->app_background;
		$path_image_thumb = "../file_upload/background/thumb-".$dataApp->app_background;
		if (file_exists ($path_image) && file_exists ($path_image_thumb)) {
			$app_background = '
			<li style="display: block;">
				<img src="'.$path_image_thumb.'" style="border:0px" width="500" height="300"/>
				<input type="hidden" name="app_background" id="app_background" value="'.$dataApp->app_background.'"/>
			</li>';
		}

		$app_information_office = $dataApp->app_information_office;
		$app_background_type = $dataApp->app_background_type;
		$app_background_color = $dataApp->app_background_color;
		$app_code = $dataApp->app_code;
		$app_background = $dataApp->app_background;
		$app_background_e = $dataApp->app_background_e;
		$app_slogan = $dataApp->app_slogan;
		$app_slogan_e = $dataApp->app_slogan_e;
		$app_information_office_e = $dataApp->app_information_office_e;
		$app_keywords = $dataApp->app_keywords;
		$app_keywords_e = $dataApp->app_keywords_e;
	}
	
	if (! empty ($dataApp->app_background_e)) {
		$path_image = "../file_upload/background/".$dataApp->app_background_e;
		$path_image_thumb = "../file_upload/background/thumb-".$dataApp->app_background_e;
		if (file_exists ($path_image) && file_exists ($path_image_thumb)) {
			$app_background_e = '
			<li style="display: block;">
				<img src="'.$path_image_thumb.'" style="border:0px" width="500" height="300"/>
				<input type="hidden" name="app_background_e" id="app_background_e" value="'.$dataApp->app_background_e.'"/>
			</li>';
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
	}
?>