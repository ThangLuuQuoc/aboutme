<?php 
	require ("includes/config.php");
	require ("includes/class/slider.class.php");
	require ("includes/class/service.class.php");
	
	$menu_code = 1;
	
	$slider = new Slider();
	$service = new Service();
	
	$listItemsSlider = $slider->listItemsSlider('', ' ORDER BY slid_order ', 0, 0, 1, $_SESSION["lang"]);
	$countItemsSlider = count ($listItemsSlider);
	
	$images_slider = '';
	$content_slider = '';
	$k = 1;
	for ($i = 0; $i < $countItemsSlider; $i++) {
		$slid_image_rename = $listItemsSlider[$i]->slid_image_rename;
		$slid_image_name = $listItemsSlider[$i]->slid_image_name;
		$slid_title = $listItemsSlider[$i]->slid_title;
		$slid_content = $listItemsSlider[$i]->slid_content;		
		$slid_url = $listItemsSlider[$i]->slid_url;
		
		if (! empty ($slid_image_rename)) {
			$path_img = "file_upload/slider/750x320/".$slid_image_rename;
			if (file_exists ($path_img)){
				if (! empty ($slid_url)) {
					$images_slider .= '<a href="'.$slid_url.'" target="_blank">';
				}
				
				$images_slider .= '<img src="/'.$path_img.'" style="border:0px" width="750" height="320" alt="'.$slid_title.'" title="#html-'.$k.'"/>';
				
				if (! empty ($slid_url)) {
					$images_slider .= '</a>';
				}
				
				$content_slider .= '<div id="html-'.$k.'" class="nivo-html-caption"><h2 class="title">'.$slid_title.'</h2><div class="data">'.truncate($slid_content, 400, '').'</div></div>';				
				$k ++;	
			}
		}
	}	
	$serv_image_default = '<img src="/images/broken-image.png" style="border:0px" width="193" height="145" alt="'.$meta_bussiness_name.'"/>';
	$list = $service->serviceList('', ' ORDER BY s.serv_order ', 0, 6, 1, 0, $_SESSION["lang"]);
	$countRows = count ($list);
?>