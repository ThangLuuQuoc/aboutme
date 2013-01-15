<?php
/**
*	personal.class.php
*	1.0
*	14/JAN/2013
*	@Copyright
*/

class Personal {
		
	/**
	*	Metodo constructor de la clase
	*/	
	function Personal (){
	
	}
	

	/**
	*	Funcion responsable de insertar un nuevo miembro al personal
	*	@return boolean, resultado de la inserción
	*/
	function insertPersonal($data) {
		$query = "INSERT INTO personal (pers_code, pers_name, pers_lastname, "
			   . "pers_profesional_objetive, pers_photo_original, pers_photo_rename, "
			   . "pers_status, pers_order) "
			   . "VALUES (NULL, '" . $data->pers_name . "', '" . $data->pers_lastname . "', "
			   . "'" . $data->pers_profesional_objetive . "', '" . $data->pers_photo_original . "', 
			   . '" . $data->pers_photo_rename . "', '" . $data->pers_status . "', '" . $data->pers_order . "');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			die($query. ' ' . mysql_error ());
			return false;
		}
	}
		
	/**
	*	Función responsable de listar el personal no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista del personal
	*/
	function personalList($search = '', $orderBy = '', $init = 0, $amount = 0, 
			$pers_status = 0, $chg_code=0, $lang = '') {
		$where       = '';
		$whereCharge = '';
				
		if ($search != '') {
			$where = " AND (c.pers_name like '%".$search."%' "
				   . "OR c.pers_lastname like '%".$search."%') ";
		}

		if ((int) $pers_status > 0) {
			$where .= " AND (p.pers_status =".(int) $pers_status.") ";
		}

		if ((int) $chg_code > 0) {
			$whereCharge = " AND (c.chg_code =".(int) $chg_code.") ";
		}

		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$gall_name = "chg_name";
			} elseif ($lang == "en") {
				$gall_name = "chg_name_e";
			}
		}
		
		$query = "SELECT c." . $chg_name . ", p.pers_code, p.pers_name, p.pers_lastname, "
			   . "pers_photo_rename, p.pers_status, p.pers_order "
			   . "FROM "
			   . "(SELECT c." . $chg_name . ", c.chg_order, cp.pers_code "
			   . "FROM charge c "
			   . "JOIN charge_personal cp "
			   . "ON c.chg_code=cp.chg_code "
			   . "WHERE c.chg_status<>3 " . $whereCharge . ") c "
			   . "JOIN personal p "
			   . "ON c.pers_code=p.pers_code "
			   . "WHERE p.pers_status <> 3 "
			   . $where
			   . $orderBy;
		
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->chg_name 		 = $row[$chg_name];
				$data[$i]->pers_code 		 = $row['pers_code'];
				$data[$i]->pers_name 		 = $row['pers_name'];
				$data[$i]->pers_lastname 	 = $row['pers_lastname'];
				$data[$i]->pers_photo_rename = $row['pers_photo_rename'];
				$data[$i]->pers_status 		 = $row['pers_status'];
				$data[$i]->pers_order 		 = $row['pers_order'];
				
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
	function countPersonal($search = '', $pers_status = 0, $chg_code=0) {
		$where       = '';
		$whereCharge = '';
		
		if ($search != '') {
			$where = " AND (c.pers_name like '%".$search."%' "
				   . "OR c.pers_lastname like '%".$search."%') ";
		}

		if ((int) $pers_status > 0) {
			$where .= " AND (p.pers_status =".(int) $pers_status.") ";
		}

		if ((int) $chg_code > 0) {
			$whereCharge = " AND (c.chg_code =".(int) $chg_code.") ";
		}
		
		$query = "SELECT COUNT(*) AS amount "
			   . "FROM "
			   . "(SELECT c.chg_code, cp.pers_code "
			   . "FROM charge c "
			   . "JOIN charge_personal cp "
			   . "ON c.chg_code=cp.chg_code "
			   . "WHERE c.chg_status<>3 " . $whereCharge . ") c. "
			   . "JOIN personal p "
			   . "ON c.pers_code=p.pers_code "
			   . "WHERE p.pers_status <> 3 "
			   . $where;
		
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
	*	@parameter pers_code, codigo del personal.
	*	@parameter pers_status, nuevo estado para el personal.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($pers_code , $pers_status) {
		$query = "UPDATE charge SET pers_status='" . $pers_status . "' WHERE pers_code=" . $pers_code . ";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un personal.
	*	@parameter pers_code, codigo del personal.
	*	@return datos del personal en caso de encontrarlo.
	*/
	function getPersonal($pers_code){		
		$query = "SELECT p.pers_code, c.chg_name, c.chg_name_e, c.chg_status
				FROM charge c WHERE c.pers_code = ".$pers_code.";";

		$query = "SELECT p.pers_code, p.pers_name, p.pers_lastname, "
			   . "p.pers_profesional_objetive, p.pers_photo_original, p.pers_photo_rename, "
			   . "p.pers_status, p.pers_order "
			   . "FROM personal p "
			   . "WHERE p.pers_code=" . (int) $pers_code . ";";
				
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->pers_code 				 = $row['pers_code'];
				$data->pers_name 				 = $row['pers_name'];
				$data->pers_lastname 			 = $row['pers_lastname'];
				$data->pers_profesional_objetive = $row['pers_profesional_objetive'];
				$data->pers_photo_original 		 = $row['pers_photo_original'];
				$data->pers_photo_rename 		 = $row['pers_photo_rename'];
				$data->pers_status 				 = $row['pers_status'];
				$data->pers_order 			     = $row['pers_order'];
			}
		}
	
		return $data;
	}
	

	/**
	*	Función responsable de actualizar un personal.
	*	@parameter new_data: nuevos datos para la actualización.
	*	@return boolean, resultado de la actualización
	*/	
	function updatePersonal($new_data){
		$query = "UPDATE personal SET pers_name='" . $data->pers_name . "', "
			   . "pers_lastname='" . $data->pers_lastname . "', "
			   . "pers_profesional_objetive='" . $data->pers_profesional_objetive . "', "
			   . "pers_photo_original='" . $data->pers_photo_original . "', "
			   . "pers_photo_rename='" . $data->pers_photo_rename . "', "
			   . "pers_status='" . $data->pers_status . "' "
			   . "WHERE pers_code=" . (int) $new_data->pers_code;

		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($pers_code, $pers_order) {
		$query = "UPDATE personal SET pers_order=".(int) $pers_order." WHERE pers_code=".(int) $pers_code.";";
		
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
		$query = "SELECT p.pers_order "
			   . "FROM personal p "
			   . "WHERE p.pers_status <> 3 "
			   . "GROUP BY p.pers_order "
			   . "ORDER BY c.pers_order;";

		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["pers_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(p.pers_order) AS max_value FROM personal WHERE p.pers_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countPersonal()) + 1);	
				}
			}
		}
		
		return $maxOrder;
	}
		
	
	/**
	*	Funcion responsable de validar si un personal es válido para eliminar, 
	*	Un personal es válido para eliminar cuando existe y el cargo al que 
	*	pertenece no está eliminado.
	*/
	function validateRemove($pers_code) {
		$response = false;
		$query = "SELECT COUNT(*) AS amount FROM service s JOIN service_type st ON s.sertype_code=st.sertype_code 
					WHERE s.serv_code=".$serv_code." AND s.serv_status=1 AND st.sertype_status=1;";

		$query = "SELECT COUNT(*) AS amount "
			   . "FROM "
			   . "(SELECT c.chg_code, cp.pers_code "
			   . "FROM charge c "
			   . "JOIN charge_personal cp "
			   . "ON c.chg_code=cp.chg_code "
			   . "WHERE c.chg_status<>3) c. "
			   . "JOIN personal p "
			   . "ON c.pers_code=p.pers_code "
			   . "WHERE p.pers_code=" . (int) $pers_code . ";";
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$response = $row['amount'];
			}
		}
		
		return $response;
	}


}
?>