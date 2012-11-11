<?php

# YouTube PHP class
# used for embedding videos as well as video screenies on web page without single line of HTML code
#
# Dedicated to my beloved brother FILIP. Rest in peace!
#
# by Avram, www.avramovic.info

/**
	Variantes para insertar videos de YouTube
	
- autoplay=1 reproduce el video automáticamente y por defecto es 0.

- fs=1 habilita la pantalla completa agregando el botón correspondiente y por defecto es 0.

- hd=1 establece la reproducción en alta definición si el video dispone de una versión de ese tipo y por defecto es 0

- rel=0 no carga ni muestra los videos relacionados una vez terminada la ejecución y por defecto es 1; además, inhabilita la búsqueda

- showsearch=0 oculta el cuadro de búsqueda y por defecto es 1

- showinfo=0 no muestra información como el título y por defecto es 1

- iv_load_policy=3 oculta las anotaciones y por defecto es 1

- cc_load_policy=1 muestra los subtítulos de forma predeterminada y por defecto es 0

	Estos otros dos parámetros, no parecen estar documentados:
	
- version=3 inserta la nueva versión del reproductor que incluye opciones distintas que pueden verse en el menú contextual cuando hacemos click con 
el boton derecho, entre ellas, copiar la URL o ver más tarde.

- modestbranding=1 elimina el botón con el logo cuando usamos un IFRAME

EJ: http://www.youtube.com/embed/xxxxxxxxxxx?fs=1&rel=0				
*/

class YouTube {

function getVideoIdFromUrl($url) {
	$parts = explode('?v=',$url);
	if (count($parts) == 2) {
		$tmp = explode('&',$parts[1]);
		if (count($tmp)>1) {
			return $tmp[0];
		} else {
			return $parts[1];
		}
	} else {
		return $url;
	}
}

function EmbedVideo($videoid,$width = 425,$height = 350) {
	$videoid = $this->getVideoIdFromUrl($videoid);
	return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$videoid.'"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/'.$videoid.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'"></embed></object>';
}

function getImg($videoid,$imgid = 1) {
	$videoid = $this->getVideoIdFromUrl($videoid);
	return "http://img.youtube.com/vi/$videoid/$imgid.jpg";
}

function showImg($videoid,$imgid = 1,$alt = 'Video screenshot') {
	return "<img src='".$this->getImg($videoid,$imgid)."' width='130' height='97' border='0' alt='".$alt."' title='".$alt."' />";
}

}

?>
