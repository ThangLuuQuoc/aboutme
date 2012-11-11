<?php
/**
*	video.class.php
*	1.0
*	13/SEP/2012
*	@Copyright
*/

class Video {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Video (){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo video para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertVideo($data){
		$query = "INSERT INTO video (vid_code, use_code, vid_name, vid_summary, vid_original, vid_file, vid_image, vid_date_create, vid_status, vid_type, vid_name_e,
					vid_summary_e, vid_imag_type, vid_order) VALUES (NULL, '".$data->use_code."', '".$data->vid_name."', '".$data->vid_summary."', '".$data->vid_original."', 
					'".$data->vid_file."', '".$data->vid_image."', '".date ("Y-m-d H:i:s")."', '".$data->vid_status."', '".$data->vid_type."', '".$data->vid_name_e."', 
					'".$data->vid_summary_e."', '".$data->vid_imag_type."', '".$data->vid_order."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
	
	/**
	*	Función responsable de listar los videos no eliminadas de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de videos
	*/
	function videosList($search = '', $orderBy = '', $init = 0, $amount = 0, $vid_status = 0, $lang = '') {
		$where = "";
		
		if ($search != '') {
			$where .= " AND (v.vid_name like '%".$search."%')";
		}
		
		if ((int) $vid_status > 0) {
			$where .= " AND (v.vid_status =".(int) $vid_status.") ";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$vid_name = "vid_name";
				$vid_summary = "vid_summary";
			} elseif ($lang == "en") {
				$vid_name = "vid_name";
				$vid_summary = "vid_summary";
			}
			$query = "SELECT v.vid_code, v.".$vid_name.", v.".$vid_summary.", v.vid_file, v.vid_image, v.vid_date_create, v.vid_type, v.vid_imag_type FROM video v
						WHERE v.vid_status <> 3 ".$where." ".$orderBy." ";
		} else {
			$query = "SELECT v.vid_code, v.vid_name, v.vid_summary, v.vid_file, v.vid_image, v.vid_date_create, v.vid_status, v.vid_type, v.vid_name_e, v.vid_summary_e,
						v.vid_imag_type, v.vid_order FROM video v WHERE v.vid_status <> 3 ".$where." ".$orderBy." ";
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->vid_code = $row['vid_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->vid_name = $row[$vid_name];
					$data[$i]->vid_summary = $row[$vid_summary];
					$data[$i]->vid_file = $row['vid_file'];
					$data[$i]->vid_image = $row['vid_image'];
					$data[$i]->vid_date_create = $row['vid_date_create'];
					$data[$i]->vid_type = $row['vid_type'];
					$data[$i]->vid_imag_type = $row['vid_imag_type'];
				} else {
					$data[$i]->vid_name = $row['vid_name'];
					$data[$i]->vid_summary = $row['vid_summary'];
					$data[$i]->vid_file = $row['vid_file'];
					$data[$i]->vid_image = $row['vid_image'];
					$data[$i]->vid_date_create = $row['vid_date_create'];
					$data[$i]->vid_status = $row['vid_status'];
					$data[$i]->vid_type = $row['vid_type'];
					$data[$i]->vid_name_e = $row['vid_name_e'];
					$data[$i]->vid_summary_e = $row['vid_summary_e'];
					$data[$i]->vid_imag_type = $row['vid_imag_type'];
					$data[$i]->vid_order = $row['vid_order'];
				}
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
	function countVideos($search = '', $vid_status = 0){		
		$where = '';
		
		if ($search != '') {
			$where .= " AND (v.vid_name like '%".$search."%')";
		}
		
		if ((int) $vid_status > 0) {
			$where .= " AND (v.vid_status =".(int) $vid_status.") ";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM video v WHERE v.vid_status <> 3 ".$where.";";
		
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
	*	@parameter vid_code, codigo del video.
	*	@parameter vid_status, nuevo estado para el video.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($vid_code , $vid_status) {
		$query = "UPDATE video SET vid_status='".$vid_status."' WHERE vid_code=".$vid_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un video.
	*	@parameter vid_code, codigo del video.
	*	@return datos del video en caso de encontrarlo.
	*/
	function getVideo($vid_code, $lang = ''){
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$vid_name = "vid_name";
				$vid_summary = "vid_summary";
			} elseif ($lang == "en") {
				$vid_name = "vid_name_e";
				$vid_summary = "vid_summary_e";
			}
			$query = "SELECT v.vid_code, v.".$vid_name.", v.".$vid_summary.", v.vid_file, v.vid_image, v.vid_date_create, v.vid_type, v.vid_imag_type FROM video v
						WHERE v.vid_code=".$vid_code.";";
		} else {
			$query = "SELECT v.vid_code, v.vid_name, v.vid_summary, v.vid_original, v.vid_file, v.vid_image, v.vid_date_create, v.vid_status, v.vid_type, v.vid_name_e,
						 v.vid_summary_e, v.vid_imag_type FROM video v WHERE v.vid_code=".$vid_code.";";
		}
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->vid_code = $row['vid_code'];
				if ($lang == "es" || $lang == "en") {
					$data->vid_name = $row[$vid_name];
					$data->vid_summary = $row[$vid_summary];
					$data->vid_file = $row['vid_file'];
					$data->vid_image = $row['vid_image'];
					$data->vid_date_create = $row['vid_date_create'];
					$data->vid_type = $row['vid_type'];
					$data->vid_imag_type = $row['vid_imag_type'];
				} else {
					$data->vid_name = $row['vid_name'];
					$data->vid_summary = $row['vid_summary'];
					$data->vid_original = $row['vid_original'];
					$data->vid_file = $row['vid_file'];
					$data->vid_image = $row['vid_image'];
					$data->vid_date_create = $row['vid_date_create'];
					$data->vid_status = $row['vid_status'];
					$data->vid_type = $row['vid_type'];
					$data->vid_name_e = $row['vid_name_e'];
					$data->vid_summary_e = $row['vid_summary_e'];
					$data->vid_imag_type = $row['vid_imag_type'];
				}
			}
		}
		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un video.
	*	@parameter new_data: nuevos datos para la actualización del video.
	*	@return boolean, resultado de la actualización
	*/	
	function updateVideo($new_data){
		$query = "UPDATE video SET vid_name='".$new_data->vid_name."', vid_summary='".$new_data->vid_summary."', vid_original='".$new_data->vid_original."', 
					vid_file='".$new_data->vid_file."', vid_image='".$new_data->vid_image."', vid_status='".$new_data->vid_status."', vid_type='".$new_data->vid_type."',
					vid_name_e='".$new_data->vid_name_e."',	vid_summary_e='".$new_data->vid_summary_e."', vid_imag_type='".$new_data->vid_imag_type."' 
					WHERE vid_code=".$new_data->vid_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($vid_code, $vid_order) {
		$query = "UPDATE video SET vid_order=".(int) $vid_order." WHERE vid_code=".(int) $vid_code.";";
		
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
		$query = "SELECT v.vid_order FROM video v WHERE v.vid_status <> 3 GROUP BY v.vid_order ORDER BY v.vid_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["vid_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(v.vid_order) AS max_value FROM video v WHERE v.vid_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countVideos()) + 1);
				}
			}
		}
		
		return $maxOrder;
	}
	
	/**
	*	Función responsable de validar si un video es válido o no para mostrar en la aplicación.
	*	Un video es válido cuando existe y está activo.
	*	@parameter vid_code: código del video a validar.
	*	@return boolean, resultado de la validación.
	*/
	function isValid($vid_code) {
		$query = "SELECT COUNT(*) AS amount FROM video v WHERE v.vid_code=".$vid_code." AND v.vid_status=1;";
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
	
}
?>