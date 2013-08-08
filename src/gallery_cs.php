<?php 
	require ("includes/config.php");
	require ("includes/class/gallery.class.php");
	
	$gallery = new Gallery ();
	
	$menu_code = 5;
	
	$gall_image_default = '<img src="/images/no_avaliable.jpg" style="border:0px" width="200" height="120" alt="'.$meta_bussiness_name.'"/>';	
	$gall_code = 0;
	$path = "file_upload/gallery/";
	$images = NULL;
	$countImages = 0;
	
	if (isset ($_GET["gall_code"]) && ((int) $_GET["gall_code"] > 0) && $gallery->isValid((int) $_GET["gall_code"])) {
		$gall_code = (int) $_GET["gall_code"];
		$data = $gallery->getGallery($gall_code, $_SESSION["lang"]);
		$images = $gallery->getGalleryImages($gall_code, $_SESSION["lang"]);
		$countImages = count ($images);
	} else {
		echo ("<script> window.history.back(-1); </script>");
	}
	
	$html_images_thumb = "";
	
	for ($i = 0; $i < $countImages; $i++) {
		if (!file_exists ($path.'/870x522/'.$images[$i]->img_rename) || !file_exists ($path.'/200x120/'.$images[$i]->img_rename)) {
			continue;
		}
		
		$html_images_thumb .= '
		<li><a class="fancybox" href="/'.$path.'/870x522/'.$images[$i]->img_rename.'" data-fancybox-group="gallery" title=" ' . $images[$i]->img_name . ' "><img src="/'.$path.'/200x120/'.$images[$i]->img_rename.'" alt="" width="200" height="120" /></a></li>';
	}
?>