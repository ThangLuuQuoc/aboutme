<?php
/**
*	content.class.php
*	1.0
*	16/AGO/2012
*	@Copyright
*/

class Content {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Content (){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo contenido para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertContent($data){
		$query = "INSERT INTO content (cont_code, cont_name, cont_text, cont_date_create, cont_status, cont_name_e, cont_text_e, cont_order) VALUES 
					(NULL, '".$data->cont_name."', '".$data->cont_text."', '".date ("Y-m-d H:i:s")."', '".$data->cont_status."', '".$data->cont_name_e."',
					 '".$data->cont_text_e."', '".$data->cont_order."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los contenidos no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de contenidos
	*/
	function contentList($search = '', $orderBy = '', $init = 0, $amount = 0, $cont_status = 0, $lang = '') {
		$where = "";
		if ((int) $cont_status > 0) {
			$where .= " AND (c.cont_status =".(int) $cont_status.") ";
		}
		
		if ($search != '') {
			$where .= " AND (c.cont_name like '%".$search."%' OR c.cont_name_e like '%".$search."%')";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$cont_name = "cont_name";
			} elseif ($lang == "en") {
				$cont_name = "cont_name_e";
			}
			
			$query = "SELECT c.cont_code, c.".$cont_name." FROM content c WHERE c.cont_status <> 3 ".$where;
		} else {
			$query = "SELECT c.cont_code, c.cont_name, c.cont_date_create, c.cont_status, c.cont_order FROM content c WHERE c.cont_status <> 3 ".$where." ".$orderBy;
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->cont_code = $row['cont_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->cont_name = $row[$cont_name];
				} else {					
					$data[$i]->cont_name = $row['cont_name'];
					$data[$i]->cont_date_create = $row['cont_date_create'];
					$data[$i]->cont_status = $row['cont_status'];
					$data[$i]->cont_order = $row['cont_order'];
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
	function countContents($search='', $cont_status = 0){		
		$where = '';
		
		if ((int) $cont_status > 0) {
			$where .= " AND (cont_status =".(int) $cont_status.") ";
		}
		
		if($search != '') {
			$where = " AND (cont_name like '%".$search."%' OR cont_name_e like '%".$search."%') ";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM content WHERE cont_status <> 3 ".$where.";";
		
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
	*	@parameter cont_code, codigo del contenido.
	*	@parameter cont_status, nuevo estado para el contenido.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($cont_code , $cont_status) {
		$query = "UPDATE content SET cont_status='".$cont_status."' WHERE cont_code=".$cont_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un contenido.
	*	@parameter cont_code, codigo del contenido.
	*	@return datos del contenido en caso de encontrarlo.
	*/
	function getContent($cont_code, $lang = ''){
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$cont_name = "cont_name";
				$cont_text = "cont_text";
			} elseif ($lang == "en") {
				$cont_name = "cont_name_e";
				$cont_text = "cont_text_e";
			}
			
			$query = "SELECT c.cont_code, c.".$cont_name.", c.".$cont_text." FROM content c WHERE c.cont_code=".$cont_code.";";
		} else {
			$query = "SELECT c.cont_code, c.cont_name, c.cont_text, c.cont_date_create, c.cont_status, c.cont_name_e, c.cont_text_e, c.cont_order 
					FROM content c WHERE cont_code = ".$cont_code.";";
		}
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->cont_code = $row['cont_code'];
				if ($lang == "es" || $lang == "en") {
					$data->cont_name = $row[$cont_name];
					$data->cont_text = $row[$cont_text];
				} else {
					$data->cont_name = $row['cont_name'];
					$data->cont_text = $row['cont_text'];
					$data->cont_date_create = $row['cont_date_create'];
					$data->cont_status = $row['cont_status'];
					$data->cont_name_e = $row['cont_name_e'];
					$data->cont_text_e = $row['cont_text_e'];
					$data->cont_order = $row['cont_order'];
				}
			}
		}

		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un contenido.
	*	@parameter new_data: nuevos datos para la actualización del contenido.
	*	@return boolean, resultado de la actualización
	*/	
	function updateContent($new_data){
		$query = "UPDATE content SET cont_name = '".$new_data->cont_name."', cont_text = '".$new_data->cont_text."', cont_status = '".$new_data->cont_status."',
					cont_name_e= '".$new_data->cont_name_e."', cont_text_e= '".$new_data->cont_text_e."' WHERE content.cont_code =".$new_data->cont_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un contenido.
	*/
	function updateOrder($cont_code, $cont_order) {
		$query = "UPDATE content SET cont_order=".$cont_order." WHERE cont_code=".$cont_code.";";
		
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
		$query = "SELECT c.cont_order FROM content c WHERE c.cont_status <> 3 GROUP BY c.cont_order ORDER BY c.cont_order;";
		$data = array ();
		
		if ($result = mysql_query ($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($result)) {
				$data[$i] = $row["cont_order"];
				$i++;
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(c.cont_order) AS max_value FROM content c WHERE c.cont_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countContents()) + 1);	
				}
			}
		}
		
		return $maxOrder;
	}
	
	/**
	*	Función responsable de validar si un contenido es válido o no para mostrar en la aplicación.
	*	Un contenido es válido cuando existe y está activo.
	*	@parameter cont_code: código del contenido a validar
	*	@return boolean, resultado de la validación del contenido.
	*/
	function isValid($cont_code) {
		$query = "SELECT COUNT(*) AS amount FROM content c WHERE c.cont_code=".$cont_code." AND c.cont_status=1;";
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