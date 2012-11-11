<?php
/**
*	aplication.class.php
*	1.0
*	16/AGO/2012
*	@Copyright
*/

class Application {
		
	/**
	*	Metodo constructor de la clase
	*/	
	function User (){
	
	}
	
	/**
	*	Función responsable de obtener la informacion general de la aplicación
	*	@return data, datos de la aplicacion
	*/
	function getInformationApp($lang = "") {
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$app_slogan = "app_slogan";
				$app_information_office = "app_information_office";
				$app_text_footer = "app_text_footer";
				$app_background = "app_background";
				$app_keywords = "app_keywords";
			} elseif ($lang == "en") {
				$app_slogan = "app_slogan_e";
				$app_information_office = "app_information_office_e";
				$app_text_footer = "app_text_footer_e";
				$app_background = "app_background_e";
				$app_keywords = "app_keywords_e";
			}
			
			$query = "SELECT a.app_code, a.".$app_slogan.", a.".$app_information_office.", a.".$app_text_footer.", a.".$app_background.", a.app_background_type,
						a.app_background_color, a.".$app_keywords." FROM application a;";	
		} else {
			$query = "SELECT a.app_code, a.app_slogan, a.app_slogan_e, a.app_information_office, a.app_information_office_e, a.app_text_footer, a.app_text_footer_e,
						a.app_background, a.app_background_e, a.app_background_type, a.app_background_color, a.app_keywords, a.app_keywords_e FROM application a;";
		}
		
		$data = NULL;
		if ($result = mysql_query ($query)) {
			if ($row = mysql_fetch_array ($result)) {
				$data->app_code = $row["app_code"];
				if ($lang == "es" || $lang == "en") {
					$data->app_slogan = $row[$app_slogan];
					$data->app_information_office = $row[$app_information_office];
					$data->app_text_footer = $row[$app_text_footer];
					$data->app_background = $row[$app_background];
					$data->app_keywords = $row[$app_keywords];
				} else {
					$data->app_slogan = $row["app_slogan"];
					$data->app_slogan_e = $row["app_slogan_e"];
					$data->app_information_office = $row["app_information_office"];
					$data->app_information_office_e = $row["app_information_office_e"];
					$data->app_text_footer = $row["app_text_footer"];
					$data->app_text_footer_e = $row["app_text_footer_e"];
					$data->app_background = $row["app_background"];
					$data->app_background_e = $row["app_background_e"];
					$data->app_keywords = $row["app_keywords"];
					$data->app_keywords_e = $row["app_keywords_e"];
				}
				$data->app_background_type = $row["app_background_type"];
				$data->app_background_color = $row["app_background_color"];
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de obtener el listado de menu que se mostrara en la aplicacion
	*/
	function getAppMenu($menu_status = 0, $lang = "") {
		$where = "";
		if ((int)$menu_status != 0) {
			$where = " WHERE m.menu_status=".(int) $menu_status." ";
		}
		
		if ($lang == "es" || $lang == "en") {
			if ($lang == "es") {
				$menu_value = "menu_value";
				$menu_link = "menu_link";
			} elseif ($lang == "en") {
				$menu_value = "menu_value_e";
				$menu_link = "menu_link_e";
			}
			$query = "SELECT m.menu_code, m.".$menu_value.", m.".$menu_link." FROM app_menu m ".$where." ORDER BY m.menu_order;";
		} else {
			$query = "SELECT m.menu_code, m.menu_value, m.menu_value_e, m.menu_order, m.menu_status FROM app_menu m ".$where." ORDER BY m.menu_order;";	
		}
		
		$data = NULL;
		
		if ($result = mysql_query ($query)) {
			while ($row = mysql_fetch_array ($result)) {
				$menu_code = $row["menu_code"];
				$data[$menu_code]->menu_code = $row["menu_code"];
				if ($lang == "es" || $lang == "en") {
					$data[$menu_code]->menu_value = $row[$menu_value];
					$data[$menu_code]->menu_link = $row[$menu_link];
				} else {
					$data[$menu_code]->menu_value = $row["menu_value"];
					$data[$menu_code]->menu_value_e = $row["menu_value_e"];
					$data[$menu_code]->menu_order = $row["menu_order"];
					$data[$menu_code]->menu_status = $row["menu_status"];	
				}
			}
		}
		
		return $data;
	}
	
	/**
	*	Función responsable de actualizar el valor para un menú en la aplicación.
	*	@parameters field:nombre del campo a actualizar
	*				field_value: nuevo valor para el campo
	*				code: codigo del item a actualizar
	*	@return boolean, resultado de la operacion
	*/
	function updateFieldMenu($field, $field_value, $code) {
		$query = "UPDATE app_menu SET ".$field."='".$field_value."' WHERE menu_code=".(int) $code.";";
		
		if (mysql_query ($query)) {
			return true;	
		} else {			
			return false;
		}
	}
	
	/**
	*	Función responsable de actualizar el slogan de la empresa en la aplicación.
	*	@parameters field:nombre del campo a actualizar
	*				field_value: nuevo valor para el campo
	*				code: codigo del item a actualizar
	*	@return boolean, resultado de la operacion
	*/
	function updateInformationApp($field, $field_value, $code) {
		$additionaly = "";
		if ($field == "app_background_color") {
			if ($field_value == "#F2F2F2") {
				$additionaly = ", app_background_type=1 ";
			} else {
				$additionaly = ", app_background_type=3 ";
			}
		} elseif($field == "app_background" || $field == "app_background_e") {
			$additionaly = ", app_background_type=2 ";
		}
		
		
		$query = "UPDATE application SET ".$field."='".$field_value."' ".$additionaly." WHERE app_code=".(int) $code.";";
		
		if (mysql_query ($query)) {
			return true;	
		} else {
			die($query);
			return false;
		}
	}
}
?>