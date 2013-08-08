<?php
/**
*	gallery.class.php
*	1.0
*	03/SEP/2012
*	@Copyright
*/

class Gallery {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Gallery (){
	}
	
	/**
	*	Funcion responsable de insertar una nueva galería para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertGallery($data){
		$query = "INSERT INTO gallery (gall_code, use_code, gall_name, gall_description, gall_date_create, gall_status, gall_name_e, gall_description_e, gall_order) 
					VALUES (NULL, '".$data->use_code."', '".$data->gall_name."', '".$data->gall_description."', '".date ("Y-m-d H:i:s")."', '".$data->gall_status."',
					'".$data->gall_name_e."', '".$data->gall_description_e."', '".$data->gall_order."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
	
	/**
	*	Función responsable de listar las galerías no eliminadas de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de galerías
	*/
	function galleriesList($search = '', $orderBy = '', $init = 0, $amount = 0, $gall_status = 0, $lang = '') {
		$where = "";
		
		if ($search != '') {
			$where .= " AND (g.gall_name like '%".$search."%')";
		}
		
		if ((int) $gall_status > 0) {
			$where .= " AND (g.gall_status =".(int) $gall_status.") ";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$gall_name = "gall_name";
				$img_name = "img_name";
			} elseif ($lang == "en") {
				$gall_name = "gall_name_e";
				$img_name = "img_name_e";
			}			
			$query = "SELECT g.gall_code, g.img_code, g.".$gall_name.", g.img_rename, g2.amount_images FROM
					(SELECT g.gall_code, g.img_code, g.".$gall_name.", i.img_rename FROM gallery g LEFT JOIN image i ON g.img_code=i.img_code 
						WHERE g.gall_status <> 3 ".$where." ".$orderBy.") g LEFT JOIN (SELECT i.gall_code, count(*) as amount_images FROM image i GROUP BY i.gall_code) g2
					ON g.gall_code=g2.gall_code ";
		} else {
			$query = "SELECT g.gall_code, g.img_code, g.gall_name, g.gall_date_create, g.gall_status, g.gall_order, i.img_rename, i.img_name FROM gallery g 
						LEFT JOIN image i ON g.img_code=i.img_code WHERE g.gall_status <> 3 ".$where." ".$orderBy;
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->gall_code = $row['gall_code'];
				$data[$i]->img_code = $row['img_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->gall_name = $row[$gall_name];
					$data[$i]->amount_images = $row['amount_images'];
				} else {
					$data[$i]->gall_name = $row['gall_name'];
					$data[$i]->gall_date_create = $row['gall_date_create'];
					$data[$i]->gall_status = $row['gall_status'];
					$data[$i]->gall_order = $row['gall_order'];
					$data[$i]->img_name = $row['img_name'];
				}
				$data[$i]->img_rename = $row['img_rename'];
				$i++;
			}
		}
		
		return $data;
	}		
	
	/**
	*	Funcion responsable de contar los registros obtenidos para la lista.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@return int, cantidad de registros de la lista
	*/
	function countGalleries($search = '', $gall_status = 0){		
		$where = '';
		
		if ($search != '') {
			$where .= " AND (g.gall_name like '%".$search."%')";
		}
		
		if ((int) $gall_status > 0) {
			$where .= " AND (g.gall_status =".(int) $gall_status.") ";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM gallery g WHERE g.gall_status <> 3 ".$where.";";
		
		$amount = 0;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$amount = $row['amount'];
			}
		}
		
		return $amount;
	}
		
	/**
	*	Funcion encargada de cambiar el estado de un item de la lista
	*	@parameter gall_code, codigo de la galería.
	*	@parameter gall_status, nuevo estado para la galería.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($gall_code , $gall_status) {
		$query = "UPDATE gallery SET gall_status='".$gall_status."' WHERE gall_code=".$gall_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de una galería.
	*	@parameter gall_code, codigo de la galería.
	*	@return datos de la galería en caso de encontrarla.
	*/
	function getGallery($gall_code, $lang = ''){
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$gall_name = "gall_name";
				$gall_description = "gall_description";
			} elseif ($lang == "en") {
				$gall_name = "gall_name_e";
				$gall_description = "gall_description_e";
			}
			
			$query = "SELECT g.gall_code, g.img_code, g.".$gall_name.", g.".$gall_description." FROM gallery g WHERE g.gall_code=".$gall_code.";";
		} else {
			$query = "SELECT g.gall_code, g.img_code, g.gall_name, g.gall_description, g.gall_status, g.gall_name_e, g.gall_description_e
					FROM gallery g WHERE g.gall_code = ".$gall_code.";";
		}
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->gall_code = $row['gall_code'];
				$data->img_code = $row['img_code'];
				if ($lang == "es" || $lang == "en") {
					$data->gall_name = $row[$gall_name];
					$data->gall_decription = $row[$gall_description];
				} else {
					$data->gall_name = $row['gall_name'];
					$data->gall_description = $row['gall_description'];
					$data->gall_status = $row['gall_status'];
					$data->gall_name_e = $row['gall_name_e'];
					$data->gall_description_e = $row['gall_description_e'];
				}
			}
		}
	
		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a una galería.
	*	@parameter new_data: nuevos datos para la actualización de la galería.
	*	@return boolean, resultado de la actualización
	*/	
	function updateGallery($new_data){
		$query = "UPDATE gallery SET gall_name = '".$new_data->gall_name."', gall_name= '".$new_data->gall_name."', 
					gall_description= '".$new_data->gall_description."', gall_status= '".$new_data->gall_status."', gall_name_e='".$new_data->gall_name_e."',
					gall_description_e= '".$new_data->gall_description_e."' WHERE gall_code=".$new_data->gall_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($gall_code, $gall_order) {
		$query = "UPDATE gallery SET gall_order=".(int) $gall_order." WHERE gall_code=".(int) $gall_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de obtener los valores que has sido usados para ordenar los items del listado.
	*	@return array, lista con los orders que se han usado para los items del listado.
	*/
	function getArrayOrders() {
		$query = "SELECT g.gall_order FROM gallery g WHERE g.gall_status <> 3 GROUP BY g.gall_order ORDER BY g.gall_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["gall_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(g.gall_order) AS max_value FROM gallery g WHERE g.gall_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countGalleries()) + 1);
				}
			}
		}
		
		return $maxOrder;
	}
	
	/**
	*	Función responsable de validar si una galería es válidoao no para mostrar en la aplicación.
	*	Una galería es válida cuando existe y está activa.
	*	@parameter gall_code: código de la galería a validar.
	*	@return boolean, resultado de la validación.
	*/
	function isValid($gall_code) {
		$query = "SELECT COUNT(*) AS amount FROM gallery g WHERE g.gall_code=".$gall_code." AND g.gall_status=1;";
		$amount = false;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result))	{
				$amount = $row["amount"];				
			}
		}
		
		if ($amount == 1) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Función responsable de actualizar la imagen de portada para la galería.
	*/
	function updateGalleryFront($data) {
		$query = "UPDATE gallery SET img_code='".$data->img_code."' WHERE gall_code=".(int) $data->gall_code.";";	
		
		if (mysql_query ($query)) {
			return true;	
		} else {
			return false;	
		}
	}
	
	/**
	*	Función responsable de insertar una nueva imagen para una galería.
	*/
	function insertImage($data){
		$query = "INSERT INTO image "
			   . "(img_code, gall_code, use_code, img_rename, img_date_create, "
			   . "img_original_name, img_width, img_high, img_name, img_name_e, "
			   . "img_description, img_description_e) "
			   . "VALUES (NULL, '" . $data->gall_code . "', '" . $data->use_code . "', '"
			   . $data->img_rename . "', '" . date ("Y-m-d H:i:s") . "', '"
			   . $data->img_original_name . "', '" . $data->img_width . "', '"
			   . $data->img_high . "', '" . $data->img_name . "', '" . $data->img_name_e
			   . "', '" . $data->img_description . "', '" . $data->img_description_e . "');";
		if (mysql_query ($query)) {
			return mysql_insert_id ();	
		} else {
			return false;	
		}
	}

	/**
	*	Función responsable de actuaizar la información de una imagen para una galería.
	*/
	function updateImageInfo($data) {
		$query = "UPDATE image SET img_name = '" . $data->img_name . "',"
			   . "img_name_e = '" . $data->img_name_e . "' "
			   . "WHERE img_code=" . (int) $data->img_code . ";";

		if (mysql_query($query)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	*	Función responsable de listar las imagenes de una galería
	*/
	function getGalleryImages($gall_code, $lang = '') {
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$img_name = "img_name";
			} elseif ($lang == "en") {
				$img_name = "img_name_e";
			}
			$query = "SELECT i.img_code, i.img_rename, i.". $img_name ." "
				   	. "FROM image i WHERE i.gall_code=".(int) $gall_code." ORDER BY i.img_code DESC;";
		} else {
			$query = "SELECT i.img_code, i.img_rename, i.img_name, i.img_name_e "
				   	. "FROM image i WHERE i.gall_code=".(int) $gall_code." ORDER BY i.img_code DESC;";			
		}

		$data = NULL;
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i]->img_code = $row["img_code"];
				$data[$i]->img_rename = $row["img_rename"];
				
				if ($lang == "es" || $lang == "en") {
					$data[$i]->img_name = $row[$img_name];
				} else {
					$data[$i]->img_name = $row['img_name'];
					$data[$i]->img_name_e = $row['img_name_e'];
				}
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de contar la cantidad de imagenes que tiene una galería.	
	*/
	function countGalleryImages($gall_code) {
		$query = "SELECT COUNT(*) AS amount FROM image i WHERE i.gall_code=".(int) $gall_code.";";
		
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
	function isImageValid($gall_code, $img_code) {
		$query = "SELECT COUNT(*) AS amount FROM image i WHERE i.img_code='".$img_code."' AND i.gall_code='".$gall_code."';";
		
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
	function deleteImageGallery($img_code) {
		$query = "DELETE FROM image WHERE img_code=".(int) $img_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {die($query);
			return false;	
		}
	}
}
?>