<!-- slider lateral -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="/masterslider/style/masterslider.css" />

<!-- Master Slider Skin -->
<link href="/masterslider/skins/black-2/style.css" rel='stylesheet' type='text/css'>
 
<!-- MasterSlider Template Style -->
<link href='css/ms-gallery-style.css' rel='stylesheet' type='text/css'>

<!-- google font Lato -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

<!-- jQuery -->
<script src="/masterslider/jquery-1.10.2.min.js"></script>
<script src="/masterslider/jquery.easing.min.js"></script>

<!-- Master Slider -->
<script src="/masterslider/masterslider.min.js"></script>

<!-- Template JS -->
<script src="js/masterslider.gallery.js"></script>	

<style>			
	#ms-gallery-1{
		max-width: 100%;
		margin:0 auto;
	}
</style>
<!-- slider lateral -->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico">
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/coolMessage.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/style_menu.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/searcher/foxycomplete.css" />
<link rel="stylesheet" href="/css/fixed-button.css" />
<link rel="stylesheet" href="/css/styleLightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/nGallery-slider.css" type="text/css" media="screen" />

<style type="text/css">
	body {
		<?php echo $app_background_public;?>	
	}
</style>

<?php include ("css/abus-dinamic.php");?>
<script language="javaScript" type="text/javascript" src="/js/jquery.js"></script>
<script language="javaScript" type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script language="javaScript" type="text/javascript" src="/js/coolMessage.js"></script>

<!-- <searcher>-->
<script type='text/javascript' src='/js/searcher/jquery.autocomplete.js'></script>
<script type='text/javascript' src='/js/searcher/foxycomplete.js'></script>
<!-- </searcher>-->

<script language="javaScript" type="text/javascript">
	
	function showMessage(show_msg) {
		switch (show_msg) {
			case 1://error
				coolMessage('error',
						"<?php echo $messageValue;?>");
				break;
	
			case 2://alert
				coolMessage('alert',
						"<?php echo $messageValue;?>");
				break;
	
			case 3://information
				coolMessage('information',
						"<?php echo $messageValue;?>");
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
	<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	function showLightBox()	{
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
	
	function closeLightBox() {
		$('#sign_up').trigger('close');
	}

	function validateSendOrder() {
		var msg = "";
        
        var brow_serv_order_nro = $.trim(document.getElementById("brow_serv_order_nro").value);
        var brow_serv_email = $.trim(document.getElementById("brow_serv_email").value);       
        var brow_serv_comment = $.trim(document.getElementById("brow_serv_comment").value);       
        
        
        if (brow_serv_order_nro == "" ) {
            msg += " <?php echo $messages_p["validationBrowseByService_order_nro"]; ?><br>";
        }

        if (brow_serv_email == "") {
            msg += " <?php echo $messages_p["validationBrowseByService_email_response"]; ?>";
        } else if (!isMail(brow_serv_email)) {
            msg += " <?php echo $messages_p["validationContactus_emailValidation"]; ?>";
        }
                
        if (msg == '') {
            jQuery.ajax({
                type : "POST",
                async : false,
                url : "/sendDataBrowseByService.php",
                data : 'brow_serv_order_nro=' + brow_serv_order_nro + '&brow_serv_email=' + brow_serv_email + '&brow_serv_comment=' + brow_serv_comment,
                success : function(result) {
                    if (result == 1) {
                        document.getElementById("brow_serv_order_nro").value = "";
                        document.getElementById("brow_serv_email").value = "";
                        document.getElementById("brow_serv_comment").value = "";
                        coolMessage("information", '<?php echo $messages_p["browseByService_info_send"]; ?>', closeLightBox())
                    } else {
                        coolMessage("error", '<?php echo $messages_p["general_error_send_short"]; ?>')
                    }
                }
            });
        } else {
        	coolMessage("alert", msg)
            return false;
        }
	}

	// like button facebook
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) 
			return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=284384915038452";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	// twitter button
	!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';

		if(!d.getElementById(id)){
			js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
			fjs.parentNode.insertBefore(js,fjs);
		}
	}(document, 'script', 'twitter-wjs');

</script>
<!-- </plugin_facebook> -->

<!-- google+ -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<meta name="author" content="sebastian lara" />
<meta name="description" content="<?php echo $meta_description_value;?>" />
<meta name="keywords" content="<?php echo $meta_keywords_value;?>" />
<div id="fb-root"></div>