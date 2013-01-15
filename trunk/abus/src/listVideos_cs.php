<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/paginador.class.php");
	require ("../includes/class/video.class.php");
	
	$video = new Video();
	
	$parametersSearch = '';
	
	$titlePage = $messages["general_title_videos"];
	$titleAdd = $messages["general_title_videos_add"];
	$scriptAdd = "addUpdateVideo.php";
	
	if (isset ($_GET['init'])) {
		$init = $_GET['init'];
	} else {
		$init = 0;
	}
	
	if (isset ($_GET['amount'])) {
		$amount = $_GET['amount'];
	} else {
		$amount = 10;
	}
	
	if (isset ($_POST['search']) && $_POST['search'] != '') {
		$search = $_POST['search'];
		$parametersSearch .= '&search='.$search;
		$init = 0;
	} elseif (isset($_GET['search']) && $_GET['search']!='') {
		$search = $_GET['search'];
		$parametersSearch .= '&search='.$search;
	} else {
		$search = '';
	}
		
   	//<ORDER_BY>
	//VARS CONFIG
	$fields_sql_order_by  = array ("", "vid_name", "vid_date_create", "vid_status", "vid_order", "");
	$field_is_href = array (0, 1, 1, 1, 1, 0);//para saber si es o no campo para ordenar	
	$fields_name_order_by = array ($messages["general_image"], $messages["general_name"], $messages["general_date_create"], $messages["general_status"], $messages["general_order"], $messages["general_options"]);
	
	$item_width = array("10%", "35%", "10%", "15%", "15%", "");
	$method_order = "GET";
	$ord_default = 'ASC';
	$class_href_order = 'lbl_white';//clase del href	
	$index_order_default = 3;//por cual ordenar en primer vez
	$img_order_desc = "images/down_arrow.gif";
	$img_order_asc  = "images/up_arrow.gif";
	$title_order_asc = "";
	$title_order_desc = "";
	//END VARS CONFIG
	if($method_order == 'GET' && isset($_GET['order_by']) && isset($_GET['ord'])){
		$order_by = $_SESSION['order_by'] = $_GET['order_by'];
		$ord = $_SESSION['ord'] = $_GET['ord'];
		$isset_order = true;
	}
	elseif($method_order == 'POST' && isset($_POST['order_by']) && isset($_POST['ord'])){
		$order_by = $_SESSION['order_by'] = $_POST['order_by'];
		$ord = $_SESSION['ord'] = $_POST['ord'];
		$isset_order = true;
	}
	elseif(isset($_SESSION["order_by"]) && in_array($_SESSION["order_by"],$fields_sql_order_by) && trim($_SESSION["order_by"]) != '' && 
			isset($_SESSION["ord"]) && trim($_SESSION["ord"]) != ''){
		$order_by = $_SESSION['order_by'];
		$ord = $_SESSION['ord'];
		$isset_order = true;
	}
	else{
		$order_by = $_SESSION['order_by'] = $fields_sql_order_by[$index_order_default];
		$ord = $_SESSION['ord'] = $ord_default;
		$isset_order = false;	
	}
	
	if($ord == "DESC"){
		$ord_next = 'ASC';
		$title_order = $title_order_asc;
		$img_ord = '<img src="'.$img_order_desc.'" alt="'.$title_order_asc.'" style="border:0px"/>';
	}
	else{
		$ord_next = 'DESC';
		$title_order = $title_order_desc;
		$img_ord = '<img src="'.$img_order_asc.'" alt="'.$title_order_desc.'" style="border:0px"/>';
	}	
		
	$lbl_order = $ord_href = array();
	$parametersSearch .= '&order_by='.$order_by.'&ord='.$ord;
	for($i=0;$i<count($fields_sql_order_by);$i++){		
		if($field_is_href[$i]){
			if($isset_order){
				if($order_by == $fields_sql_order_by[$i])
					$img_ord_show = $img_ord;
				else
					$img_ord_show = '';
			}
			elseif($i == $index_order_default)
				$img_ord_show = $img_ord;
			else
				$img_ord_show = '';
			
			if($method_order == 'GET')
				$ord_href[$i] = '<a href="?'.$parametersSearch.'&order_by='.$fields_sql_order_by[$i].'&ord='.$ord_next.'" title="'.$title_order.'" class="'.$class_href_order.'">'.$fields_name_order_by[$i].'&nbsp;'.$img_ord_show.'</a>';
			elseif($method_order == 'POST')
				$ord_href[$i] = '<a href="javascript:;" onclick="javascript: orderby_list(&apos;'.$fields_sql_order_by[$i].'&apos;,&apos;'.$ord_next.'&apos;)" title="'.$title_order.'" class="'.$class_href_order.'">'.$fields_name_order_by[$i].'&nbsp;'.$img_ord_show.'</a>';
		}
		else
			$ord_href[$i]='<span class="'.$class_href_order.'">'.$fields_name_order_by[$i].'</span>';
	}
	
	$orderByList = " ORDER BY ".$order_by.' '.$ord;//usar esta variable para la consulta
	if ($order_by != "vid_order") {
		$orderByList .= ", vid_order";
	}
	//</ORDER_BY>
	$list = $video->videosList($search, $orderByList, $init, $amount);
	$listRows = $video->countVideos($search);	
	$countRows = count ($list);
	
	$arrayOrders = $video->getArrayOrders();
	$countOrders = $video->getMaxOrder(true);
	
	$paginator = new Paginador($list, $amount, 7, $init, $listRows, 0, $parametersSearch);
	$next = $paginator->obtenerAtributoPaginador('btnSiguiente');
	$preview = $paginator->obtenerAtributoPaginador('btnAnterior');
	$pages = $paginator->obtenerAtributoPaginador('listaPaginas');
	
	$totalPages = $paginator->obtenerAtributoPaginador('totalPaginas');
	$actualPage = $paginator->obtenerAtributoPaginador('paginaActual');
	
	$to = ($amount + $init); 
	if ($to > $listRows || $listRows==0) {
		$to=$listRows;
	}
	
	$band_list = replaceMessage($messages["general_showing"], array (($init + 1), $to, $listRows));
?>