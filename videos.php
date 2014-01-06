<?php  require ("src/videos_cs.php"); error_reporting(0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<?php require("general_includes.php");?>
<script type="text/javascript" src="/js/jwplayer.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		try {
			jwplayer("container").setup({ 
				flashplayer: "/player.swf"/*,
				autostart: true*/
			});
		} catch(e) {}
		
		window.scrollTo(0,170);
	});
</script>
</head>

<body>
    <div class="wrap">
        <?php include ("header.php");?>
        <?php include ("menu.php");?>
      	<div id="Main">
            <div id="Contents-b">
                <div class="spc">
                	<h1><?php echo $appMenuPublic[$menu_code]->menu_value;?></h1>
                    <div class="mVideos">                                                
                        <?php 				
							if ($listRows == 0) {
						?>
							<div class="content-a">
								<div class="spc"><div class="no_data"><?php echo $messages_p["general_no_data"];?></div></div>
							</div>
						<?php } else { ?>
							<div class="mvid">
                            <h2><?php echo $vid_name;?></h2>
                                <div class="v1">
                                    <video src="<?php echo $video_view;?>" height="512" id="container" <?php echo $vid_image;?> width="840"></video>
                                    <div class="shadow"></div>
                                </div>
								<?php 
									if ($vid_code) {							
										include ("socialBar.php");							
									}
								?>
                            </div>
                        <?php
							for ($i = 0; $i < $countRows; $i++)	{
								$path_video = "file_upload/videos/file/".$list[$i]->vid_file;
								
								if ($list[$i]->vid_type == 1 && ! file_exists ($path_video)) {
									continue;
								}
								
								$path_img = "file_upload/videos/images/200x122/".$list[$i]->vid_image;
								$thumb_image = '<a href="/'.$init.'/'.$amount.'/'.$messages_p["app_menu_videos"].'/'.$list[$i]->vid_code.'/'.formatToUrl($list[$i]->vid_name).'">'.$vid_image_thumb.'</a>';$img_youtube = "";
								if (! empty ($list[$i]->vid_image) && file_exists ($path_img)) {
									$thumb_image = '<a href="/'.$init.'/'.$amount.'/'.$messages_p["app_menu_videos"].'/'.$list[$i]->vid_code.'/'.formatToUrl($list[$i]->vid_name).'"><img src="/'.$path_img.'" width="200" height="122" alt="'.$list[$i]->vid_name.'"/></a>';
								} elseif ($list[$i]->vid_type == 2) {
									$img_youtube = "http://img.youtube.com/vi/".$list[$i]->vid_file."/1.jpg";
									$url = "http://img.youtube.com/vi/".$dataVideo->vid_file."/1.jpg";
									if ($conex = @fopen ($img_youtube, "rt")) {
										$thumb_image = '<a href="/'.$init.'/'.$amount.'/'.$messages_p["app_menu_videos"].'/'.$list[$i]->vid_code.'/'.formatToUrl($list[$i]->vid_name).'"><img src="'.$img_youtube.'" width="200" height="122" alt="'.$list[$i]->vid_name.'"/></a>';
									}
								}
						?>
							<div class="content-video">
	                            <div class="listVideoTh">
		                            <div class="vthumb"><?php echo $thumb_image;?></div>
	    	                        <div class="play" onclick="window.location.href='/<?php echo $init.'/'.$amount.'/'.$messages_p["app_menu_videos"].'/'.$list[$i]->vid_code.'/'.formatToUrl($list[$i]->vid_name);?>'"></div>
	        	                    <div class="dat"><a href="/<?php echo $init.'/'.$amount.'/'.$messages_p["app_menu_videos"].'/'.$list[$i]->vid_code.'/'.formatToUrl($list[$i]->vid_name);?>" title="<?php echo $img_youtube;?>"><?php echo $list[$i]->vid_name;?></a></div>
	                            </div>
	                        </div>
						<?php 
							}
							include ("pagination.php");
						}?>
                    </div>
                    
                </div>
            </div>
    	</div>
    </div>
	<?php include ("footer.php");?>
</body>
</html>