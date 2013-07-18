<?php 
	require ("includes/config.php");
	require ("includes/class/service.class.php");
	require ("includes/class/serviceType.class.php");
	require ('includes/class/paginadorSemantica.class.php');
	
	$service = new Service();
	$serviceType = new ServiceType();
	
	$menu_code = 3;
	
	$list = NULL;
	$listRows = 0;
	$countRows = 0;
	
	$serv_image_default = '<img src="/images/no_avaliable.jpg" style="border:0px" width="193" height="145" alt="'.$meta_bussiness_name.'"/>';
	
	$sertype_code = 0;
	$sertype_name = ""; // para mostrar en la url
	$sertype_name_value = ''; // para mostrar en la página
	
	$showServices = false; //bandera para saber si se tiene que mostrar o no una lista de servicios.
	$isServiceValid = false;
	
	$serv_code = 0;
	$serv_name = "";
	$serv_image = '<img src="/images/no_avaliable.jpg" style="border:0px" width="620" height="465" alt="'.$meta_bussiness_name.'" />';
	$serv_description = "";
	
	
	if (isset ($_GET["sertype_code"]) && (int) $_GET["sertype_code"] > 0) {
		$sertype_code = (int) $_GET["sertype_code"];
		
		if (isset ($_GET["sertype_name"]) && $_GET["sertype_name"] != "") {
			$sertype_name = $_GET["sertype_name"];
		}
		
		if ($serviceType->isValid($sertype_code)) {
			$serviceTypeData = $serviceType->getServiceType($sertype_code, $_SESSION["lang"]);
			$sertype_name_value = $serviceTypeData->sertype_name;


			$showServices = true;
			
			if (isset ($_GET['init'])) {
				$init = $_GET['init'];
			} else {
				$init = 0;
			}
			
			if (isset ($_GET['amount'])) {
				$amount = $_GET['amount'];
			} else {
				$amount = 6;
			}
			
			$list = $service->serviceList('', ' ORDER BY s.serv_order ', $init, $amount, 1, $sertype_code, $_SESSION["lang"]);
			$listRows = $service->countServices('', 0, $sertype_code);			
			$countRows = count ($list);
			
			$urlSemantic = '/'.$appMenuPublic[$menu_code]->menu_link.'/'.$sertype_code.'/'.$sertype_name;
			
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
		}
	} elseif (isset ($_GET["serv_code"]) && (int) $_GET["serv_code"] > 0) {
		$serv_code = (int) $_GET["serv_code"];
		
		if (isset ($_GET["serv_name"]) && $_GET["serv_name"] != "") {
			$serv_name = $_GET["serv_name"];
		}
		
		if ($service->isValid($serv_code)) {			
			$isServiceValid = true;
			$servData = $service->getService($serv_code, $_SESSION["lang"]);
			$serv_name = $servData->serv_name;
			
			if ( ! empty ($servData->serv_image)) {
				$path_img = "file_upload/service/620x465/".$servData->serv_image;
				if (file_exists ($path_img)) {
					$serv_image = '<img src="/'.$path_img.'" width="620" height="465" alt="'.$servData->serv_name.'"/></a>';
				}
			}
			
			$serv_description = $servData->serv_description;
		}
	}
	
	
		
	if (! $showServices) {
		$listServiceType = $serviceType->serviceTypeList("", ' ORDER BY sertype_status, sertype_order', 0, 0, 1, true, $_SESSION["lang"]);
		$countServiceType = count ($listServiceType);
		
		$submenuServiceType = '<ul>';
		for ($i = 0; $i < $countServiceType; $i++) {
			$submenuServiceType .= '<li><a href="/'.$appMenuPublic[3]->menu_link.'/'.$listServiceType[$i]->sertype_code.'/'.formatToUrl($listServiceType[$i]->sertype_name).'">'.$listServiceType[$i]->sertype_name.'</a></li>';
		}
		$submenuServiceType .= '</ul>';	
	}	
?>