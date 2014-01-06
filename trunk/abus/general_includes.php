<link rel="shortcut icon" href="/favicon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/styleLightbox.css" type="text/css" media="screen" />
<link href='css/coolMessage.css' type='text/css' rel='stylesheet' media='screen' />
<script language="javaScript" type="text/javascript" src="js/jquery.js"></script>
<script language="javaScript" type="text/javascript" src="js/jquery.simplemodal.js"></script>
<script language="javaScript" type="text/javascript" src="js/coolMessage.js"></script>

<!-- <fancybox> -->
<link rel="stylesheet" href="js/fancybox/fancy.css" type="text/css" media="screen">
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.0.0.js"></script>
<!-- </fancybox> -->

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
	
	function get(id) {
		return document.getElementById(id);
	}
	
	jQuery (document).ready(function($) {		
		initFancy();
	});
	
	function initFancy() {
		
		$(".fancytoImage").fancybox({
			'zoomSpeedIn': 700, //Provoca el efecto al abrirse
			'zoomSpeedOut': 500, //Provoca el efecto al cerrarse.
			'overlayShow': true, // Parámetro que sirve para definir si se muestra o no el fondo oscuro.
			'overlayOpacity': 0.4 //Determina el nivel de opacidad del fondo.
		});
		
		$(".fancytoVideo").fancybox({
			'zoomSpeedIn': 700, //Provoca el efecto al abrirse
			'zoomSpeedOut': 500, //Provoca el efecto al cerrarse.
			'overlayShow': true, // Parámetro que sirve para definir si se muestra o no el fondo oscuro.
			'overlayOpacity': 0.4, //Determina el nivel de opacidad del fondo.
			'frameWidth': 840, // Ancho del reproductor.
			'frameHeight': 512, // Alto del reproductor
		});
		
		$(".fancytoJcrop").fancybox({
			'zoomSpeedIn': 700, //Provoca el efecto al abrirse
			'zoomSpeedOut': 500, //Provoca el efecto al cerrarse.
			'frameWidth': 2000, // Ancho del reproductor.
			'frameHeight': 900, // Alto del reproductor
			'overlayShow': true, // Parámetro que sirve para definir si se muestra o no el fondo oscuro.
			'overlayOpacity': 0.4 //Determina el nivel de opacidad del fondo.
		});	
	}
	
	function close_fancy() {
		$.fn.fancybox.close();
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
	
	function validateExtension(myFile, allow_extensions) {		
		if( !myFile || ! allow_extensions)
			return false;
		
		extension = (myFile.substring(myFile.lastIndexOf("."))).toLowerCase();
		allow = false;
		continue_for = true;
		for ( var i = 0; i < allow_extensions.length && continue_for; i++ ){
			if( allow_extensions[i] == extension){
				allow = true;
				continue_for = false;
			}
		}
				
		return allow;
	}
	
	function file_exists (url) {
		var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
		if (!req) {
			throw new Error('XMLHttpRequest not supported');
		}
	 
		// HEAD Results are usually shorter (faster) than GET
		req.open('HEAD', url, false);
		req.send(null);
		if (req.status == 200) {
			return true;
		}
	 
		return false;
	}
	
	function limitLength(element, idLabel, total_length) {
		var longitud = $(element).val().length;
		var resto = (total_length - longitud);
		$('#' + idLabel).html("<?php echo $messages["general_messageCharacters"];?>" + resto);
		
		if (resto <= 0) {
			$(element).attr("maxlength", total_length);
		}
	}
	
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
	
</script>