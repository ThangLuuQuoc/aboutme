<?php
/**
*	service.class.php
*	1.0
*	23/AGO/2012
*	@Copyright
*/

class Service {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Service (){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo servicio para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertService($data){
		$query = "INSERT INTO service (serv_code, sertype_code, use_code, serv_name, serv_summary, serv_description, serv_image, serv_status, serv_date_create, serv_name_e,
					 serv_summary_e, serv_description_e, serv_image_e, serv_order, serv_highlight) VALUES 
					 (NULL, '".$data->sertype_code."', '".$data->use_code."', '".$data->serv_name."', '".$data->serv_summary."', '".$data->serv_description."', 
					 '".$data->serv_image."', '".$data->serv_status."', '".date ("Y-m-d H:i:s")."', '".$data->serv_name_e."', '".$data->serv_summary_e."', 
					 '".$data->serv_description_e."', '".$data->serv_image_e."', '".$data->serv_order."', '".$data->serv_highlight."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {			
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los servicios no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de servicios
	*/
	function serviceList($search = '', $orderBy = '', $init = 0, $amount = 0, $serv_status = 0, $sertype_code=0, $lang = '') {
		$where = "";
		
		if ($search != '') {
			$where .= " AND (s.serv_name like '%".$search."%' OR s.serv_name_e like '%".$search."%') ";
		}
		
		if ((int) $serv_status > 0) {
			$where .= " AND (s.serv_status =".(int) $serv_status.") ";
		}
		
		if ((int) $sertype_code > 0) {
			$where .= " AND (s.sertype_code =".(int) $sertype_code.") ";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$serv_name = "serv_name";
				$serv_summary = "serv_summary";
				$serv_image = "serv_image";
				$sertype_name = "sertype_name";
			} elseif ($lang == "en") {
				$serv_name = "serv_name_e";
				$serv_summary = "serv_summary_e";
				$serv_image = "serv_image_e";
				$sertype_name = "sertype_name_e";
			}
			
			$query = "SELECT s.serv_code, s.".$serv_name.", s.".$serv_summary.", s.".$serv_image.", st.".$sertype_name."
						FROM service s JOIN service_type st ON s.sertype_code=st.sertype_code WHERE s.serv_status <> 3 AND st.sertype_status <> 3 ".$where." ".$orderBy;
		} else {
			$query = "SELECT s.serv_code, s.serv_name, s.serv_summary, s.serv_image, s.serv_status, s.serv_date_create, s.serv_order, s.serv_highlight, st.sertype_name
						FROM service s JOIN service_type st ON s.sertype_code=st.sertype_code WHERE s.serv_status <> 3 AND st.sertype_status <> 3 ".$where." ".$orderBy;
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->serv_code = $row['serv_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->serv_name = $row[$serv_name];
					$data[$i]->serv_summary = $row[$serv_summary];
					$data[$i]->serv_image = $row[$serv_image];
					$data[$i]->sertype_name = $row[$sertype_name];
				} else {					
					$data[$i]->serv_name = $row['serv_name'];
					$data[$i]->serv_summary = $row['serv_summary'];
					$data[$i]->serv_image = $row['serv_image'];
					$data[$i]->serv_status = $row['serv_status'];
					$data[$i]->serv_date_create = $row['serv_date_create'];
					$data[$i]->serv_order = $row['serv_order'];
					$data[$i]->serv_highlight = $row['serv_highlight'];
					$data[$i]->sertype_name = $row['sertype_name'];
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
	function countServices($search = '', $serv_status = 0, $sertype_code = 0){
		$where = '';		
		if ((int) $serv_status > 0) {
			$where .= " AND (s.serv_status =".(int) $serv_status.") ";
		}
		
		if ((int) $sertype_code > 0) {
			$where .= " AND (s.sertype_code =".(int) $sertype_code.") ";
		}
		
		if ($search != '') {
			$where .= " AND (s.serv_name like '%".$search."%' OR s.serv_name_e like '%".$search."%')";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM service s JOIN service_type st ON s.sertype_code=st.sertype_code 
					WHERE s.serv_status <> 3 AND st.sertype_status <> 3 ".$where.";";
		
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
	*	@parameter serv_code, codigo del servicio.
	*	@parameter serv_status, nuevo estado para el servicio.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($serv_code , $serv_status) {
		$query = "UPDATE service SET serv_status='".$serv_status."' WHERE serv_code=".$serv_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un servicio.
	*	@parameter serv_code, codigo del servicio.
	*	@return datos del servicio en caso de encontrarlo.
	*/
	function getService($serv_code, $lang = ''){
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$serv_name = "serv_name";
				$serv_summary = "serv_summary";
				$serv_description = "serv_description";
				$serv_image = "serv_image";
			} elseif ($lang == "en") {
				$serv_name = "serv_name_e";
				$serv_summary = "serv_summary_e";
				$serv_description = "serv_description_e";
				$serv_image = "serv_image_e";
			}
			
			$query = "SELECT s.serv_code, s.sertype_code, s.".$serv_name.", s.".$serv_summary.", s.".$serv_description.", s.".$serv_image."	FROM service s WHERE s.serv_code=".$serv_code." ";
		} else {
			$query = "SELECT s.serv_code, s.sertype_code, s.serv_name, s.serv_summary, s.serv_description, s.serv_image, s.serv_status,
						 s.serv_name_e, s.serv_summary_e, s.serv_description_e, s.serv_image_e, s.serv_highlight FROM service s WHERE s.serv_code = ".$serv_code.";";
		}
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->serv_code = $row['serv_code'];
				$data->sertype_code = $row['sertype_code'];
				
				if ($lang == "es" || $lang == "en") {
					$data->serv_name = $row[$serv_name];
					$data->serv_summary = $row[$serv_summary];
					$data->serv_description = $row[$serv_description];
					$data->serv_image = $row[$serv_image];
				} else {
					$data->serv_name = $row['serv_name'];
					$data->serv_summary = $row['serv_summary'];
					$data->serv_description = $row['serv_description'];
					$data->serv_image = $row['serv_image'];
					$data->serv_status = $row['serv_status'];
					$data->serv_name_e = $row['serv_name_e'];
					$data->serv_summary_e = $row['serv_summary_e'];
					$data->serv_description_e = $row['serv_description_e'];
					$data->serv_image_e = $row['serv_image_e'];
					$data->serv_highlight = $row['serv_highlight'];
				}
			}
		}

		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un servicio.
	*	@parameter new_data: nuevos datos para la actualización del servicio.
	*	@return boolean, resultado de la actualización
	*/	
	function updateService($new_data){
		$query = "UPDATE service SET sertype_code='".$new_data->sertype_code."', serv_name='".$new_data->serv_name."', serv_summary='".$new_data->serv_summary."',
					serv_description='".$new_data->serv_description."', serv_image='".$new_data->serv_image."', serv_status='".$new_data->serv_status."', 
					serv_name_e='".$new_data->serv_name_e."', serv_summary_e='".$new_data->serv_summary_e."', serv_description_e='".$new_data->serv_description_e."',
					serv_image_e='".$new_data->serv_image_e."', serv_highlight='".$new_data->serv_highlight."' WHERE serv_code=".(int) $new_data->serv_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			die($query." :::: ".mysql_error());
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($serv_code, $serv_order) {
		$query = "UPDATE service SET serv_order=".$serv_order." WHERE serv_code=".$serv_code.";";
		
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
	function getArrayOrders($sertype_code) {
		$query = "SELECT s.serv_order FROM service s WHERE s.serv_status <> 3 AND s.sertype_code=".(int) $sertype_code." GROUP BY s.serv_order ORDER BY s.serv_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["serv_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor maximo de orden para la secuencia.
	*/
	function getMaxOrder($sertype_code, $toOrder = false) {
		$query = "SELECT MAX(s.serv_order) AS max_value FROM service s WHERE s.serv_status <> 3 AND s.sertype_code=".(int) $sertype_code.";";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countServices('', 0, $sertype_code)) + 1);	
				}
			}
		}
		
		return $maxOrder;
	}
	
	/**
	*	Función responsable de validar si un servicio es válido o no para mostrar en la aplicación.
	*	Un servicio es válido cuando existe, está activo y el tipo al que pertenece está activo.
	*	@parameter serv_code: código del servicio a validar
	*	@return boolean, resultado de la validación del servicio.
	*/
	function isValid($serv_code) {
		$query = "SELECT COUNT(*) AS amount FROM service s JOIN service_type st ON s.sertype_code=st.sertype_code 
					WHERE s.serv_code=".$serv_code." AND s.serv_status=1 AND st.sertype_status=1;";
		
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
	*	Función responsable de destadar / dejar de destacar un servicio.
	*	@parameters sev_code: código del servicio a destacar / NO destacar.
	*				serv_highlight: 1.destacado, 2.No destacado
	*	@return resultado de la actualización
	*/
	function highlightService($serv_code, $serv_highlight){
		$query = "UPDATE service SET serv_highlight=".$serv_highlight." WHERE serv_code=".$serv_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
}
?>