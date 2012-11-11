<?php
/**
*	contactUs.class.php
*	1.0
*	02/SEP/2012
*	@Copyright
*/

class ContactUs {
	
	/**
	*	Metodo constructor de la clase
	*/	
	function ContactUs(){
	}
	
	/**
	*	Funcion responsable de insertar un nuevo contact us en la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function insertContactUs($data){
		$query = "INSERT INTO contact (contact_code, contact_name, contact_email, contact_phone, contact_text, contact_date_create, contact_status)
				 	VALUES (NULL, '".$data->contact_name."', '".$data->contact_email."', '".$data->contact_phone."', '".$data->contact_text."', '".date ("Y-m-d H:i:s")."', '1');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
		
	/**
	*	Función responsable de listar los tipos de contactenos no eliminados que se han hecho para la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de contactenos
	*/
	function contactUsList($search = '', $orderBy = '', $init = 0, $amount = 0, $contact_status = 0) {
		$where = "";
		
		if ($search != '') {
			$where .= " WHERE (c.contact_name like '%".$search."%' OR c.contact_email like '%".$search."%' OR c.contact_phone like '%".$search."%' 
							OR use_login like '%".$search."%')";
		}
		
		if ((int) $contact_status > 0) {
			if ($where == "") {
				$where .= " WHERE ";
			} else {
				$where .= " AND ";	
			}
			$where .= " (c.contact_status =".(int) $contact_status.") ";
		}
			
		$query = " SELECT c.contact_code, c.contact_name, c.contact_email, c.contact_phone, c.contact_date_create, c.contact_status, c.use_code, c.contact_city, c.contact_text,
					 c.contact_answer, c.contact_date_answer, u.use_login
			FROM (SELECT c.contact_code, c.contact_name, c.contact_email, c.contact_phone, c.contact_date_create, c.contact_status, c.use_code, c.contact_city, c.contact_text,
					c.contact_answer, c.contact_date_answer FROM contact c WHERE c.contact_status <> 4) c LEFT JOIN user u
			ON c.use_code=u.use_code ".$where." ".$orderBy;
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {			
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->contact_code = $row['contact_code'];
				$data[$i]->contact_name = $row['contact_name'];
				$data[$i]->contact_email = $row['contact_email'];
				$data[$i]->contact_phone = $row['contact_phone'];
				$data[$i]->contact_date_create = $row['contact_date_create'];
				$data[$i]->contact_status = $row['contact_status'];
				$data[$i]->use_code = $row['use_code'];
				$data[$i]->contact_city = $row['contact_city'];
				$data[$i]->contact_text = $row['contact_text'];
				$data[$i]->contact_answer = $row['contact_answer'];
				$data[$i]->contact_date_answer = $row['contact_date_answer'];
				$data[$i]->use_login = $row['use_login'];
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
	function countContactUs($search = '', $contact_status = 0) {
		$where = '';
		
		if ($search != '') {
			$where .= " WHERE (c.contact_name like '%".$search."%' OR c.contact_email like '%".$search."%' OR c.contact_phone like '%".$search."%' 
								OR use_login like '%".$search."%')";
		}
		
		if ((int) $contact_status > 0) {
			if ($where == "") {
				$where .= " WHERE ";
			} else {
				$where .= " AND ";	
			}
			$where .= " (c.contact_status =".(int) $contact_status.") ";
		}
				
		$query = " SELECT COUNT(*) AS amount FROM (SELECT c.contact_code, c.contact_name, c.contact_email, c.contact_phone, c.contact_date_create,
					 c.contact_status, c.use_code FROM contact c WHERE c.contact_status <> 4) c LEFT JOIN user u
			ON c.use_code=u.use_code ".$where." ";
		
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
	*	@parameter contact_code, codigo del contactenos.
	*	@parameter contact_status, nuevo estado para el contactenos.
	*	@return: boolean, resultado de la operación.
	*/
	function changeStatus($contact_code , $contact_status) {
		$query = "UPDATE contact SET contact_status='".$contact_status."' WHERE contact_code=".$contact_code.";";
		
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
	function getServiceType($contact_code) {
		$query = "
		SELECT c.contact_code, c.contact_name, c.contact_email, c.contact_phone, c.contact_text, c.contact_date_create, c.contact_status,
					c.use_code, c.contact_answer, u.use_login FROM
			(SELECT c.contact_code, c.contact_name, c.contact_email, c.contact_phone, c.contact_text, c.contact_date_create, c.contact_status,
						 c.use_code, c.contact_answer FROM contact c WHERE c.contact_code = ".$contact_code.") c
		JOIN user u ON c.use_code=u.use_code;";
		
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$data->contact_code = $row['contact_code'];
				$data->contact_name = $row['contact_name'];
				$data->contact_email = $row['contact_email'];
				$data->contact_phone = $row['contact_phone'];
				$data->contact_text = $row['contact_text'];
				$data->contact_date_create = $row['contact_date_create'];
				$data->contact_status = $row['contact_status'];
				$data->use_code = $row['use_code'];
				$data->contact_answer = $row['contact_answer'];
				$data->use_login = $row['use_login'];
			}
		}
	
		return $data;
	}
	
	/**
	*	Función responsable de actualizar los datos a un contactenos.
	*	@parameter new_data: nuevos datos para la actualización del contactenos.
	*	@return boolean, resultado de la actualización
	*/	
	function updateContactUs($new_data){
		$query = "UPDATE contact SET contact_status = '".$new_data->contact_status."', use_code= '".$new_data->use_code."', contact_answer= '".$new_data->contact_answer."',
					contact_date_answer= '".date ("Y-m-d H:i:s")."' WHERE contact_code=".$new_data->contact_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}	
	
	/**
	*	Función responsable de validar si un contacto es valido, osea que exista
	*/
	function isValid($contact_code) {
		$query = "SELECT COUNT(*) AS amount FROM contact c WHERE c.contact_code=".$contact_code.";";
		
		$amount = 0;
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