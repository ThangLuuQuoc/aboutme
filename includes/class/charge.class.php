<?php
/**
*	charge.class.php
*	1.0
*	09/DEC/2012
*	@Copyright
*/

class Charge {
		
	/**
	*	Metodo constructor de la clase
	*/	
	function Charge (){
	
	}
	

	/**
	*	Funcion responsable de insertar un cargo
	*	@return boolean, resultado de la inserción
	*/
	function insertCharge($data) {
		$query = "INSERT INTO charge (chg_code, chg_name, chg_name_e, chg_status, chg_order) VALUES 
			(NULL, '" . $data->chg_name . "', '" . $data->chg_name_e . "', '" . $data->chg_status . "', '" . $data->chg_order . "');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			die($query. ' ' . mysql_error ());
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los cargos no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de cargos
	*/
	function chargeList($search = '', $orderBy = '', $init = 0, $amount = 0) {
		$where = "";
				
		if ($search != '') {
			$where .= " AND (c.chg_name like '%".$search."%' OR c.chg_name_e like '%".$search."%')";
		}
		
		$query  = "SELECT c.chg_code, c.chg_name, c.chg_status, c.chg_order, cp.amount_chg_actives FROM charge c LEFT JOIN ";
		$query .= " (SELECT cp.chg_code, COUNT(*) AS amount_chg_actives FROM charge_personal cp GROUP BY cp.chg_code) cp ";
		$query .= " ON c.chg_code = cp.chg_code WHERE c.chg_status <> 3 " . $where." ".$orderBy." ";
		
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->chg_code = $row['chg_code'];
				$data[$i]->chg_name = $row['chg_name'];
				$data[$i]->chg_status = $row['chg_status'];
				$data[$i]->chg_order = $row['chg_order'];
				$data[$i]->amount_chg_actives = $row['amount_chg_actives'];

				
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
	function countCharges($search = ''){
		$where = '';
		
		if ($search != '') {
			$where .= " AND (c.chg_name like '%".$search."%' OR c.chg_name_e like '%".$search."%')";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM charge c WHERE c.chg_status <> 3 ".$where.";";
		
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
	*	@parameter chg_code, codigo del cargo.
	*	@parameter chg_status, nuevo estado para el cargo.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($chg_code , $chg_status) {
		$query = "UPDATE charge SET chg_status='".$chg_status."' WHERE chg_code=".$chg_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un cargo.
	*	@parameter chg_code, codigo del cargo.
	*	@return datos del cargo en caso de encontrarlo.
	*/
	function getCharge($chg_code){		
		$query = "SELECT c.chg_code, c.chg_name, c.chg_name_e, c.chg_status
				FROM charge c WHERE c.chg_code = ".$chg_code.";";
				
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->chg_code = $row['chg_code'];
				$data->chg_name = $row['chg_name'];
				$data->chg_name_e = $row['chg_name_e'];
				$data->chg_status = $row['chg_status'];
			}
		}
	
		return $data;
	}
	

	/**
	*	Función responsable de actualizar un cargo.
	*	@parameter new_data: nuevos datos para la actualización.
	*	@return boolean, resultado de la actualización
	*/	
	function updateCharge($new_data){
		$query = "UPDATE charge SET chg_name = '".$new_data->chg_name."', chg_status = '".$new_data->chg_status."',
					chg_name_e= '".$new_data->chg_name_e."' WHERE chg_code =".$new_data->chg_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un item.
	*/
	function updateOrder($chg_code, $chg_order) {
		$query = "UPDATE charge SET chg_order=".(int) $chg_order." WHERE chg_code=".(int) $chg_code.";";
		
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
		$query = "SELECT c.chg_order FROM charge c WHERE c.chg_status <> 3 GROUP BY c.chg_order ORDER BY c.chg_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["chg_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(c.chg_order) AS max_value FROM charge c WHERE c.chg_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countCharges()) + 1);	
				}
			}
		}
		
		return $maxOrder;
	}
		
	
	/**
	*	Funcion responsable de validar si un cargo es válido para eliminar, 
	*	un cargo válido para eliminar es aquel no tiene personas asociadas al mismo.
	*/
	function validateRemove($chg_code) {
		$response = false;
		$query = "SELECT COUNT(*) AS amount FROM charge_personal cp WHERE cp.chg_code=".$chg_code.";";
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$response = $row['amount'];
			}
		}
		
		return $response;	
	}


}
?>