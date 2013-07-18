<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico">
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/coolMessage.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/style_menu.css" type="text/css" media="screen" />
<style type="text/css">
	body {
		<?php echo $app_background_public;?>	
	}
</style>
<script language="javaScript" type="text/javascript" src="/js/jquery.js"></script>
<script language="javaScript" type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script language="javaScript" type="text/javascript" src="/js/coolMessage.js"></script>

<script language="javaScript" type="text/javascript">
	
	function showMessage(show_msg) {
		switch (show_msg) {
			case 1://error
				coolMessage('error',
						"<?php echo $message_value;?>");
				break;
	
			case 2://alert
				coolMessage('alert',
						"<?php echo $message_value;?>");
				break;
	
			case 3://information
				coolMessage('information',
						"<?php echo $message_value;?>");
				break;
	
			default:
				return false;
			break;
		}
		return false;
	}
		
	var displayRow = '';
	if (navigator.appName == "Netscape") {
		displayRow = 'table-row';
	} else if (navigator.appName.indexOf("Explorer") != -1) {
		displayRow = 'block';
	}
	
	function isMail(valor) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)) {
			return (true);
		} else{ 
			return (false);
		}
	}
	
	function validateURL(url) {
		var regex=/^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i;
		return regex.test(url);
	}
	
	function onlyNumbers(e){		
		var key;
		if(window.event) {
			key = window.event.keyCode;   //IE
		} else {
			key = e.which;                //firefox
		}
		
		if (!( (key >= 48 && key <= 57) || key ==8 || key ==9 || key ==0 || key ==46 )) {
			return false;
		} else {
			return true;
		}
	}
	
</script>

<!-- <plugin_facebook> -->
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- </plugin_facebook> -->

<meta name="author" content="sebastian lara" />
<meta name="description" content="<?php echo $meta_description_value;?>" />
<meta name="keywords" content="<?php echo $meta_keywords_value;?>" />