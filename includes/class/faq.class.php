<?php
/**
*	content.class.php
*	1.0
*	24/AGO/2012
*	@Copyright
*/

class Faq {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function Faq (){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo faq para la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertFaq($data){
		$query = "INSERT INTO faq (faq_code, faq_query, faq_answer, faq_query_e, faq_answer_e, faq_status, faq_order) VALUES 
				(NULL, '".$data->faq_query."', '".$data->faq_answer."', '".$data->faq_query_e."', '".$data->faq_answer_e."', '".$data->faq_status."', '".$data->faq_order."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los faqs no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de contenidos
	*/
	function faqList($search = '', $orderBy = '', $init = 0, $amount = 0, $faq_status = 0, $lang = '') {
		$where = "";
		if ((int) $faq_status > 0) {
			$where .= " AND (f.faq_status =".(int) $faq_status.") ";
		}
		
		if ($search != '') {
			$where .= " AND (f.faq_query like '%".$search."%' OR f.faq_query_e like '%".$search."%')";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$faq_query = "faq_query";
				$faq_answer = "faq_answer";
			} elseif ($lang == "en") {
				$faq_query = "faq_query_e";
				$faq_answer = "faq_answer_e";
			}
			
			$query = "SELECT f.faq_code, f.".$faq_query.", f.".$faq_answer." FROM faq f WHERE f.faq_status <> 3 ".$where;
		} else {
			$query = "SELECT f.faq_code, f.faq_query, f.faq_answer, f.faq_query_e, f.faq_answer_e, f.faq_status, f.faq_order FROM faq f WHERE f.faq_status <> 3 
						".$where." ".$orderBy;
		}
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->faq_code = $row['faq_code'];
				if ($lang == "es" || $lang == "en") {
					$data[$i]->faq_query = $row[$faq_query];
					$data[$i]->faq_answer = $row[$faq_answer];
				} else {
					$data[$i]->faq_query = $row['faq_query'];
					$data[$i]->faq_answer = $row['faq_answer'];
					$data[$i]->faq_query_e = $row['faq_query_e'];
					$data[$i]->faq_answer_e = $row['faq_answer_e'];
					$data[$i]->faq_status = $row['faq_status'];
					$data[$i]->faq_order = $row['faq_order'];
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
	function countFaq($search='', $faq_status = 0){		
		$where = '';
		
		if ((int) $faq_status > 0) {
			$where .= " AND (f.faq_status =".(int) $faq_status.") ";
		}
		
		if($search != '') {
			$where = " AND (f.faq_query like '%".$search."%' OR f.faq_query_e like '%".$search."%') ";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM faq f WHERE f.faq_status <> 3 ".$where.";";
		
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
	*	@parameter faq_code, codigo del contenido.
	*	@parameter faq_status, nuevo estado para el contenido.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($faq_code , $faq_status) {
		$query = "UPDATE faq SET faq_status='".$faq_status."' WHERE faq_code=".$faq_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;	
		}
	}
	
	/**
	*	Funcion responsable de obtener los datos de un contenido.
	*	@parameter faq_code, codigo del faq.
	*	@return datos del faq en caso de encontrarlo.
	*/
	function getFaq($faq_code, $lang = '') {
		$query = "SELECT f.faq_code, f.faq_query, f.faq_answer, f.faq_query_e, f.faq_answer_e, f.faq_status, f.faq_order FROM faq f WHERE f.faq_code = ".$faq_code.";";
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->faq_code = $row['faq_code'];
				$data->faq_query = $row['faq_query'];
				$data->faq_answer = $row['faq_answer'];
				$data->faq_query_e = $row['faq_query_e'];
				$data->faq_answer_e = $row['faq_answer_e'];
				$data->faq_status = $row['faq_status'];
				$data->faq_order = $row['faq_order'];
			}
		}

		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un contenido.
	*	@parameter new_data: nuevos datos para la actualización del contenido.
	*	@return boolean, resultado de la actualización
	*/	
	function updateFaq($new_data){
		$query = "UPDATE faq SET faq_query='".$new_data->faq_query."', faq_answer='".$new_data->faq_answer."', faq_query_e='".$new_data->faq_query_e."', 
					faq_answer_e= '".$new_data->faq_answer_e."', faq_status='".$new_data->faq_status."' WHERE faq_code=".$new_data->faq_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Funcion responsable de actualizar el orden a un contenido.
	*/
	function updateOrder($faq_code, $faq_order) {
		$query = "UPDATE faq SET faq_order=".$faq_order." WHERE faq_code=".$faq_code.";";
		
		if (mysql_query ($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	*	Función responsable de obtener el valor siguiente de orden para la secuencia.
	*/
	function getMaxOrder($toOrder = false) {
		$query = "SELECT MAX(f.faq_order) AS max_value FROM faq f WHERE f.faq_status <> 3;";
		$maxOrder = 0;
		
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$maxOrder = (int) $row["max_value"];
				if (! $toOrder) {
					return $maxOrder;
				} else {
					return (max($maxOrder, $this->countFaq()) + 1);
				}
			}
		}
		
		return $maxOrder;
	}	
}
?>