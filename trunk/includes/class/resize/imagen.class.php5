<?php 
include('cropcanvas.class.php5');
/*---------------------------------------------------------------------------------------------------
class Imagen
DESCRIPCIÓN : Su funcion es es redimensionarl las imagenes, recortar imagenes, y validar tamaño de imagenes
REQUISITOS  : Extencion php_gd2 activada en PHP y cropcanvas.class.php5
---------------------------------------------------------------------------------------------------*/


class Imagen
{

		
		private $alto;
		private $ancho;
		private $tipo;

    ///////////////////////////////////////////////////////////////////////////
	// Constructor de clase. Inicializa los atributos de la imagen.
	//
	// return: 
	// access public
	///////////////////////////////////////////////////////////////////////////////

	public function _construct()
	{
			$this->alto = "";
			$this->ancho = "";
			$this->tipo = "";
	}
	
	
	
	
	
	////////////////////////////////////////////////////////////////////
	// Funcion que retorna si el archivo contiene una imagen válida
	// Soporta imagenes jpg, bmp, gif
	//
	// parameter: URL del archivo a verificar
	// return: 1 si el archivo contiene una imagen válida
	// return: 2 si el archivo no contiene una imagen valida
	////////////////////////////////////////////////////////////////////
	public function esImagen($archivo)
	{
		$formato = mime_content_type($archivo);
		
		if ($formato == "image/gif" or	$formato == "image/jpg" or	$formato == "image/bmp"){	
			return true;
		}
		else{
			return false;
		}
	}
	
	
	
	
	 ///////////////////////////////////////////////////////////////////////////
	// obtenerPropiedadesImagen
	//
	// parameter: $origen es la ruta completa de la imagen, incluye el nombre de la image con su extencion
	// 
	// return: 
	// access public
	///////////////////////////////////////////////////////////////////////////////	
	
	public function obtenerPropiedadesImagen($origen)
	{
		// perdonen la ortografia
		$extencion = strtolower(substr($origen, -3));
					
		if ($extencion == "gif") 
		$origen1 = imagecreatefromgif($origen);

		if ($extencion == "jpg") 
		$origen1 = imagecreatefromjpeg($origen);
			
		if ($extencion == "png") 
		$origen1 = imagecreatefrompng($origen);
				 
		
		$ancho = imagesx($origen1); 
		$alto = imagesy($origen1); 
		
		
		$this->ancho = $ancho;			
		$this->alto = $alto;				
		$this->tipo = $extencion;
	}	
	
	
	///////////////////////////////////////////////////////////////////////////////
	// ValidarTamanoImg. Valida si las dimensiones de la imagen son las correctas
	//
	// parameter: $origen es la ruta completa de la imagen, incluye el nombre de la image con su extencion
	// parameter: $ancho es el ancho con el cual se desea comparar el ancho real de la imagen
	// parameter: $alto es el alto con el cual se desea comparar el alto real de la imagen
	// return: true si la imagen se debe recortar, retorna false si no se debe recortar
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
		
	function validarTamanoImg($origen,$ancho,$alto){
		$extencion = $this->tipo;						
					
		if ($extencion == "gif") 
		$origen1 = imagecreatefromgif($origen);
		
		if ($extencion == "jpg") 
		$origen1 = imagecreatefromjpeg($origen);
					
		if ($extencion == "png") 
		$origen1 = imagecreatefrompng($origen);
					 
		if(imagesx($origen1) != $ancho || imagesy($origen1)!= $alto)
			return true;
		else
			return false;	
	}
	
	///////////////////////////////////////////////////////////////////////////////
	// redimensionarImagen. Redimensiona la imagen a un tamaño especifico
	//
	// parameter: $origen es la ruta completa de la imagen
	// parameter: $ancho => Es el nuevo tamaño del ancho que se desea tenga la imagen
	// parameter: $alto => Es el nuevo tamaño del alto que se desea tenga la imagen
	// parameter: $destino => Es el destino donde quedara la imagen redimiensionada
	// parameter: $bgColor => Fondo de la imagen si en esta quedaran espacios sobrantes al ser redimiensionada por defento white - blanco
	// return: 
	// access public
	///////////////////////////////////////////////////////////////////////////////	
	
	
	public function redimensionarImagen($ancho, $alto, $origen, $destino, $bgColor="white",$pos_x=0,$pos_y=0,$newImageWidth=0,$newImageHeight=0){	  
	   $cc = new CropCanvas();
		switch($bgColor){
		
			case "blanco":
			case "white":{			
				$rojo = 255;  $verde = 255;  $azul = 255;
			}
			break;
			
			case "negro":
			case "black":{			
				$rojo = 0;  $verde = 0;  $azul = 0;
			}
			break;
			
		};
		
		$extencion = "";
		
		$this->obtenerPropiedadesImagen($origen);
			
		$tip = $this->tipo;
	
		if ($tip == "gif") 
			$origen = imagecreatefromgif($origen);
		
		if ($tip == "jpg") 
			$origen = imagecreatefromjpeg($origen); 
		
		if ($tip == "png") 
			$origen = imagecreatefrompng($origen); 
	// las dimensiones que obtiene son las del objeto cargados sus propiedades
		
		$imgAncho=  $this->ancho;
	    $imgAlto=  $this->alto;
		
		
	//	$imgAncho = imagesx($origen); 
	//	$imgAlto = imagesy($origen); 
	
		$porc = $ancho*100/$imgAncho;
	
		$tamx = $imgAncho*$porc/100;
		$tamy = $imgAlto*$porc/100;		
		

		if ($alto >= $imgAlto )
		{		
			$tamx =  floor($tamx);
			$tamy =  round($tamy);	
		}
		elseif($ancho >= $imgAncho)
		{
			$tamx =  round($tamx);
			$tamy =  floor($tamy);			
		}
		else
		{
			$tamx = round($tamx); 
			$tamy = round($tamy);
		}
		
		if($tamx > $ancho || $tamy > $alto){
			$porc = $alto*100/$imgAlto;
			$tamx = $imgAncho*$porc/100;
			$tamy = $imgAlto*$porc/100;			
		}
		
		if($tamx < $ancho){
			$x = ($ancho-$tamx)/2;
			$y=0;			
		}
		else{		
			$y = ($alto-$tamy)/2;
			$x=0;
		}
		
		if($newImageWidth > 0 && $newImageHeight > 0){
			$tamx = $newImageWidth;
			$tamy = $newImageHeight;
		}
		
		$imagentemp = @imagecreatetruecolor($tamx,$tamy) 
			or $imagentemp=imagecreate($tamx,$tamy);
		
		@imagecopyresampled($imagentemp,$origen,0,0,$pos_x,$pos_y, $tamx, $tamy, $imgAncho, $imgAlto) 
			or imagecopyresized($imagentemp,$origen,0,0,$pos_x,$pos_y, $tamx, $tamy, $imgAncho, $imgAlto);
	
		$imagen = @imagecreatetruecolor($ancho,$alto) 
			or $imagen=imagecreate($ancho,$alto);
	
		$bg = imagecolorallocate($imagen, $rojo, $verde, $azul);//color fondo
	
		imagefill( $imagen,0,0,$bg);
		imagecopy($imagen,$imagentemp,$x,$y,0,0,$tamx,$tamy);
	    
		if ($tip == "gif") 		
			imagegif($imagen, $destino); 
		else
			if ($tip == "jpg") 
				imagejpeg($imagen, $destino, 100);
			else 
				if($tip == "png")
					imagepng($imagen, $destino);
		$cc->flushImages(true);
		
		}

	///////////////////////////////////////////////////////////////////////////////
	// recortarImagen. Recorta la imagen (crop) a un tamaño especifico
	//
	// parameter: $origen es la ruta completa de la imagen
	// parameter: $ancho => Es el nuevo tamaño del ancho que se desea tenga la imagen
	// parameter: $alto => Es el nuevo tamaño del alto que se desea tenga la imagen
	// parameter: $destino => Es el destino donde quedara la imagen redimiensionada
	// parameter: $bgColor => Fondo de la imagen si en esta quedaran espacios sobrantes al ser redimiensionada por defento white - blanco
	// return: 
	// access public
	///////////////////////////////////////////////////////////////////////////////	


	function recortarImagen($ancho, $alto, $origen, $destino, $bgColor="white")
	{
		$tip = strtolower(substr($origen, -3));
		if ($tip == "gif") 
			$origen1 = imagecreatefromgif($origen);
		
		if ($tip == "jpg") 
			$origen1 = imagecreatefromjpeg($origen); 
			
		if ($tip == "png") 
			$origen1 = imagecreatefrompng($origen); 

	//	$imgAncho = imagesx($origen1); 
//		$imgAlto = imagesy($origen1); 

		$this->obtenerPropiedadesImagen($origen);
	
	
		$imgAncho=  $this->ancho;
	    $imgAlto=  $this->alto;

		
		$cc = new CropCanvas();
		
		$cc->loadImage($origen);

		$ratioAlto = $imgAlto/$alto;
		$ratioAncho = $imgAncho/$ancho;

	//	$ratioAlto = $alto/$imgAlto;
//		$ratioAncho = $ancho/$imgAncho;
		
		if($ratioAlto < $ratioAncho){			
			$cc->cropToDimensions(0, 0, round($ancho*$ratioAlto), $imgAlto);
		}
		else{
			$cc->cropToDimensions(0, 0, $imgAncho, round($alto*$ratioAncho));
		}
		
		$cc->saveImage($destino, 90);
		$cc->flushImages(true);
		$this->redimensionarImagen($ancho,$alto,$destino,$destino);
		
	} 

}

?>