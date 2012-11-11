<?php
	class Slider {
		
		function Slider(){}
		
		
		/**
		*	Funcion responsable de insertar un nuevo item al slider.
		*	@parameters data: datos del nuevo slider.
		*	@return boolean, resulado de la operación.
		*/
		function insertItemSlider($data){
			$query = "INSERT INTO slider (slid_code, use_code, slid_title, slid_content, slid_image_name, slid_image_rename, slid_url, slid_status, slid_last_modified,
						slid_date_create, slid_title_e, slid_content_e, slid_image_name_e, slid_image_rename_e, slid_order) VALUES 
					(NULL, '".$data->use_code."', '".$data->slid_title."', '".$data->slid_content."', '".$data->slid_image_name."', '".$data->slid_image_rename."',
					 '".$data->slid_url."', '".$data->slid_status."', '".date ("Y-m-d H:i:s")."', '".date ("Y-m-d H:i:s")."', '".$data->slid_title_e."', 
					 '".$data->slid_content_e."', '".$data->slid_image_name_e."', '".$data->slid_image_rename_e."', '".(int) $data->slid_order."');";
			
			if (mysql_query ($query)) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		*	Funcion responsable de obtener la lista de items del slider
		*	@parameters search: cadena de busqueda para filtrar resultados.
		*				orderBy: campo por el cual ordenar el listado
		*				init: numero para indicar desde que fila encontrada se obtendran los resultados
		*				amount: numero para indicar hasta que fila encontrada se obtendran los resultados
		*				slid_status: para filtrar los items por estado
		*	@return lista de items para del eslider.
		*/
		function listItemsSlider($search = '', $orderBy = '', $init = 0, $amount = 0, $slid_status = '', $lang = ""){
			$where = '';
			
			if (! empty ($search)) {
				$where = " AND (s.slid_title like '%".$search."%' OR s.slid_content like '%".$search."%' OR 
							s.slid_url like '%".$search."%' OR s.slid_title_e like '%".$search."%' OR s.slid_content_e)";
			}
			
			if (! empty ($slid_status)) {
				$where = " AND s.slid_status=".$slid_status." ";
			}
			
			if ($lang == "es" || $lang == "en") {
				if ($lang == "es") {
					$slid_title = "slid_title";
					$slid_content = "slid_content";
					$slid_image_name = "slid_image_name";
					$slid_image_rename = "slid_image_rename";
				} elseif ($lang == "en") {
					$slid_title = "slid_title_e";
					$slid_content = "slid_content_e";
					$slid_image_name = "slid_image_name_e";
					$slid_image_rename = "slid_image_rename_e";
				}
				
				$query = "SELECT s.slid_code, s.".$slid_title.", s.".$slid_content.", s.".$slid_image_name.", s.".$slid_image_rename.", s.slid_url
						FROM slider s WHERE s.slid_status <> 3 ".$where." ".$orderBy." ";
			} else {
				$query = "SELECT s.slid_code, s.slid_title, s.slid_content, s.slid_image_name, s.slid_image_rename, s.slid_url, s.slid_status, s.slid_last_modified, s.slid_order
						FROM slider s WHERE s.slid_status <> 3 ".$where." ".$orderBy." ";
			}
			
			if (!($init == 0 && $amount == 0)) {
				$query .= " LIMIT ".$init.", ".$amount." ;";
			}
			
			$data = NULL;
			if ($result = mysql_query ($query)) {				
				$i = 0;				
				while ($row = mysql_fetch_array ($result)) {
					$data[$i]->slid_code = $row["slid_code"];
					$data[$i]->slid_url = $row["slid_url"];
					if ($lang == "es" || $lang == "en") {
						$data[$i]->slid_title = $row[$slid_title];
						$data[$i]->slid_content = $row[$slid_content];
						$data[$i]->slid_image_name = $row[$slid_image_name];
						$data[$i]->slid_image_rename = $row[$slid_image_rename];
					} else {						
						$data[$i]->slid_title = $row["slid_title"];
						$data[$i]->slid_content = $row["slid_content"];
						$data[$i]->slid_image_name = $row["slid_image_name"];
						$data[$i]->slid_image_rename = $row["slid_image_rename"];
						$data[$i]->slid_status = $row["slid_status"];
						$data[$i]->slid_last_modified = $row["slid_last_modified"];
						$data[$i]->slid_order = $row["slid_order"];
					}
					$i++;
				}
			}
			
			return $data;
		}
		
		/**
		*	Funcion responsable de contar los items del slider.
		*	@parameters search: cadena de busqueda para filtrar resultados.
		*				slid_status: para filtrar los items por estado
		*	return int, cantidad de resultados encontrados.
		*/
		function countItemsSlider($search = '', $slid_status='') {
			$where = '';
			if (! empty ($search)) {
				$where = " AND (s.slid_title like '%".$search."%' OR s.slid_content like '%".$search."%' OR 
							s.slid_url like '%".$search."%' OR s.slid_title_e like '%".$search."%' OR s.slid_content_e)";
			}
			
			if (! empty ($slid_status)) {
				$where = " AND s.slid_status=".$slid_status." ";
			}
			
			$query = "SELECT COUNT(*) AS amount FROM slider s WHERE s.slid_status <> 3 ".$where.";";
			$amount = 0;
			
			if ($result = mysql_query ($query)) {
				if ($row = mysql_fetch_array ($result)) {
					$amount = $row["amount"];
				}
			}
			
			return $amount;
		}
		
		/**
		*	Funcion responsable de obtener la informacion de un item de slider.
		*	@parameters slid_code: código del item de slider
		*	@return data, informacion del item en caso de ser encontrado
		*/
		function getItemSlider($slid_code) {
			$query = "SELECT s.slid_code, s.use_code, s.slid_title, s.slid_content, s.slid_image_name, s.slid_image_rename, s.slid_url, s.slid_status, s.slid_last_modified,
						s.slid_date_create, s.slid_title_e, s.slid_content_e, s.slid_image_name_e, s.slid_image_rename_e
					 	FROM slider s WHERE s.slid_code=".$slid_code.";";
			
			$data = NULL;
			if ( $result = mysql_query ($query) ) {				
				if ($row = mysql_fetch_array ($result)) {
					$data->slid_code = $row["slid_code"];
					$data->use_code = $row["use_code"];
					$data->slid_title = $row["slid_title"];
					$data->slid_content = $row["slid_content"];
					$data->slid_image_name = $row["slid_image_name"];
					$data->slid_image_rename = $row["slid_image_rename"];
					$data->slid_url = $row["slid_url"];
					$data->slid_status = $row["slid_status"];
					$data->slid_last_modified = $row["slid_last_modified"];
					$data->slid_date_create = $row["slid_date_create"];
					$data->slid_title_e = $row["slid_title_e"];
					$data->slid_content_e = $row["slid_content_e"];
					$data->slid_image_name_e = $row["slid_image_name_e"];
					$data->slid_image_rename_e = $row["slid_image_rename_e"];
				}
			}
			
			return $data;
		}
		
		/**
		*	Funcion responsable de actualizar un item en el slider.
		*	@parameters data: datos a editar del item de slider
		*	@return boolean, resultado de la operacion
		*/
		function updateItemSlider($data) {
			$query = "UPDATE slider SET slid_title='".$data->slid_title."', slid_content='".$data->slid_content."', slid_image_name='".$data->slid_image_name."',
						slid_image_rename='".$data->slid_image_rename."', slid_url='".$data->slid_url."', slid_last_modified='".date ("Y-m-d H:i:s")."', 
						slid_title_e='".$data->slid_title_e."', slid_content_e='".$data->slid_content_e."', slid_image_name_e='".$data->slid_image_name_e."',
						slid_image_rename_e='".$data->slid_image_rename_e."' , slid_status='".$data->slid_status."'
						WHERE slid_code=".$data->slid_code.";";
			
			if ($result = mysql_query ($query)) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		*	Funcion responsable de cambiar el estado de un item del slider
		*	@parameters slid_code: codigo del item de slider al cual se le piensa cambiar el estado
		*				slid_status: nuevo estado del item de slider
		*	@return boolean, resultado de la operación.
		*/
		function changeStatusItemSlider($slid_code, $slid_status) {
			$query = "UPDATE slider SET slid_status=".$slid_status." WHERE slid_code=".$slid_code.";";

			if (mysql_query ($query)) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		*	Funcion responsable de obtener los valores que has sido usados para ordenar los items.
		*	@return array, lista con los orders que se han usado para ordenar los items.
		*/
		function getOrdersSlider() {
			$query = "SELECT s.slid_order FROM slider s WHERE s.slid_status <> 3 GROUP BY s.slid_order ORDER BY s.slid_order;";
			$data = array ();
			
			if ($result = mysql_query ($query)) {				
				$i = 0;
				while ($row = mysql_fetch_array ($result)) {
					$data[$i] = $row["slid_order"];
					$i++;
				}
			}
			
			return $data;
		}
		
		/**
		*	Funcion responsable de actualizar el orden a un item del slider.
		*/
		function updateOrderItemSlider($slid_code, $slid_order) {
			$query = "UPDATE slider SET slid_order=".$slid_order." WHERE slid_code=".$slid_code.";";
			
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
			$query = "SELECT MAX(s.slid_order) AS max_value FROM slider s WHERE s.slid_status <> 3;";
			$maxOrder = 0;
			
			if ($result = mysql_query ($query)) {
				if ($row = mysql_fetch_array ($result)) {
					$maxOrder = (int) $row["max_value"];
					if (! $toOrder) {
						return $maxOrder;
					} else {
						return (max($maxOrder, $this->countItemsSlider()) + 1);	
					}
				}
			}
			
			return $maxOrder;
		}
	}
?>