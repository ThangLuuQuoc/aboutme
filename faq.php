<?php require ("src/faq_cs.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/faq.js"></script>
<?php require("general_includes.php");?>

</head>

<body>
    <div class="wrap">
        <?php include ("header.php");?>
        <?php include ("menu.php");?>
      	<div id="Main">
            <div id="Contents-b" >
                <div class="spc">
                	<div class="title"><?php echo $appMenuPublic[$menu_code]->menu_value;?></div>
						<dl class="faqs">
                        	<?php for ($i = 0; $i < $countRows; $i++) {?>
                            	<dt><?php echo $list[$i]->faq_query;?></dt>                                
	                            <dd><?php echo $list[$i]->faq_answer;?></dd>
                            <?php }?>
                        </dl>
					</div>
                </div>
            </div>
    	</div>
    </div>
	<?php include ("footer.php");?>
</body>
</html>