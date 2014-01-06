<?php 
	require ("includes/config.php");
	require ("includes/class/video.class.php");
	require ('includes/class/paginadorSemantica.class.php');
		
	$menu_code = 6;
	
	$video = new Video();
	
	$dataVideo = null;	
	
	$vid_code = 0;
	$vid_name = "";
	
	$video_view = "";
	$vid_image = '';
	$vid_image_thumb = '<img src="/images/broken-image.png" style="border: 0px" width="200" height="122" alt="'.$meta_bussiness_name.'">';
	
	if (isset ($_GET['init'])) {
		$init = $_GET['init'];
	} else {
		$init = 0;
	}
	
	if (isset ($_GET['amount'])) {
		$amount = $_GET['amount'];
	} else {
		$amount = 16;
	}
	
	$list = $video->videosList('', ' ORDER BY v.vid_order ', $init, $amount, 1, $_SESSION["lang"]);
	$listRows = $video->countVideos('', 1);
	$countRows = count ($list);
	
	$urlSemantic = '/'.$appMenuPublic[$menu_code]->menu_link;
	
	$paginadorSemantica = new PaginadorSemantica($list, $amount, 7, $init, $listRows, 0, '', $urlSemantic);
	$next = $paginadorSemantica->obtenerAtributoPaginador('btnSiguiente');
	$preview = $paginadorSemantica->obtenerAtributoPaginador('btnAnterior');
	$pages = $paginadorSemantica->obtenerAtributoPaginador('listaPaginas');
	
	$totalPages = $paginadorSemantica->obtenerAtributoPaginador('totalPaginas');
	$actualPage = $paginadorSemantica->obtenerAtributoPaginador('paginaActual');
		
	$to = ($amount + $init); 
	if ($to > $listRows || $listRows==0) {
		$to = $listRows;
	}
	
	$band_list = replaceMessage($messages_p["general_showing"], array (($init + 1), $to, $listRows));
	
	$showingAll = false;
	if($listRows == $amount) {
		$showingAll = true;
	}
	
	if ($init == 0) {
		$elementPreview = '<span class="disabled round">&#171;'.$messages_p["general_preview"].'</span>';
	} else {
		$elementPreview = '<a href="'.$preview.'" class="nextx round" >&#171; '.$messages_p["general_preview"].'</a>';
	}
	
	if ($listRows == $actualPage) {
		$elementNext = '<span class="disabled round">'.$messages_p["general_next"].' &#187;</span>';
	} else {
		$elementNext = '<a href="'.$next.'" class="nextx round">'.$messages_p["general_next"].' &#187;</a>';
	}
	
	// video seleccionado
	if (isset ($_GET["vid_code"]) && (int) $_GET["vid_code"] > 0) {
		$vid_code = (int) $_GET["vid_code"];		
	} elseif ($countRows > 0) {
		$vid_code = $list[0]->vid_code;
	}
	
	if ($video->isValid($vid_code)) {
		$dataVideo = $video->getVideo($vid_code, $_SESSION["lang"]);
		
		$vid_name = $dataVideo->vid_name;
		
		if ($dataVideo->vid_type == 1) {
			if (file_exists ("file_upload/videos/file/".$dataVideo->vid_file)) {
				$video_view = "/file_upload/videos/file/".$dataVideo->vid_file;
			}
		} elseif ($dataVideo->vid_type == 2) {
			$video_view = "http://www.youtube.com/v/".$dataVideo->vid_file;
		}
		
		if (! empty ($dataVideo->vid_image)) {
			$path_image = "file_upload/videos/images/840x512/".$dataVideo->vid_image;
			if (file_exists ($path_image)) {
				$vid_image = 'poster="/'.$path_image.'"';
			}
		}
	}

	$twitterText = $vid_name;
	$hiddenCommentsPlugin = true;
?>