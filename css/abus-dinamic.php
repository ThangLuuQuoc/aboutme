<?php 
	/** Este archivo permite gestionar los estilos .css de la web de forma dinámica	*/
	
	// esta propiedad modifica el degradado del menú.
	$gradientColorMenu = "background: #0064fc;
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIxJSIgc3RvcC1jb2xvcj0iIzAwNjRmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUyJSIgc3RvcC1jb2xvcj0iIzJmN2NjOCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjU0JSIgc3RvcC1jb2xvcj0iIzAwNjRmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM0NTkwZjkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #0064fc 1%, #2f7cc8 52%, #0064fc 54%, #4590f9 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#0064fc), color-stop(52%,#2f7cc8), color-stop(54%,#0064fc), color-stop(100%,#4590f9));
background: -webkit-linear-gradient(top,  #0064fc 1%,#2f7cc8 52%,#0064fc 54%,#4590f9 100%);
background: -o-linear-gradient(top,  #0064fc 1%,#2f7cc8 52%,#0064fc 54%,#4590f9 100%);
background: -ms-linear-gradient(top,  #0064fc 1%,#2f7cc8 52%,#0064fc 54%,#4590f9 100%);
background: linear-gradient(to bottom,  #0064fc 1%,#2f7cc8 52%,#0064fc 54%,#4590f9 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0064fc', endColorstr='#4590f9',GradientType=0 );";

	// propiedad para modificar el color de fondo de la pestaña actual.
	$currentTabColorBackground = "#0769FD";

	// propiedad para modificar el color de fondo de la pestaña actual cuando le pasan el mouse por encima
	$currentTabColorBackgroundHover = "#00305F";

	// propiedad para modificar el color de una pestaña (diferente a la actal) cuando le pasan el mouse por encima.
	$gradientColorMenuAux = "background: #0064fc;
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIxJSIgc3RvcC1jb2xvcj0iIzAwNjRmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjU0JSIgc3RvcC1jb2xvcj0iIzAwNWFmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM0NTkwZjkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #0064fc 1%, #005aff 54%, #4590f9 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#0064fc), color-stop(54%,#005aff), color-stop(100%,#4590f9));
background: -webkit-linear-gradient(top,  #0064fc 1%,#005aff 54%,#4590f9 100%);
background: -o-linear-gradient(top,  #0064fc 1%,#005aff 54%,#4590f9 100%);
background: -ms-linear-gradient(top,  #0064fc 1%,#005aff 54%,#4590f9 100%);
background: linear-gradient(to bottom,  #0064fc 1%,#005aff 54%,#4590f9 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0064fc', endColorstr='#4590f9',GradientType=0 );";

	// propiedad para modificar el color de fondo de el texto del slider
	$sliderBackgroundColor = "#0769FD";

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