<?php
	require ("includes/secure.php");
	require ("../includes/config.php");	
	require ("../includes/class/video.class.php");
	require ("../includes/class/resize/imagen.class.php5");
	require ("../includes/class/fileManagement.class.php");
	require ("../includes/class/youtube.class.php");
		
	$video = new Video();
	$image = new Imagen();
	$file = new fileManagement();
	$youtube = new YouTube();
	
	$titlePage = $messages["general_title_videos_add"];
		
	$vid_code = "";
	
	$vid_name = "";
	$vid_summary = "";
	$vid_original = "";
	$vid_file = "";
	$vid_image = "";
	$vid_status = "";
	$vid_type = 1;
	$vid_name_e = "";
	$vid_summary_e = "";
	$vid_imag_type = "";
	
	$vid_image_dafault = '<img src="../images/broken-image.png" style="border:0px" width="200" height="120"/>';
	$vid_order = "";
	
	$action = "add";
	$path_image = "../images/broken-image.png";
	$video_view = "";
	
	$allow_extensions = array(".flv", ".mp4", ".mp3");
	
	if (isset ($_POST['save']) && $_POST['save'] == 1 ) {
		$data->vid_code = fieldSecure($_POST['vid_code']);
		$data->use_code = fieldSecure((int) $_SESSION['use_code']);
		$data->vid_name = fieldSecure($_POST['vid_name']);
		$data->vid_summary = fieldSecure($_POST['vid_summary']);
		$data->vid_original = "";
		$data->vid_file = "";				
		$data->vid_image = fieldSecure($_POST['vid_image']);
		$data->vid_status = fieldSecure($_POST['vid_status']);
		$data->vid_type = fieldSecure($_POST['vid_type']);
		$data->vid_name_e = fieldSecure($_POST['vid_name_e']);
		$data->vid_summary_e = fieldSecure($_POST['vid_summary_e']);
		$data->vid_imag_type = fieldSecure($_POST['vid_imag_type']);
		
		$error = false;
		if (($data->vid_type == 1) && is_uploaded_file ($_FILES['vid_file_pc']['tmp_name'])) {
			$filename = basename($_FILES['vid_file_pc']['name']);
			$file_ext = strtolower ( substr ( $filename, strrpos ( $filename, '.') ) );
			
			if ( ! in_array ($file_ext, $allow_extensions) ){
				$_SESSION["messageValue"] = $messages["videoValidation_formatVideoValidate"].'<br />';
				$_SESSION["messageShow "] = 2;
				$error = true;
			} else {
				$vid_file_pc = $file->subirArchivo($_FILES['vid_file_pc']['tmp_name'], $_FILES['vid_file_pc']['name'], '../file_upload/videos/file/');
				
				if ($vid_file_pc != ".") {
					$data->vid_file = $vid_file_pc;
					$data->vid_original = $_FILES['vid_file_pc']['name'];
				} else {
					$error = true;	
				}
			}
		} elseif ($data->vid_type == 2 && fieldSecure($_POST["vid_file_yt"])) {
			$id_youtube = $youtube->getVideoIdFromUrl(fieldSecure($_POST["vid_file_yt"]));
			$url = "http://img.youtube.com/vi/".$id_youtube."/1.jpg";
			if (! empty($id_youtube)/*$conex= @fopen ($url, "rt")*/) {
				$data->vid_original = fieldSecure($_POST["vid_file_yt"]);
				$data->vid_file = $id_youtube;
			} else {
				$_SESSION["messageValue"] = $messages["videoValidation_noExistsValidate"].'<br />';
				$_SESSION["messageShow "] = 2;
				$error = true;
			}
		}
		
		if (! empty ($data->vid_image) && $data->vid_image != $_POST["vid_image_prev"]) {
			$copyImage = copy ("../file_upload/images_bank/".$data->vid_image, '../file_upload/videos/images/840x512/'.$data->vid_image);
			
			if ( $copyImage ) {
				$image->redimensionarImagen(200, 122, '../file_upload/videos/images/840x512/'.$data->vid_image, '../file_upload/videos/images/200x122/'.$data->vid_image,
						 "white");
				unlink ("../file_upload/images_bank/".$data->vid_image);							
			} else {
				$error = true;
			}
		}
		
		if ($error) {
			if (empty ($_SESSION["messageValue"])) {
				$_SESSION["messageValue"] = $messages["video_message_errorAdding"].'...<br />';
			}
			$_SESSION["messageShow "] = 1;
		} elseif (empty ($data->vid_code)) {
			$data->vid_order = ((int) $video->getMaxOrder() + 1);			
			
			if ($data->vid_code = $video->insertVideo($data)) {				
				$_SESSION["messageValue"] = replaceMessage($messages["video_message_added"], array($data->vid_name)).'<br />';
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["video_message_errorAdding"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		} elseif ($data->vid_code > 0) {			
			if ($video->updateVideo($data)) {
				$_SESSION["messageValue"] = replaceMessage($messages["video_message_updated"], array($data->vid_name));
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["video_message_errorUpdating"].'<br />';
				$_SESSION["messageShow "] = 1;
			}
		}		
		
		if (($_SESSION["messageShow "] == 3)) {
			if (! empty ($data->vid_file) && ($data->vid_file != $_POST["vid_file_prev"])) {			
				$path_aux = "../file_upload/videos/file/".$_POST["vid_file_prev"];
				if (file_exists ($path_aux)) {	
					chmod("../file_upload/videos/file/", 0777);
					unlink ($path_aux);	
				}
			}
			
			if (!empty ($_POST["vid_image_prev"]) && ($data->vid_image != $_POST["vid_image_prev"])) {
				$path_aux = "../file_upload/videos/images/840x512/".$_POST["vid_image_prev"];				
				if (file_exists ($path_aux)) {
					unlink ($path_aux);	
				}
				
				$path_aux = "../file_upload/videos/images/200x122/".$_POST["vid_image_prev"];				
				if (file_exists ($path_aux)) {
					unlink ($path_aux);	
				}
			}
		}
		
		
		echo "<script> window.location.href='listVideos.php'</script>";
	} elseif (isset ($_GET["vid_code"]) && (int) $_GET["vid_code"] > 0) {
		$vid_code = (int) $_GET["vid_code"];
		$titlePage = $messages["general_title_videos_update"];
		$action = "update";
		
		$data = $video->getVideo($vid_code);
		
		$vid_name = $data->vid_name;
		$vid_summary = $data->vid_summary;
		$vid_original = $data->vid_original;
		$vid_file = $data->vid_file;
		$vid_image = $data->vid_image;
		$vid_status = $data->vid_status;
		$vid_type = $data->vid_type;
		$vid_name_e = $data->vid_name_e;
		$vid_summary_e = $data->vid_summary_e;
		$vid_imag_type = $data->vid_imag_type;
		
		if (! empty ($data->vid_image)) {
			$path_image = "../file_upload/videos/images/200x122/".$data->vid_image;
			if (file_exists ($path_image)) {
				$vid_image_dafault = '<li style="display: block;"><a href="javascript:;" id="'.$data->vid_image.'"><img src="../images/delete.png"></a><img src="'.$path_image.'"></li>';
			} else {
				$path_image = "../images/broken-image.png";	
			}
		}
		
		if ($data->vid_type == 1) {
			if (file_exists ("../file_upload/videos/file/".$data->vid_file)) {
				$video_view = "../file_upload/videos/file/".$data->vid_file;
			}
		} elseif ($data->vid_type == 2) {
			$video_view = "http://www.youtube.com/v/".$data->vid_file;
		}
	}
	
?>