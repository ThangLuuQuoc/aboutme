<?php include("src/playVideo_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $messages["general_video"]." :: ".$messages["general_name_app"];?>
</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="/js/jwplayer.js"></script>
<script language="javascript" type="text/javascript">
		
	$(document).ready(function(){
    	try {
			jwplayer("container").setup({ 
				flashplayer: "/player.swf"
			});
		} catch(e) {}
	});

	
</script>


</head>
<body style="padding:0px; margin:0px;">
    <video src="<?php echo $video_view;?>" height="512" id="container" <?php echo $vid_image;?> width="840"></video>
</body>
</html>