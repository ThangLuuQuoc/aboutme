<?php header('Content-Type: text/html; charset=UTF-8'); require ("src/index_cs.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $_SESSION["lang"];?>">
<head>
<link rel="shortcut icon" href="favicon.ico">
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<?php require("general_includes.php");?>
<link rel="stylesheet" href="/css/nGallery-slider.css" type="text/css" media="screen" />


<script type="text/javascript" src="/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.gall.slider.pack.js"></script>
<script type="text/javascript" src="/js/nSlide-control.js"></script>
<script type="text/javascript" src="/js/cross-browser.js"></script>
<script type="text/javascript" src="/js/prefixfree.min.js"></script>
<script type="text/javascript" src="/js/modernizr-1.7.min.js"></script>



</head>
<body>	
    <div class="wrap">
		<?php include ("header.php");?>
		<?php include ("menu.php");?>
		<div id="Middle">
			<div class="mySlide">
				<div id="slider" class="nivoSlider">
					<?php echo $images_slider;?>
				</div>
				<?php echo $content_slider;?>
			</div>
		</div>
		<div id="Main" class="shadowB">

			<div class="bloq-a">
				<?php	
					for ($i = 0; $i < $countRows; $i++)	{
						$serv_image = $serv_image_default;
                        if ( ! empty ($list[$i]->serv_image)) {
                            $path_img = "file_upload/service/620x465/".$list[$i]->serv_image;
                            if (file_exists ($path_img)) {
                                $serv_image = '<img src="/'.$path_img.'" width="200" height="150" alt="'.$list[$i]->serv_name.'"/></a>';
							}
                        }
						
						$num_words = 120;
						if (strlen ($list[$i]->serv_name) > 22) {
							$num_words = 90;
						}
				?>
                        <div class="list-a" onclick="window.location.href='/<?php echo $messages_p["app_menu_service"].'/'.$list[$i]->serv_code.'/'.formatToUrl($list[$i]->serv_name);?>'">					
                            <div class="spc">
                                <div class="thumb">
                                    <?php echo $serv_image;?>
                                </div>
                                <h2><?php echo $list[$i]->serv_name;?></h2>
                                <div class="descrip"><?php echo truncate($list[$i]->serv_summary, $num_words);?></div>
                            </div>                    
                        </div>
                <?php 
					}
				?>
			</div>
            
			<?php include ("bloq-b.php");?>
		</div>
	</div>
	<?php include ("footer.php");?>
</body>
</html>