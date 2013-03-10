<?php
	session_start ();
	require_once("../includes/config.php");
	require_once("../includes/class/fileManagement.class.php");
	require_once("../includes/class/resize/imagen.class.php5");
	
	$fileObj = new fileManagement();
	$imageObj = new Imagen();	
	
	if ( isset ( $_GET['div']) && $_GET['div'] != '' ) {
		$_SESSION['div'] = $_GET['div'];
	}
	
	if ( isset ( $_GET['input_hidden']) && $_GET['input_hidden'] != '' ) {
		$_SESSION['input_hidden'] = $_GET['input_hidden'];
	}
	
	if ( isset ( $_GET['function']) && $_GET['function'] != '' ) {
		$_SESSION['function'] = $_GET['function'];
	}	
	$error = '';
	$realScale = 1;
	$w_orig = $h_orig = $scale = $x_ini = $y_ini = $w_ini = $h_ini = $w_iniAux = $h_iniAux = $strictSize = 0;//seleccionar porcion predeterminada.
	
	// $strictSize = 1; // para que las imágenes cargadas cumplan como mínimo con el tamaño especificado

	if (isset ($_GET["w_orig"]) && $_GET["w_orig"]!="")	{
		$w_orig = $_GET["w_orig"];
	}
	
	if (isset ($_GET["h_orig"]) && $_GET["h_orig"]!="")	{
		$h_orig = $_GET["h_orig"];
	}
	
	if (isset ($_GET["scale"]) && $_GET["scale"]!="") {
		$scale = $_GET["scale"];
	}
	
	if (isset ($_POST["x_ini"]) && $_POST["x_ini"]!="") {
		$x_ini = $_POST["x_ini"];
	} elseif (isset($_GET["x_ini"]) && $_GET["x_ini"]!="")	{
		$x_ini = $_GET["x_ini"];
	}
	
	if (isset ($_POST["y_ini"]) && $_POST["y_ini"]!="") {
		$y_ini = $_POST["y_ini"];
	} elseif(isset($_GET["y_ini"]) && $_GET["y_ini"]!="") {
		$y_ini = $_GET["y_ini"];
	}
	
	if (isset ($_POST["w_ini"]) && $_POST["w_ini"]!="") {
		$w_ini = $_POST["w_ini"];
	} elseif(isset($_GET["w_ini"]) && $_GET["w_ini"]!="") {
		$w_ini = $_GET["w_ini"];
	}
	
	if (isset ($_POST["h_ini"]) && $_POST["h_ini"]!="") {
		$h_ini = $_POST["h_ini"];
	} elseif (isset($_GET["h_ini"]) && $_GET["h_ini"]!="") {
		$h_ini = $_GET["h_ini"];
	}

	if (isset ($_POST["strictSize"]) && $_POST["strictSize"]!="") {
		$strictSize = $_POST["strictSize"];
	} elseif (isset($_GET["strictSize"]) && $_GET["strictSize"]!="") {
		$strictSize = $_GET["strictSize"];
	}
	
	if (isset ($_GET["h_iniAux"]) && $_GET["h_iniAux"]!="") {
		$h_iniAux = $_GET["h_iniAux"];
	}
	
	if (isset($_GET["w_iniAux"]) && $_GET["w_iniAux"]!="") {
		$w_iniAux = $_GET["w_iniAux"];
	}
	
	if (isset ($_POST["realScale"]) && $_POST["realScale"] != "") {
		$realScale = $_POST["realScale"];
	} elseif (isset($_GET["realScale"]) && $_GET["realScale"]!="") {
		$realScale = $_GET["realScale"];
	}
	
	/*
	* Copyright (c) 2008 http://www.webmotionuk.com
	* "PHP & Jquery image upload & crop"
	* Date: 2008-05-15
	* Ver 1.0
	* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
	* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
	*
	* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
	* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
	* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
	* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
	* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
	* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
	* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
	* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
	* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	*
	* http://www.opensource.org/licenses/bsd-license.php
	*/
	
	//Constants
	//You can alter these options
	$upload_dir = "upload_jcrop";// The directory for the images to be saved in
	$upload_path = $upload_dir."/";// The path to where the image will be saved
	$upload_path_dir = "../file_upload/images_bank";// Repositorio donde quedara la imagen real
	$upload_path_thum = $upload_path_dir."/";// Repositorio donde quedara la imagen real

	if (isset($_GET["large_image_name"])) {
		$large_image_name = $_GET["large_image_name"];
	} else {
		$large_image_name = date("U").mt_rand().".jpg";	
	}
	
	$thumb_image_name = date("U").mt_rand().".jpg";// New name of the thumbnail image
	$thumb_image_name_session = $thumb_image_name;
	$mb_max = 3;
	$max_file = (1148576 * $mb_max);// Approx 3MB
	$max_width = 1024;// Max width allowed for the large image	
	if (isset ($_SESSION['max_width']) && (int) $_SESSION['max_width'] > $max_width) {
		$max_width = (int) $_SESSION['max_width'];
	}
	
	$thumb_width = "100";// Width of thumbnail image
	$thumb_height = "100";// Height of thumbnail image
	//Image functions
	//You do not need to alter these functions
	function resizeImage($image,$width,$height,$scale) {
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$source = imagecreatefromjpeg($image);
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		imagejpeg($newImage,$image,100);
		chmod($image, 0777);
		return $image;
	}
	//You do not need to alter these functions
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale,$newImageWidth,$newImageHeight){		
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$source = imagecreatefromjpeg($image);
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		imagejpeg($newImage,$thumb_image_name,100);
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}
	//You do not need to alter these functions
	function getHeight($image) {
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}
	//You do not need to alter these functions
	function getWidth($image) {
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
	}
	
	//Image Locations
	$large_image_location = $upload_path.$large_image_name;
	$thumb_image_location = $upload_path_thum.$thumb_image_name;//upload_jcrop
	
	//Create the upload directory with the right permissions if it doesn't exist
	if(!is_dir($upload_dir)){
		mkdir($upload_dir, 0777);
		chmod($upload_dir, 0777);		
	}
	
	//Create the upload directory with the right permissions if it doesn't exist
	if(!is_dir($upload_path_dir)){
		mkdir($upload_path_dir, 0777);
		chmod($upload_path_dir, 0777);
		
		mkdir($upload_path_dir."/620x320", 0777);
		chmod($upload_path_dir."/620x320", 0777);		
	}
	
	if (isset ( $_POST["upload_image"]) && $_POST["upload_image"] == 1) {
		if ( isset ($_GET["large_image_name"]) && file_exists ($upload_path.$_GET["large_image_name"])) {
			unlink ($upload_path.$_GET["large_image_name"]);
		}
				
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$userfile_size = $_FILES['image']['size'];
		$filename = basename($_FILES['image']['name']);
		$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
		
		//Only process if the file is a JPG and below the allowed limit
		if ((! empty ($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
			if ( $userfile_size > $max_file )
				$error = replaceMessage($messages["validationJcrop_masxSize"], array($mb_max.' Mb'))."<br />";
			if ( ! ( $file_ext=="jpg" ) )
				$error = $messages["validationJcrop_format"]."<br />";
		} else {
			$error= $messages["validationJcrop_selectImage"]."<br />";
		}
		
		//Everything is ok, so we can upload the image.
		if (strlen ( $error ) == 0) {
			if ( isset ( $_FILES['image']['name'] ) ) {
				$new_image_name = date("U").mt_rand();
				$large_image_name = $new_image_name.'.'.$file_ext;
				$large_image_location = $upload_path.$large_image_name;
				move_uploaded_file ( $userfile_tmp, $large_image_location );
				chmod($large_image_location, 0777);
				
				$width = getWidth($large_image_location);
				$height = getHeight($large_image_location);
								
				if ($w_ini == 0 && $h_ini == 0) {
					$w_ini = $width;
					$h_ini = $height;
				}
				
				//Scale the image if it is greater than the width set above
				$scaleIni = 1;
				if ($width < $w_ini) {
					$scaleIni = ($width / $w_ini);
				}
				
				if ($height < $h_ini) {
					$aux = ($width / $w_ini);
					if ($aux < $scaleIni) {
						$scaleIni = $aux;
					}
				}
				
				$w_iniAux = ceil ($w_ini * $scaleIni);
				$h_iniAux = ceil ($h_ini * $scaleIni);				
				
				if ($width > $max_width){
					$scale = ($max_width / $width);
				} else {
					$scale = 1;					
				}
				
				$uploaded = resizeImage($large_image_location, $width, $height, $scale);
			}
			//Refresh the page to show the new uploaded image
			header("location:".$_SERVER["PHP_SELF"]."?x_ini=".$x_ini."&y_ini=".$y_ini
				."&w_ini=".$w_ini."&h_ini=".$h_ini."&w_iniAux=".$w_iniAux."&h_iniAux="
				.$h_iniAux."&reload=1&w_orig=".$width."&h_orig=".$height."&scale="
				.$scale."&large_image_name=".$large_image_name."&realScale="
				.$realScale . "&strictSize=" . $strictSize);
			exit();
		}
	} elseif (isset ($_POST["upload_thumbnail"])) {
		//Get the new coordinates to crop the image.
		$x 		= $_POST["x"];
		$y 		= $_POST["y"];
		$x2 	= $_POST["x2"];
		$y2 	= $_POST["y2"];
		$w 		= $_POST["w"];
		$h 		= $_POST["h"];
				
		//si la imagen trae un tamaño inicial para redimencionar, debe quedar de ese tamaño.		
		$newImageWidth = $w;
		$newImageHeight = $h;
		if($w_ini > 0)
			$newImageWidth = $w_ini;
		if($h_ini > 0)
			$newImageHeight = $h_ini;
		
		//Scale the image to the thumb_width set above
		$scale = $thumb_width/$w;
		//Redimenciona la imagen seleccionada desde con el jcrop.
		
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location, $w, $h, $x, $y, $scale, ceil ($newImageWidth * $realScale), ceil ($newImageHeight * $realScale));		
		
		@unlink($large_image_location);
		if(isset($_SESSION['div']) && $_SESSION['div'] != '') {
			if ( file_exists ($upload_path.$thumb_image_name_session)) {
				unlink ($upload_path.$thumb_image_name_session);	
			}
			echo "<script>parent.chargerImage('".$thumb_image_name_session."', '".$_SESSION['input_hidden']."', '".$_SESSION['div']."');</script>";
		} 
		elseif (! empty ($_SESSION["function"])) {
			if ( file_exists ($upload_path.$thumb_image_name_session)) {
				unlink ($upload_path.$thumb_image_name_session);	
			}
			echo "<script>parent.".$_SESSION["function"]."('".$thumb_image_name_session."');</script>";
		} else {
			echo "<script> parent.close_fancy();</script>";			
		}
	} else {
		unset($_SESSION["large_image_name"]);
	}
	
	//Check to see if any images with the same names already exist
	//if (file_exists($large_image_location)){
	if (isset($_GET['reload']) && $_GET['reload'] == 1) {//Significa que viene de cargar la imagen.
		if(file_exists($thumb_image_location)){
			$thumb_photo_exists = "<img src=\"".$upload_path_thum.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
		}else{
			$thumb_photo_exists = "";
		}
		$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
	} else {
		$large_photo_exists = "";
		$thumb_photo_exists = "";
	}		
?>