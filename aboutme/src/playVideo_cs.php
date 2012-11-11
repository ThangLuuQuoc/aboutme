<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/video.class.php");
	require ("../includes/class/youtube.class.php");
	
	$video = new Video();
	$youtube = new YouTube();
	
	$vid_image = 'poster="../images/broken-image.png"';
	$video_view = "";
	
	if (isset ($_GET["vid_code"]) && (int) $_GET["vid_code"] > 0) {
		$vid_code = (int) $_GET["vid_code"];
		
		$data = $video->getVideo($vid_code);
		
		if ($data->vid_type == 1) {
			if (file_exists ("../file_upload/videos/file/".$data->vid_file)) {
				$video_view = "../file_upload/videos/file/".$data->vid_file;
			}
		} elseif ($data->vid_type == 2) {
			$video_view = "http://www.youtube.com/v/".$data->vid_file;
		}
		
		if (! empty ($data->vid_image)) {
			$path_image = "../file_upload/videos/images/840x512/".$data->vid_image;
			if (file_exists ($path_image)) {
				$vid_image = 'poster="'.$path_image.'"';
			}
		}
	}	
?>