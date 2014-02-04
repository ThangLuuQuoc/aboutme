<?php
/**
*	banner.class.php
*	1.0
*	25/ENE/2012
*	@Copyright
*/

class Banner {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Banner (){
	}
	
	/**
	*	Función responsable de obtener las imágenes de el banner
	*/
	function getBannerImages($lang = '') {
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$imgb_name = "imgb_name";
			} elseif ($lang == "en") {
				$imgb_name = "imgb_name_e";
			}
			$query = "SELECT i.imgb_code, i.imgb_rename, i.". $imgb_name ." "
				   	. "FROM app_img_banner i ORDER BY i.imgb_code DESC;";
		} else {
			$query = "SELECT i.imgb_code, i.imgb_rename, i.imgb_name, i.imgb_name_e "
				   	. "FROM app_img_banner i ORDER BY i.imgb_code DESC;";			
		}

		$data = NULL;
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i]->imgb_code = $row["imgb_code"];
				$data[$i]->imgb_rename = $row["imgb_rename"];
				
				if ($lang == "es" || $lang == "en") {
					$data[$i]->imgb_name = $row[$imgb_name];
				} else {
					$data[$i]->imgb_name = $row['imgb_name'];
					$data[$i]->imgb_name_e = $row['imgb_name_e'];
				}
				$i++;
			}
		}
		
		return $data;
	}

	/**
	*	Función responsable de contar la cantidad de imagenes que tiene el banner.
	*/
	function countBannerImages() {
		$query = "SELECT COUNT(*) AS amount FROM app_img_banner i;";
		
		if ($result = mysql_query ($query)) {
			if($row = mysql_fetch_array ($result)) {
				return $row["amount"];	
			}
		}
		
		return 0;
	}

	/**
	*	Función responsable de validar si una imagen es o no valida.
	*/
	function isImageValid($imgb_code) {
		$query = "SELECT COUNT(*) AS amount FROM app_img_banner i "
			   . "WHERE i.imgb_code='".$imgb_code."';";
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				return $row["amount"];	
			}
		}
		
		return 0;
	}

	/**
	*	Función responsable de eliminar una imagen de una galería.
	*/
	function deleteImage($imgb_code) {
		$query = "DELETE FROM app_img_banner WHERE imgb_code=".(int) $imgb_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}

	/**
	*	Función responsable de insertar una nueva imagen para el banner publicitario.
	*/
	function insertImage($data){
		$query = "INSERT INTO app_img_banner "
			   . "(imgb_code, use_code, imgb_rename, imgb_date_create, "
			   . "imgb_original_name, imgb_width, imgb_height, imgb_name, imgb_name_e) "
			   . "VALUES (NULL, '" . $data->use_code . "', '"
			   . $data->imgb_rename . "', '" . date ("Y-m-d H:i:s") . "', '"
			   . $data->imgb_original_name . "', '" . $data->imgb_width . "', '"
			   . $data->imgb_heigh . "', '" . $data->imgb_name . "', '" . $data->imgb_name_e . "');";
		if (mysql_query ($query)) {
			return mysql_insert_id ();	
		} else { die($query);
			return false;	
		}
	}

	/**
	*	Función responsable de actuaizar la información de una imagen.
	*/
	function updateImageInfo($data) {
		$query = "UPDATE app_img_banner SET imgb_name = '" . $data->imgb_name . "',"
			   . "imgb_name_e = '" . $data->imgb_name_e . "' "
			   . "WHERE imgb_code=" . (int) $data->imgb_code . ";";

		if (mysql_query($query)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}	
}
?>