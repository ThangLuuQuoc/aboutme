<?php	
	
	if (! isset ($submenuUs)) {
		require_once ("includes/class/content.class.php");
	
		$content = new Content();
		$listContent = $content->contentList('', ' ORDER BY c.cont_order ', 0, 0, 1, $_SESSION["lang"]);
		$countListContent = count ($listContent);
		
		$submenuUs = '<ul>';
		for ($i = 0; $i < $countListContent; $i++) {
			$submenuUs .= '<li><a href="/'.$appMenuPublic[2]->menu_link.'/'.$listContent[$i]->cont_code.'/'.formatToUrl($listContent[$i]->cont_name).'">'.$listContent[$i]->cont_name.'</a></li>';			
		}
		$submenuUs .= '<li><a href="/'.$appMenuPublic[2]->menu_link.'/'.formatToUrl($messages_p["general_our_personal"]).'">'.$messages_p["general_our_personal"].'</a></li>';
		$submenuUs .= '<li><a href="/'.$appMenuPublic[2]->menu_link.'/'.formatToUrl($messages_p["general_social_information"]).'">'.$messages_p["general_social_information"].'</a></li>';
		$submenuUs .= '</ul>';
	}
	
	if (! isset ($submenuServiceType)) {
		require_once ("includes/class/serviceType.class.php");
		
		$serviceType = new ServiceType();
		
		$listServiceType = $serviceType->serviceTypeList("", ' ORDER BY sertype_status, sertype_order', 0, 0, 1, true, $_SESSION["lang"]);
		$countServiceType = count ($listServiceType);
		
		$submenuServiceType = '<ul>';
		for ($i = 0; $i < $countServiceType; $i++) {
			$submenuServiceType .= '<li><a href="/'.$appMenuPublic[3]->menu_link.'/'.$listServiceType[$i]->sertype_code.'/'.formatToUrl($listServiceType[$i]->sertype_name).'">'.$listServiceType[$i]->sertype_name.'</a></li>';
		}
		$submenuServiceType .= '</ul>';
	}
	
	$appMenuPublic[2]->submenu = $submenuUs;
	$appMenuPublic[3]->submenu = $submenuServiceType;
?>