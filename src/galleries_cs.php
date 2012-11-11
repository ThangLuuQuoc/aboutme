<?php 
	require ("includes/config.php");
	require ("includes/class/gallery.class.php");
	require ('includes/class/paginadorSemantica.class.php');
	
	$gallery = new Gallery();
	
	$menu_code = 5;
	$gall_image_default = '<img src="/images/no_avaliable.jpg" style="border:0px" width="200" height="120" alt="'.$meta_bussiness_name.'"/>';
	
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
	
	$list = $gallery->galleriesList('', 'ORDER BY gall_order', $init, $amount, 1, $_SESSION["lang"]);
	$listRows = $gallery->countGalleries('', 1);
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
	
?>