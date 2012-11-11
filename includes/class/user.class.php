<?php
/**
*	user.class.php
*	1.0
*	05/AGO/2012
*	@Copyright
*/

class User {			
	var $use_code;
	var $use_name;
	var $use_lastname;
	var $use_email;
	var $use_login;
	var $use_status;
	
	/**
	*	Metodo constructor de la clase
	*/	
	function User (){
		$use_code = 0;
		$use_name = '';
		$use_lastname = '';
		$use_email = '';
		$use_login = '';
		$use_status = '';
	}
	
	/**
	*	Funcion responsable de insertar in nuevo usuario en la aplicación.
	*	@return boolean, resultado de la inserción
	*/
	function addUser($data){
		$query = "INSERT INTO user (use_code, use_name, use_lastname, use_email, use_login, use_password, use_status, use_date_create) 
					VALUES (NULL, '".$data->use_name."', '".$data->use_lastname."', '".$data->use_email."', '".$data->use_login."',
					'".$data->use_password."', '1', '".date ("Y-m-d H:i:s")."');";
		
		if (mysql_query ($query)) {
			return mysql_insert_id ();
		} else {
			return false;
		}
	}
		
	/**
	*	Funcion responsable de verificar si una cuenta de usuario existe o no.
	*	@parameter use_login, login a verificar
	*	@parameter use_code, codigo de usuario a ognorar
	*	@return	boolean, resultado de la verificacion
	*/	
	public function userExist($use_login){
		$where = '';
		
		$query = "SELECT u.use_code, u.use_login FROM user u WHERE u.use_login = '".$use_login."' ".$where.";";
		$result = false;
		
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)){
				$this->use_code = $row['use_code'];
				$this->use_login = $row['use_login'];
				$result = true;
			}
		} 
		
		return $result;		
	}
	
	/**
	*	Función responsable de listar lis usuarios no eliminados de la aplicación.
	*	@parameter search, cadena de busqueda para filtrar resultados.
	*	@parameter orderBy, campo por el cual ordenar el listado.
	*	@parameter init, valor desde el cual se obtendrán los resultados.
	*	@parameter amount, cantidad de valores a obtener del resultado de la consulta.
	*	@retur array, lista de usuarios
	*/
	function userList($search = '', $orderBy = '', $init = 0, $amount = 0) {
		$where = "";
		if($search != '') {
			$where = " AND (use_name like '%".$search."%' OR use_lastname like '%".$search."%' OR use_email like '%".$search."%' OR use_login like '%".$search."%')";
		}
				
		$query = "SELECT u.use_code, u.use_name, u.use_lastname, u.use_email, u.use_login, u.use_status FROM user u 
					WHERE u.use_status <> 4 ".$where." ".$orderBy;
		
		if (!($init == 0 && $amount == 0)) {
			$query .= ' LIMIT '.$init.', '.$amount.';';
		}
		
		$data = NULL;
		if ($consult = mysql_query($query)) {
			$i = 0;
			while ($row = mysql_fetch_array ($consult)) {
				$data[$i]->use_code = $row['use_code'];
				$data[$i]->use_name = $row['use_name'];
				$data[$i]->use_lastname = $row['use_lastname'];
				$data[$i]->use_email = $row['use_email'];
				$data[$i]->use_login = $row['use_login'];
				$data[$i]->use_status = $row['use_status'];
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
	function countUser($search=''){		
		$where = '';		
		if($search != '') {
			$where = " AND (use_name like '%".$search."%' OR use_lastname like '%".$search."%' OR use_email like '%".$search."%' OR use_login like '%".$search."%')";
		}
		
		$query = "SELECT COUNT(*) AS amount FROM user WHERE use_status <> 4 ".$where.";";
		
		$amount = 0;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {
				$amount = $row['amount'];
			}
		}
		
		return $amount;
	}
		
	/**
	*	Funcion responsable de validar la autenticacion de un usuario en la aplicación.
	*	@parameter use_login, usuario
	*	@parameter use_password, contraseña
	*	@return boolean, resultado de la validación.
	*/
	function validateAccount($use_login, $use_password){
		$query = "SELECT u.use_code, u.use_name, u.use_lastname, u.use_email, u.use_login, u.use_status, u.use_date_create FROM user u 
				WHERE u.use_login='".$use_login."' AND u.use_password='".$use_password."';";
		
		$result = false;
		if ( $consult =  mysql_query ($query) ){
			if( $row =  mysql_fetch_array ($consult) ){
				$this->use_code = $row['use_code'];
				$this->use_name = $row['use_name'];
				$this->use_lastname = $row['use_lastname'];
				$this->use_email = $row['use_email'];
				$this->use_login = $row['use_login'];
				$this->use_status = $row['use_status'];
				$this->use_date_create = $row['use_date_create'];
				$result = true;
			}
		}
		
		return $result;
	}
	
	/**
	*	Funcion responsable de obtener los datos de un usuario.
	*	@parameter use_code, codigo del usuario
	*	@return datos del usuario en caso de encontrarlo.
	*/
	function getUser($use_code){
		$query = "SELECT u.use_code, u.use_name, u.use_lastname, u.use_email, u.use_login, u.use_password FROM user u WHERE use_code = ".$use_code.";";
		
		$data = NULL;
		if ($consult = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($consult)) {		
				$data->use_code = $row['use_code'];
				$data->use_name = $row['use_name'];
				$data->use_lastname = $row['use_lastname'];
				$data->use_email = $row['use_email'];
				$data->use_login = $row['use_login'];
				$data->use_password = $row['use_password'];
			}
		}

		return $data;
	}
	

	/**
	*	Función responsable de actualizar los datos a un usuario.
	*	@parameter new_data: nuevos datos para la actualización del usuario.
	*	@return boolean, resultado de la actualización
	*/	
	function updateUser($new_data){
		$query = "UPDATE user SET use_name = '".$new_data->use_name."', use_lastname = '".$new_data->use_lastname."', use_email = '".$new_data->use_email."',
					use_password = '".$new_data->use_password."' WHERE user.use_code =".$new_data->use_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	*	Funcion responsable de cambiar el estado a un usuario.
	*	@parameters use_code: codigo del usuario
	*				use_status: nuevo estado del usuario para actualizar
	*	@return boolean, resultado de la actualización.
	*/	
	function changeStatusUser($use_code, $use_status) {
		$query="UPDATE user SET use_status='".(int) $use_status."' WHERE use_code=".(int) $use_code.";";
		
		if (mysql_query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>