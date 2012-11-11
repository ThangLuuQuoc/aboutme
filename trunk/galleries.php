<?php require ("src/galleries_cs.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $_SESSION["lang"];?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<?php require("general_includes.php");?>

</head>

<body>
    <div class="wrap">
        <?php include ("header.php");?>
        <?php include ("menu.php");?>
      	<div id="Main">
            <div id="content-galleries">
                <div class="spc">
                	<h1><?php echo $appMenuPublic[$menu_code]->menu_value;?></h1>
                    <?php					
					if ($countRows == 0) {
					?>
						<div class="content-a">
							<div class="spc"><div class="no_data"><?php echo $messages_p["general_no_data"];?></div></div>
						</div>
					<?php	
						} else {
							for ($i = 0; $i < $countRows; $i++)	{
								$gall_image = $gall_image_default;
								if (! empty ($list[$i]->img_rename)) {
									$path_img = "file_upload/gallery/200x120/".$list[$i]->img_rename;
									if (file_exists ($path_img)) {
										$gall_image = '<img src="/'.$path_img.'" width="200" height="120" alt="'.$list[$i]->gall_name.'"/></a>';
									}
								}								
						?>
							<div class="item">                    	
                                <div class="gthumb"><a href="/<?php echo $messages_p["app_menu_gallery"].'/'.$list[$i]->gall_code.'/'.formatToUrl($list[$i]->gall_name);?>"><?php echo $gall_image;?></a></div>
                                <div class="gback"></div>
                                <h2><a href="/<?php echo $messages_p["app_menu_gallery"].'/'.$list[$i]->gall_code.'/'.formatToUrl($list[$i]->gall_name);?>"><?php echo $list[$i]->gall_name;?></a></h2>
                                <div class="photos"><?php echo $list[$i]->amount_images;?> <?php echo $messages_p["general_photos"];?></div>
                            </div>
						<?php 
							}
							
							include ("pagination.php");						
						}
					?>
                	
                </div>
            </div>
    	</div>
    </div>
	<?php include ("footer.php");?>
</body>
</html>