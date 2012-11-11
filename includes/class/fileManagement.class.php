<?php
///////////////////////////////////////////////////////////////////////////////
// class gestionFicheros
// Su funcion es subir los ficheros que se carguen desde los campos de archivos
// REQUISITOS: Necesita la libreria pclzip.lib.php
///////////////////////////////////////////////////////////////////////////////

	class fileManagement 
	{
	
		private $nombreArchivo;
		private $nombreOriginal;
		private $tipoArchivo;
				
	///////////////////////////////////////////////////////////////////////////////
	// Constructor de clase. Inicializa los atributos de la clase.
	//
	// access public
	//
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
	
		
		public function __construct()
		{
		
			$this->nombreArchivo = "";
			$this->nombreOriginal = "";
			$this->tipoArchivo = "";
					
		
		}
	
	///////////////////////////////////////////////////////////////////////////////
	// configurarAtributoGestionArchivo
	//	para la noticia del programa.
	//
	// parameter: atributo 
	// parameter: valorAtributo
	// return: 
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
	
	
		public function configurarAtributoArchivo($atributo, $valorAtributo)
		{
				switch($atributo)
				{
					case "nombreArchivo" :	$this->nombreArchivo = $valorAtributo; break;
					case "nombreOriginal" :	$this->nombreOriginal = $valorAtributo; break;
					case "tipoArchivo" :	$this->tipoArchivo = $valorAtributo; break;
					//default : return false;
				}
		
		}
	
	
	///////////////////////////////////////////////////////////////////////////////
	// obtenerAtributoArchivo. Retorna el valor del atributo especificado.
	//
	// parameter: atributo
	// return: valor del atributo.
	// access public
	//
	///////////////////////////////////////////////////////////////////////////////
	 
		public function obtenerAtributoArchivo($atributo)
		{
				switch($atributo)
				{
					case "nombreArchivo" :	return $this->nombreArchivo; break;
					case "nombreOriginal" :	return $this->nombreOriginal; break;
					case "tipoArchivo" :	return $this->tipoArchivo; break;	
				}
		}
		
		
	///////////////////////////////////////////////////////////////////////////////
	// subirArchivo. Sube el archivo correspodiente
	//
	// parameter: $nomArchivoTemporal => Es el nombre del fichero que se genera automaticamente al subir
	// parameter: $nomArchivoOriginal => Nombre del archivo original que se desea subir
	// parameter: $pathDestino => Destino a donde se subira el archivo
	// return: true si la operación es exitosa, de lo contrario retorna false.
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////		
	public function subirArchivo($nomArchivoTemporal, $nomArchivoOriginal, $pathDestino) {
		$nomArchivo = "";
		
		if (is_uploaded_file ($nomArchivoTemporal)) {
			$nomArchivo = date ("U").mt_rand ();
			$nomExtension = explode ('.',$nomArchivoOriginal);
			$indExtension = count ($nomExtension)-1;
			$extension = strtolower ($nomExtension[$indExtension]);
			
			if (!move_uploaded_file ($nomArchivoTemporal,$pathDestino.$nomArchivo.".".$extension)) {
				return false;
			} else {
				chmod ($pathDestino.$nomArchivo.".".$extension, 0777);
				$this->nombreArchivo = $nomArchivo.".".$extension;
			}
		}
		
		return $nomArchivo.".".$extension;
	}
	
	///////////////////////////////////////////////////////////////////////////////
	// subirZip. Sube el zip correspondiente y lo descomprime
	//
	// parameter: $pathOrigen => Origen del file .zip
	// parameter: $pathDestino => Destino a donde se subira el archivo debe incluir al final el /
	// parameter: $seccion => Seccion a la cual corresponde el modulo
	// return: true si la operación es exitosa, de lo contrario retorna false.
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
	
	
	public function subirZip($pathOrigen, $pathDestino)
	
	{ // se abre la funcion
	 $nomDir = date("U").mt_rand();
	 $dirnuevo = $pathDestino.$nomDir;
	 if(!file_exists($dirnuevo))
	 {
	   //se crea el dir donde se almacenaran los archivos correspondientes al marketing
	   $creado = mkdir($dirnuevo,0777);
	  
	   if(!$creado)
       {  
	     return false;
	   }
	   else
	   {
	    //se le asignan los permisos al dir creado
	    chmod($dirnuevo,0777);
	   }
	 }else{
	   $creado = true;
	 }
	
	
	if($creado)  
	 {    
	   $j=0;
	   $k=0;
     	   
		 if(is_uploaded_file($pathOrigen))
         { 
		   $archzip=new PclZip($pathOrigen);
           $lista=$archzip->listContent($dirnuevo);
		   foreach($lista as $item)
           {
		   		$ext1= strtolower(substr($item['filename'], -3));
		   		$ext2= strtolower(substr($item['filename'], -4));
		   
		   				
				if($ext1 == "htm" || $ext2 == "html"){
					$filehtml = $item['filename'];
					$archzip->extract($dirnuevo);
					$k = $k+1;
				}
						
		   }
		
		 }
	 }   
	
	if  ($k == 1){
	
		return $nomDir."/".$filehtml;
	}else{
		
		
		@rmdir($dirnuevo);
		
		 return false;
	}
	
	
	} // cierre la funcion subirArchivoZip
	
	
	///////////////////////////////////////////////////////////////////////////////
	// conectarFTP. Toma los valores declarados en el config para establecer una conexion FTP
	//
	// return: $conexion  si la operación es exitosa, de lo contrario retorna false.
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
	
		
	 private function conectarFTP()
	 {
		 $conexion = ftp_connect(SERVIDOR_FTP,SERVIDOR_PUERTO);
		 ftp_login($conexion,SERVIDOR_LOGIN,SERVIDOR_CLAVE);
	 	 ftp_pasv($conexion,true);
		 return $conexion;
	 }
	 
	///////////////////////////////////////////////////////////////////////////////
	// subirArchivoFTP. Toma los valores declarados en el config para establecer una conexion FTP
	// parametros: directorio,  nombre archivo, nombre rem, tipo de audio
	// return: nombre del archivo creado  si la operación es exitosa, de lo contrario retorna false.
	// access public
	// Modificaciones: Se agrego tra variable que identifica el tipo de audio que
	// se quiere guardar gracias a la conexion.
	///////////////////////////////////////////////////////////////////////////////
		 
	 function subirArchivoFTP($directorio, $nomArchivoTemporal, $nombreRem, $nombreAsignado=NULL, $Tipoaudio=0)
	 {
		if( $conexion = $this->conectarFTP() )
		{		
			if($nombreAsignado == NULL)
			{
				$nomArchivo   = date("U").mt_rand();
				$nomExtension = explode('.',$nombreRem);
				$indExtension = count($nomExtension)-1;
				$extension    = strtolower($nomExtension[$indExtension]);
				$nomArchivo   = $nomArchivo.".".$extension;
				switch($Tipoaudio)
				{
					case 1: $nomArchivo = 'progarchivo_'.$nomArchivo; break;
					case 2: $nomArchivo = 'prognoti_'.$nomArchivo; break;
					case 3: $nomArchivo = 'lomejor_'.$nomArchivo; break;
					case 4: $nomArchivo = 'personaje_'.$nomArchivo; break;
					case 5: $nomArchivo = 'boletin_'.$nomArchivo; break;
					case 6: $nomArchivo = 'usuario_'.$nomArchivo; break;
					case 7: $nomArchivo = 'boletinLocal_'.$nomArchivo; break;
				}				
			}
			else
				$nomArchivo = $nombreAsignado;
			
			 $put = ftp_put( $conexion, $directorio.$nomArchivo, $nomArchivoTemporal, FTP_BINARY );
			 ftp_close($conexion);
			 
			 if( $put == true )
				return $nomArchivo;
			else
				return false;
		}
		else
			return false;
	 }
	 
	 
	 ///////////////////////////////////////////////////////////////////////////////
	// borrarArchivoFTP. Elimina un archivo del servidor ftp establecido
	// 
	// parameter: $directorioArchivo, esta cadena contiene el la ruta y nombre del
	// archivo que se eliminará del servidor.
	// return: true, en caso de que la eliminación se haya efectuado, false de lo
	// contrario o en caso de no realizarse la conexión al servidor.
	// access public
	// Modificaciones:
	///////////////////////////////////////////////////////////////////////////////
	 
	 function borrarArchivoFTP( $directorioArchivo )
	 {
	 	if( $conexion = $this->conectarFTP() )
		{
			//obtiene el nombre del archivo de la cadena directorioArchivo
			$arrayDir      = explode("/", $directorioArchivo);
			$nombreArchivo = $arrayDir[count($arrayDir)-1];
			
			//obtiene el directorio de la cadena directorioArchivo
			$i   = strrpos(substr($directorioArchivo, 0, strlen($directorioArchivo)), "/");
			$dir = substr($directorioArchivo,0,$i+1);
			
			if ($this->existeArchivoFTP( $dir, $nombreArchivo ))	
			{		
				if ( ftp_delete( $conexion, $directorioArchivo ) ) 
					return true;
				else
					return false;
			}
			ftp_close($conexion);
		}
		else
			return false;
	 }	 
	 	
	//////////////////////////////////////////////////////////////////////////////////////////
	// borrarDirectorio. Eliminar una carpeta con todos los archivos que contiene
	//
	// parameter: $directorio, Cadena que contiene el directorio a borrar con todos los
	// archivos que contiene.
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function borrarDirectorio($path) 
	{	
		if (is_dir($path)) 
		{
			if (version_compare(PHP_VERSION, '5.0.0') < 0) 
			{
				$entries = array();
				if ($handle = opendir($path)) 
				{
					while (false !== ($file = readdir($handle))) $entries[] = $file;
				
				closedir($handle);
				}
			} 
			else 
			{
				$entries = scandir($path);
				
				if ($entries === false) 
					$entries = array();
			}
				
			foreach ($entries as $entry) 
			{
				if ($entry != '.' && $entry != '..') 
				{
					$this->borrarDirectorio($path.'/'.$entry);
				}
			}
			
			return @rmdir($path);
		} 
		else 
		{
			return @unlink($path);
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// existeArchivoFTP.Verifica si un archivo existe en el directorio especificado
	//
	// parameter: $directorio, Cadena que contiene el directorio donde se buscará el archivo
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function existeArchivoFTP( $directorio, $archivo )
	{
		if( $conexion = $this->conectarFTP() )
		{
			$lista =  array();
			$lista = ftp_nlist( $conexion, $directorio );

			$cantArchivos = count($lista);
			
			for( $i = 0; $i < $cantArchivos; $i++ )
			{
				if( strstr($lista[$i], $archivo) != false )
					return true;
			}
			ftp_close($conexion);
			return false;
		}
		else
			return false;
		
	} 
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// descargarArchivoFTP. Descarga un archivo de un ftp al servidor local
	//
	// parameter: $archivoLocal, archivo donde quedará almacenado el fichero descargado.
	// parameter: $archivoServidor, archivo que se descargará.
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function descargarArchivoFTP( $archivoLocal, $archivoServidor )
	{
		if( $conexion = $this->conectarFTP() )
		{		
			if (ftp_get($conexion, $archivoLocal, $archivoServidor, FTP_BINARY)) 
				return true;
			else 
				return false;
			
			ftp_close($conexion);
		}
		else
			return false;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// listarDirectorioFTP.Verifica si un archivo existe en el directorio especificado
	//
	// parameter: $directorio, Cadena que contiene el directorio donde se buscará el archivo
	// return: lista con los directorios, false en caso contrario
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function listarDirectorioFTP( $directorio )
	{
		if( $conexion = $this->conectarFTP() )
		{
			
			$lista = ftp_nlist($conexion,"/"); 
			
			$lista =  array();
			$lista = ftp_nlist( $conexion, $directorio );

			$cantArchivos = count($lista);
			
			for( $i = 0; $i < $cantArchivos; $i++ )
			{
				echo $lista[$i]."<br>";
			}
		}
		else
			return false;
		
	} 
	
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// escribirEnArchivo. Abre un archivo especificado y escribe en él.
	//
	// parameter: $archivo, nombre del archivo.
	// parameter: $datos, informacion que se escribira en el archivo.
	// parameter: $modo, el modo de apertura del archivo, si es a+ y no existe lo crea.
	//////////////////////////////////////////////////////////////////////////////////////////
	function escribirEnArchivo( $archivo, $datos, $modo="w+" )
	{	
		if( $modo == "a+" )
			$archivo .= "tmp_".date("U").mt_rand().".tpl";
		
		$fp = fopen( $archivo, $modo ); 
		
		fwrite( $fp, $datos); 
		
		fclose($fp);
		
		return $archivo;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// leerArchivo. Abre un archivo especificado y obtiene su contenido.
	//
	// parameter: $archivo, nombre del archivo.
	// return: contenido del archivo
	//////////////////////////////////////////////////////////////////////////////////////////
	function leerArchivo( $archivo )
	{	
		$fp = fopen($archivo, "r"); 
		
		$contenido = fread($fp, filesize($archivo));
		
		fclose($fp);
		
		return $contenido;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// eliminarArchivo. elimina un archivo especificado.
	//
	// parameter: $archivo, ruta + nombre del archivo.
	// return: -1  en caso de exito, 1 en caso contrario
	//////////////////////////////////////////////////////////////////////////////////////////
	
	function eliminarArchivo( $archivo )
	{	
	  if(@unlink($archivo)==false)
	  {
	    return -1;
	  }
	  else
	  {
	    return 1;
	  }
	}
}
?>