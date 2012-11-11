<?php 
	require ("includes/config.php");
	require ("includes/class/content.class.php");	
	
	$content = new Content();
	
	$menu_code = 2;	
	
	$dataContent = NULL;
	$usName = "";
	$usDescript = "";
	
	if (isset ($_GET["cont_code"]) && (int) $_GET["cont_code"] > 0) {
		$cont_code = (int) $_GET["cont_code"];
		
		if ($content->isValid($cont_code)) {
			$dataContent = $content->getContent($cont_code, $_SESSION["lang"]);
			$usName = $dataContent->cont_name;
			$usDescript = $dataContent->cont_text;
		}
	}
	
	if (empty ($usName) && empty ($usDescript)) {
		$usName = $appMenuPublic[$menu_code]->menu_value;
		
		$listContent = $content->contentList('', ' ORDER BY c.cont_order ', 0, 0, 1, $_SESSION["lang"]);
		$countListContent = count ($listContent);
		
		$submenuUs = '<ul>';
		for ($i = 0; $i < $countListContent; $i++) {
			$submenuUs .= '<li><a href="/'.$appMenuPublic[2]->menu_link.'/'.$listContent[$i]->cont_code.'/'.formatToUrl($listContent[$i]->cont_name).'">'.$listContent[$i]->cont_name.'</a></li>';
		}
		$submenuUs .= '</ul>';
		$usDescript = $submenuUs;
	}
?>