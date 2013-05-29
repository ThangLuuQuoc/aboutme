<?php
/**
*	serviceType.class.php
*	1.0
*	23/AGO/2012
*	@Copyright
*/

class ServiceType {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function ServiceType (){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo tipo de servicio para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertServiceType($data){
		$query = "INSERT INTO service_type (sertype_code, sertype_name, sertype_status, sertype_name_e, sertype_order) VALUES 
					(NULL, '".$data->sertype_name."', '".$data->sertype_status."', '".$data->sertype_name_e."', '".$data->sertype_order."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los tipos de servicios no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de tipos de servicio
	*/
	function serviceTypeList($search = '', $orderBy = '', $init = 0, $amount = 0, $sertype_status = 0, $onlyActives = false, $lang = '') {
		$where = "";
				
		if ($search != '') {
			$where .= " AND (s.sertype_name like '%".$search."%' OR s.sertype_name_e like '%".$search."%')";
		}
		
		if ((int) $sertype_status > 0) {
			$where .= " AND (s.sertype_status =".(int) $sertype_status.") ";
		}
		
		if ($onlyActives) {
			$where .= " AND s.sertype_code IN (SELECT s.sertype_code FROM service s WHERE s.serv_status=1) ";	
		}
			
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$sertype_name = "sertype_name";
			} elseif ($lang == "en") {
				$sertype_name = "sertype_name_e";
			}
			
			$query = "SELECT s.sertype_code, s.".$sertype_name." FROM service_type s WHERE s.sertype_status <> 3 " . $where . " " . $orderBy;
			
			
		} else {//ser_status
			$query = "SELECT s.sertype_code, s.sertype_name, s.sertype_status, s.sertype_order, s2.amount_sertype_actives FROM
						(SELECT s.sertype_code, s.sertype_name, s.sertype_status, s.sertype_order FROM service_type s WHERE s.sertype_status <> 3 ".$where." ".$orderBy.") s
					LEFT JOIN (SELECT s.sertype_code, COUNT(*) AS amount_sertype_actives FROM service s WHERE s.serv_status<>3 GROUP BY s.sertype_code) s2
					ON s.sertype_code=s2.sertype_code ";
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->sertype_code = $row['sertype_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->sertype_name = $row[$sertype_name];
				} else {
					$data[$i]->sertype_name = $row['sertype_name'];
					$data[$i]->sertype_status = $row['sertype_status'];
					$data[$i]->sertype_order = $row['sertype_order'];
					$data[$i]->amount_sertype_actives = $row['amount_sertype_actives'];
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
	function countServicesType($search = '', $sertype_status = 0, $onlyActives = false){		
		$where = '';
		
		if ($search != '') {
			$where .= " AND (s.sertype_name like '%".$search."%' OR s.sertype_name_e like '%".$search."%')";
		}
		
		if ((int) $sertype_status > 0) {
			$where .= " AND (s.sertype_status =".(int) $sertype_status.") ";
		}
		
		if ($onlyActives) {
			$where .= " AND s.sertype_code IN (SELECT s.sertype_code FROM service s WHERE s.serv_status=1) ";	
		}
		
		$query = "SELECT COUNT(*) AS amount FROM service_type WHERE sertype_status <> 3 ".$where.";";
		
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
	*	@parameter sertype_code, codigo del tipo de servicio.
	*	@parameter sertype_status, nuevo estado para el tipo de servicio.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($sertype_code , $sertype_status) {
		$query = "UPDATE service_type SET sertype_status='".$sertype_status."' WHERE sertype_code=".$sertype_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un tipo de servicio.
	*	@parameter sertype_code, codigo del tipo de servicio.
	*	@return datos del tipo de servicio en caso de encontrarlo.
	*/
	function getServiceType($sertype_code, $lang = ''){
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$sertype_name = "sertype_name";
			} elseif ($lang == "en") {
				$sertype_name = "sertype_name_e";
			}
			
			$query = "SELECT s.sertype_code, s.".$sertype_name." FROM service_type s WHERE s.sertype_code=".$sertype_code.";";
		} else {
			$query = "SELECT s.sertype_code, s.sertype_name, s.sertype_status, s.sertype_name_e, s.sertype_order 
					FROM service_type s WHERE sertype_code = ".$sertype_code.";";
		}
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->sertype_code = $row['sertype_code'];
				if ($lang == "es" || $lang == "en") {
					$data->sertype_name = $row[$sertype_name];
				} else {
					$data->sertype_name = $row['sertype_name'];
					$data->sertype_status = $row['sertype_status'];
					$data->sertype_name_e = $row['sertype_name_e'];
					$data->sertype_order = $row['sertype_order'];
				}
			}
		}
	
		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un tipo de servicio.
	*	@parameter new_data: nuevos datos para la actualización del tipo de servicio.
	*	@return boolean, resultado de la actualización
	*/	
	function updateServiceType($new_data){
		$query = "UPDATE service_type SET sertype_name = '".$new_data->sertype_name."', sertype_status = '".$new_data->sertype_status."',
					sertype_name_e= '".$new_data->sertype_name_e."' WHERE sertype_code =".$new_data->sertype_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($sertype_code, $sertype_order) {
		$query = "UPDATE service_type SET sertype_order=".(int) $sertype_order." WHERE sertype_code=".(int) $sertype_code.";";
		
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
		$query = "SELECT s.sertype_order FROM service_type s WHERE s.sertype_status <> 3 GROUP BY s.sertype_order ORDER BY s.sertype_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["sertype_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(s.sertype_order) AS max_value FROM service_type s WHERE s.sertype_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countServicesType()) + 1);	
				}
			}
		}
		
		return $maxOrder;
	}
	
	/**
	*	Función responsable de validar si un tipo de servicio es válido o no para mostrar en la aplicación.
	*	Un tipo de servicio es válido cuando existe y está activo.
	*	@parameter sertype_code: código del tipo de servicio a validar
	*	@return boolean, resultado de la validación.
	*/
	function isValid($sertype_code) {
		$query = "SELECT COUNT(*) AS amount FROM service_type s WHERE s.sertype_code=".$sertype_code." AND s.sertype_status=1;";
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
	*	Funcion responsable de validar si un tipo de servicio es válido para eliminar, 
	*	un tipo de servicio válido para eliminar es aquel no tiene servicios activos o inactivos.
	*/
	function validateRemove($sertype_code) {
		$response = false;
		$query = "SELECT COUNT(*) AS amount FROM service s WHERE s.sertype_code=".$sertype_code." AND s.serv_status <> 3";
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$response = $row['amount'];
			}
		}
		
		return $response;	
	}
}
?>