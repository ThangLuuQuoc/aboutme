<?php 
	require ("includes/config.php");
	require ("includes/class/faq.class.php");
		
	$menu_code = 8;
	
	$faq = new Faq();
	
	$list = $faq->faqList('', ' ORDER BY f.faq_order ', 0, 0, 1, $_SESSION["lang"]);
	$listRows = $faq->countFaq('', 1);
	$countRows = count ($list);
?>