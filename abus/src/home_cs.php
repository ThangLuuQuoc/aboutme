<?php
	include("includes/secure.php");
	include("../includes/config.php");
	
	$dataApp = $application->getInformationApp();
	
	$maxlength_app_information_office = 350;
	$maxlength_app_information_office_e = 350;
	
	$maxlength_app_keywords = 160;
	$maxlength_app_keywords_e = 160;
	
	$appFullMenu = $application->getAppMenu();
	$countFullMenu = count ($appFullMenu);
	
	$app_background = '<input type="hidden" name="app_background" id="app_background" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	$app_background_e = '<input type="hidden" name="app_background_e" id="app_background_e" value=""/><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/>';
	
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
?>