
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>demo box</title>
<link rel="stylesheet" href="css/styleLightbox.css" type="text/css" media="screen" />
<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript" type="text/javascript">
	
	function showLightBox()
	{
		function launch() 
		{
		  $('#sign_up').lightbox_me({centered: true, onLoad: function() { $('#sign_up').find('input:first').focus()}});
		}
		$("#sign_up").lightbox_me({centered: true, onLoad: function() {
			$("#sign_up").find("input:first").focus();
			$("#sign_up").find("input:first").select();
		}});
		$('table tr:nth-child(even)').addClass('stripe');
		
	}

</script>


</head>

<body>
<div id="sign_up">
	<table>
    	<tr>
    		<td>nombre</td>
            <td>..............................</td>
        </tr>
        <tr>
    		<td>nombre</td>
            <td>..............................</td>
        </tr>
	</table>    
</div>
<a href="javascript:;" onclick="showLightBox()">showLightBox</a>
</body>
</html>
