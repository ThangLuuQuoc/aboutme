<?php 
	/** Este archivo permite gestionar los estilos .css de la web de forma dinámica	*/
	
	// esta propiedad modifica el degradado del menú.
	$gradientColorMenu = "background: #439ea8;
    background: -moz-linear-gradient(top,  #439ea8 1%, #2582ed 51%, #0471ed 54%, #4e98ed 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#439ea8), color-stop(51%,#2582ed), color-stop(54%,#0471ed), color-stop(100%,#4e98ed));
    background: -webkit-linear-gradient(top,  #439ea8 1%,#2582ed 51%,#0471ed 54%,#4e98ed 100%);
    background: -o-linear-gradient(top,  #439ea8 1%,#2582ed 51%,#0471ed 54%,#4e98ed 100%);
    background: -ms-linear-gradient(top,  #439ea8 1%,#2582ed 51%,#0471ed 54%,#4e98ed 100%);
    background: linear-gradient(to bottom,  #439ea8 1%,#2582ed 51%,#0471ed 54%,#4e98ed 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#439ea8', endColorstr='#4e98ed',GradientType=0 );";

	// propiedad para modificar el color de fondo de la pestaña actual.
	$currentTabColorBackground = "#1C7CEA";

	// propiedad para modificar el color de fondo de la pestaña actual cuando le pasan el mouse por encima
	$currentTabColorBackgroundHover = "#074bea";

	// propiedad para modificar el color de una pestaña (diferente a la actal) cuando le pasan el mouse por encima.
	$gradientColorMenuAux = "background: #2c9ba5;
    background: -moz-linear-gradient(top, #2c9ba5 0%, #0070e8 52%, #0059ea 53%, #3389ea 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2c9ba5), color-stop(52%,#0070e8), color-stop(53%,#0059ea), color-stop(100%,#3389ea));
    background: -webkit-linear-gradient(top, #2c9ba5 0%,#0070e8 52%,#0059ea 53%,#3389ea 100%);
    background: -o-linear-gradient(top, #2c9ba5 0%,#0070e8 52%,#0059ea 53%,#3389ea 100%);
    background: -ms-linear-gradient(top, #2c9ba5 0%,#0070e8 52%,#0059ea 53%,#3389ea 100%);
    background: linear-gradient(to bottom, #2c9ba5 0%,#0070e8 52%,#0059ea 53%,#3389ea 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2c9ba5', endColorstr='#3389ea',GradientType=0 );";

	// propiedad para modificar el color de fondo de el texto del slider
	$sliderBackgroundColor = "#0471ed";

?>


<style type="text/css">

	/* navigator */
	#appleNav {
	    <?php echo $gradientColorMenu;?>
	}

	#appleNav li {
	    <?php echo $gradientColorMenu;?>
	}
	
	#appleNav .current {
	    background: <?php echo $currentTabColorBackground; ?>;
	}

	#appleNav .current:hover {
	    background: <?php echo $currentTabColorBackgroundHover; ?> !important;
	}

	#appleNav li:not(:last-child):hover {
	    <?php echo $gradientColorMenuAux; ?>
	}

	#appleNav li:not(:last-child):active {
	    <?php echo $gradientColorMenuAux; ?>
	}

	#appleNav li ul li:hover {
	    <?php echo $gradientColorMenuAux; ?>
	}

	#appleNav li ul li:active {
	    <?php echo $gradientColorMenuAux; ?>
	}
	/* navigator */

	/* slider */
	.nivo-caption {
		background-color: <?php echo $sliderBackgroundColor; ?>;
	}
	/* slider */
</style>