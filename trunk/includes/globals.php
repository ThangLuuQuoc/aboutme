<?php
	header('Content-Type: text/html; charset=UTF-8');	
	
	if (!empty ($_SESSION['message_value']) && !empty ($_SESSION['message_show'])) {
		$message_value = $_SESSION['message_value'];
		$message_show = $_SESSION['message_show'];
	} else {
		$message_value = "";
		$message_show = "";
	}
	
	define ("SITE_NAME", "Soluciones Celulares");
	define ("SEPARATOR_A", " - ");
		
	$_SESSION['message_value'] = "";
	$_SESSION['message_show'] = "";
	
	$_SESSION["lang_admin"] = "es";//idioma del admnin.	
	
	$messages = getLanguajeAdmin($_SESSION["lang_admin"]);
	
	if (!isset ($_SESSION["lang"])) {
		$_SESSION["lang"] = 'es';
	}
	$lang = $_SESSION["lang"];
	$messages_p = getLanguajePublic($_SESSION["lang"]);
	
	
	/**
	*	Función responsable de hacer hacerle un check de seguridad a una cadena, el proceso consiste en trim, strip_tags, myreal_scape_string
	*	@parameters field: campo a analizar
	*				aplyTrim: para hacerle trim a la cadena por parametro.
	*				aplyMyRealScapeString: para remover palabras reservadas de mysql q puedan ser un ataque
	*				aplyStripTags: para los ataques cross site.
	*	@return cadena con la seguridad aplicada.
	*/
	function fieldSecure($field, $aplyTrim=true, $aplyMyRealScapeString=true, $aplyStripTags=true) {
		$field = str_replace ("'", "", $field);	 
		$field = str_replace ('"', '', $field);
		
		if ($aplyTrim) {
			$field = trim ($field);
		}
		
		if ($aplyMyRealScapeString) {
			$field = mysql_real_escape_string ($field);
		}
		
		if ($aplyStripTags) {
			$field = strip_tags ($field);
		}
		
		return $field;
	}
	
	/**
	*	Función responsable de obtener el lenguaje que se usará en la app para el administrador.
	*	@parameter lang: lenguaje a mostrar en la app.
	*	@return array, array con el idioma cargado para mostrar en la app.
	*/
	function getLanguajeAdmin($lang="es") {
		if ($lang == "es") {
			return array (
				"general_name_app" => SITE_NAME,
				"general_copyright" => "Todos los derechos reservados 2012",
				"general_site_error" => "Sitio en mantenimiento, disculpe los inconvenientes",
				"general_title_init" => "Inicio",
				"general_title_welcome" => "Bienvenido",
				"general_title_users" => "Usuarios",
				"general_title_users_add" => "Nuevo Usuario",
				"general_title_users_update" => "Actualizar Usuario",
				"general_title_users_delete" => "Eliminar Usuario",
				"general_title_slider" => "Slider",
				"general_title_newItemSlider" => "Nuevo Item Slider",
				"general_title_updateItemSlider" => "Actualizar Item Slider",
				"general_title_jcrop" => "Seleccionar Imagen",
				"general_title_contents" => "Contenidos",
				"general_title_contents_add" => "Nuevo Contenido",
				"general_title_contents_update" => "Actualizar Contenido",

				"general_title_services" => "Servicios",
				"general_title_services_add" => "Nuevo Servicio",
				"general_title_services_update" => "Actualizar Servicio",
				
				"general_title_services_type" => "Tipos de Servicio",
				"general_title_services_type_add" => "Nuevo Tipo de Servicio",
				"general_title_services_type_update" => "Actualizar Tipo de Servicio",
				
				"general_title_personal" => "Personal",
				"general_title_personal_add" => "Nuevo ",
				"general_title_personal_update" => "Actualizar Personal",
				
				"general_title_personal_charge" => "Cargos",
				"general_title_personal_charge_add" => "Nuevo Cargo",
				"general_title_personal_charge_update" => "Actualizar Cargo",
				
				"general_title_galleries" => "Galer&iacute;as",
				"general_title_galleries_add" => "Nueva galer&iacute;a",
				"general_title_galleries_update" => "Actualizar Galer&iacute;a",
				
				"general_title_videos" => "Videos",
				"general_title_videos_add" => "Nuevo Video",
				"general_title_videos_update" => "Actualizar Video",
				
				"general_title_contact_us" => "Cont&aacute;ctenos",
				
				"general_title_faqs" => "FAQ",
				"general_title_faqs_add" => "Nuevo FAQ",
				"general_title_faqs_update" => "Actualizar FAQ",
				
				"jcrop_message_select_image" => "Por favor seleccione la zona de la imagen que desea recortar",
				"validationJcrop_masxSize" => "S&oacute;lo imagenes bajo un tama&ntilde;o m&aacute;ximo de {0} son aceptadas para cargar",
				"validationJcrop_format" => "S&oacute;lo images bajo el formato jpg son aceptadas para cargar",
				"validationJcrop_selectImage" => "Seleccione una imagen formato jpg para cargar.",
				
				"general_authentication" => "Autenticaci&oacute;n",
				"general_error" => "Error",				
				"general_alert" => "Alerta",
				"general_information" => "Informaci&oacute;n",
				"general_confirm" => "Confirmar",
				"general_calcel" => "Cancelar",
				"general_acept" => "Aceptar",
				"general_logout" => "Salir",
				"general_loading" => "Cargando",
				"general_welcome" => "Bienvenido",
				"general_search" => "buscar",
				"general_errorSaving" => "Error al guardar la informaci&oacute;n",
				"general_slogan" => "Lema",
				"general_information_office" => "informaci&oacute;n oficina",
				"general_keywords" => "Palabras clave",
				"general_saving" => "Guardando",
				"general_securityImage" => "Imagen de seguridad",
				"general_insertSecurityImage" => "Ingrese la imagen de seguridad",
				"general_login" => "Iniciar Sesi&oacute;n",
				"general_clear" => "Limpiar",
				"general_cancel" => "Cancelar",
				"general_save" => "Guardar",
				"general_incorrect_data" => "Datos incorrectos",
				"general_code_security_incorrect" => "C&oacute;digo de seguridad incorrecto",
				"general_options" => "Opciones",
				"general_showing" => "Mostrando {0}-{1} de {2}",
				"general_active" => "Activo",
				"general_inactive" => "Inactivo",
				"general_bloqued" => "Bloqueado",
				"general_preview" => "Anterior",
				"general_next" => "Siguiente",
				"general_no_data" => "No se encontraron datos",
				"general_remove" => "Eliminar",
				"general_update" => "Actualizar",
				"general_image" => "Imagen",
				"general_spanish" => "Espa&ntilde;ol",
				"general_english" => "Ingl&eacute;s",
				"general_title" => "T&iacute;tulo",
				"general_load_image" => "Cargar imagen",				
				"general_load_other_image" => "Cargar otra imagen",
				"general_recharge" => "Recargar",
				"general_updated" => "Actualizado",
				"general_message_use_image" => "Usar esta imagen como imagen en ",
				"general_aditionalInformation" => "Informaci&oacute;n Adicional",
				"general_url" => "URL",
				"general_last_updated" => "&Uacute;ltima actualizaci&oacute;n",
				"general_date_create" => "Creado",				
				"general_content" => "Contenido",
				"general_status" => "Estado",
				"general_email" => "Correo Electr&oacute;nico",
				"general_phone" => "Tel&eacute;fono",
				"general_city" => "Ciudad",
				"general_question_concern" => "Preguntas / inquietudes",
				"general_ticket_contact" => "Ticket cont&aacute;cto",
				"general_reply" => "Responder",
				"general_response" => "Respuesta",
				"general_send_response" => "Enviar Respuesta",				
				"general_disregard" => "Ignorar",
				"general_disregard" => "Ignorar",
				"general_query" => "Pregunta",
				"general_answer" => "Respuesta",
				
				"general_answered" => "Respuesto",
				"general_unanswered" => "Sin responder",
				"general_noteless" => "Ignorado",
				"general_date_response" => "Fecha Respuesta",
				"general_response_by" => "Respuesto por",
				"general_close" => "Cerrar",
				
				"general_order" => "Orden",
				"general_original_image" => "Imagen original",
				"general_original_image_charged" => "Imagen original cargada",
				"general_preview_show" => "Vista previa",
				"general_save_selection" => "Guardar selecci&oacute;n",
				"general_note_status" => "Nota: si seleccionas \"Activo\" el item se mostrara en el sitio, \"Inactivo\" NO se muestra",
				"general_note_keywords" => "<strong>Importante:</strong> Ingresa Palabras Claves que identifiquen a tu negocio o actividad, las palabras debes de ingresarlas separadas por coma (,). Puedes utilizar Palabras Claves compuestas, como por ejemplo: telefon&iacute;a celular, hospital veterinario, peluquer&iacute;a Armenia, etc.. Hay que ser h&aacute;biles e inteligentes a la hora de elegir las Palabras Claves, estas deben ser justamente eso, Claves para que los potenciales clientes te puedan encontrar. Estas palabras sirven para que nuestro sitio web tenga m&aacute;s posibilidades de ser encontrado por los motores de busqueda como Google. <strong>Evita errores ortogr&aacute;ficos</strong>",
				"general_more_tips" => "M&aacute;s consejos",
				"general_menu" => "Men&uacute;",				
				"general_footer" => "Pi&eacute; de p&aacute;gina",
				"general_background_type" => "Tipo de fondo",
				"general_color" => "Color",
				"general_default" => "Por defecto",
				"general_background_image" => "Imagen de fondo [.jpg, .png, .gif]",
				"general_background_color" => "Color de fondo",
				"general_name" => "Nombre",
				"general_summary" => "Resumen",
				"general_description" => "Descripci&oacute;n",
				"general_service_type" => "Tipo de servicio",
				"general_charges" => "Cargos",
				"general_select" => "Seleccione",
				"general_general_information" => "Informaci&oacute;n General",
				"general_highlight" => "Destacar",
				"general_images" => "Lista de im&aacute;genes",
				"general_upload_image" => "Subir Imagen",
				"general_uploading" => "Subiendo",
				"general_front" => "Portada",
				"general_video" => "Video",				
				"general_url_youtube" => "URL YouTube",
				"general_url_youtube_example" => "Ejemplo: http://www.youtube.com/watch?v=bV3dGEPpAbE&feature=fvwrel",
				"general_video_type" => "Tipo de video",
				"general_loaded_from_computer" => "Cargado desde el computador",
				"general_loaded_from_youtube" => "Cargado desde YouTube",
				"general_view_video" => "Ver Video",
				"general_view" => "Ver",
				"general_today" => "Hoy",
				
				"general_messageCharacters" => "Caracteres disponibles por escribir: ",
				"general_message_confirmDelete" => "¿Est&aacute; seguro de eliminar este item?",
				"general_message_confirmHighlight" => "¿Est&aacute; seguro que desea destacar este item?",
				"general_message_confirmNoHighlight" => "¿Est&aacute; seguro que desea dejar de destacar este item?",
				"general_message_errorOrder" => "Ha ocurrido un error al tratar de actualizar el orden para el item, intenta m&aacute;s tarde",
				"general_message_updatedStatusItem" => "El estado del item ha sido actualizado con exito",
				"general_message_errorUpdatingStatusItem" => "Ha ocurrido un error al trata de cambiar el estado para el item",
				"general_message_errorDelete" => "Ha ocurrido un error al tratar de eliminar el item",
				"general_message_confirmDeleteImage" => "¿Est&aacute; seguro de eliminar esta imagen?",
				"general_message_errorSizeImage" => "Las dimensiones de la imagen deben de ser como m&iacute;nimo de {0} (ancho) y {1} (alto), Tu imagen es de {2} (ancho) y {3} (alto). lo anterior para conservar la calidad del sitio.",
				"general_message_confirmDelete" => "¿Est&aacute; seguro de eliminar este item?",
				"general_message_confirmDisregar" => "¿Est&aacute; seguro de ignorar este item?",
				"general_message_invalidImageExtension" => "Extensi&oacute;n NO permitida, debes cargar una imagen con formato {0}",
				"general_message_imageHomeValidation" => "Debes seleccionar una imagen antes de guardar",
				
				"validationUser_nameRequired" => "El nombre es requerido",
				"validationUser_lastnameRequired" => "El apellido es requerido",
				"validationUser_emailRequired" => "El email es requerido",
				"validationUser_emailValidation" => "El email ingresado es inv&aacute;lido",
				"validationUser_userRequired" => "El usuario es requerido",
				"validationUser_userInvalid" => "El usuario \"{0}\" no est&aacute; disponible, intenta con otro",
				"validationUser_passwordRequired" => "La contrase&ntilde;a es requerida",
				"validationUser_passwordValidation" => "Las contrase&ntilde;as no coinciden",
				"validationUser_securityCodeRequired" => "Ingrese el c&oacute;digo de seguridad",
				
				"user_name" => "Nombre",
				"user_lastname" => "Apellido",
				"user_email" => "Correo elect&oacute;nico",
				"user_user" => "Usuario",
				"user_status" => "Estado",
				"user_password" => "Contrase&ntilde;a",
				"user_confirmPassword" => "Confirmar contrase&ntilde;a",
				
				"user_message_action_bloqued" => "El usuario {0} ha sido bloqueado. Por favor contacte al administrador del sitio",				
				"user_message_inactive" => "El usuario {0} se encuentra actualmente inactivo",
				"user_message_bloqued" => "El usuario {0} se encuentra actualmente bloqueado",
				"user_message_addedUser" => "El usuario {0} ha sido agregado exitosamente",
				"user_message_errorAdding" => "Ha ocurrido un error al intentar agregar el usuario",
				"user_message_updatedUser" => "El usuario {0} ha sido actualizado exitosamente",
				"user_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el usuario",
				"user_message_confirmDelete" => "¿Est&aacute; seguro de eliminar este usuario?",
				"user_message_errorDelete" => "Ha ocurrido un error al tratar de eliminar el usuario",
				"user_note_userLogin" => "Este es el dato que se usa para autenticarse en la aplicaci&oacute;n",
				
				"slider_message_addedItem" => "El item ha sido agregado exitosamente",
				"slider_message_errorAdding" => "Ha ocurrido un error al intentar agregar el item",
				"slider_message_updatedItem" => "El item ha sido actualizado exitosamente",
				"slider_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el item",
				"slider_lable_informationItem" => "Informaci&oacute;n Item",				
				"slider_image_name" => "Nombre imagen",				
				"slider_message_exampleULR" => "ejemplo: http://www.google.com/",				
				
				"validationSlider_titleRequired" => "El t&iacute;tulo es requerido (Espa&ntilde;ol)",
				"validationSlider_imageRequired" => "La imagen es requerida (Espa&ntilde;ol)",
				"validationSlider_contentRequired" => "El contenido es requerido (Espa&ntilde;ol)",
				"validationSlider_englishRequired" => "No haz completado toda la informaci&oacute;n en ingl&eacute;s, deseas continuar?<br />(Recuerda que es la informaci&oacute;n para los visitantes que prefieren ver la p&aacute; en ingl&eacute;s)",
				"validationSlider_urlValidation" => "La URL que ingresaste es inv&aacute;lida",
				
				"content_message_addedItem" => "El contenido ha sido agregado exitosamente",
				"content_message_errorAdding" => "Ha ocurrido un error al intentar agregar el contenido",
				"content_message_updatedItem" => "El contenido ha sido actualizado exitosamente",
				"content_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el contenido",
				
				"validationContent_titleRequired" => "El t&iacute;tulo es requerido (Espa&ntilde;ol)",
				"validationContent_contentRequired" => "El contenido es requerido (Espa&ntilde;ol)",
				"validationContent_englishRequired" => "No haz completado toda la informaci&oacute;n en ingl&eacute;s, deseas continuar?<br />(Recuerda que es la informaci&oacute;n para los visitantes que prefieren ver la p&aacute; en ingl&eacute;s)",
				
				
				"validationServiceType_nameRequired" => "El nombre es requerido (Espa&ntilde;ol)",
				"validationServiceType_nameRequired_e" => "El nombre es requerido (ingl&eacute;s)",
				"service_type_message_added" => "El tipo de servicio '{0}' ha sido agregado exitosamente",
				"service_type_message_errorAdding" => "Ha ocurrido un error al intentar agregar el tipo de servicio",
				"service_type_message_updated" => "El tipo de servicio '{0}' ha sido actualizado exitosamente",
				"service_type_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el tipo de servicio",
				
				"service_message_added" => "El servicio '{0}' ha sido agregado exitosamente",
				"service_message_errorAdding" => "Ha ocurrido un error al intentar agregar el servicio",
				"service_message_updated" => "El servicio '{0}' ha sido actualizado exitosamente",
				"service_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el servicio",
				
				"serviceValidation_serviceTypeRequired" => "El tipo de servicio es obligatorio",
				"serviceValidation_nameRequired" => "El nombre del servicio es obligatorio (Espa&ntilde;ol)",
				"serviceValidation_summaryRequired" => "El resumen del servicio es obligatorio (Espa&ntilde;ol)",
				"serviceValidation_imageRequired" => "La imagen del servicio en obligatoria (Espa&ntilde;ol)",
				"serviceValidation_nameRequired_e" => "El nombre del servicio es obligatorio (Ingl&eacute;s)",
				"serviceValidation_summaryRequired_e" => "El resumen del servicio es obligatorio (Ingl&eacute;s)",
				"serviceValidation_imageRequired_e" => "La imagen del servicio en obligatoria (ingl&eacute;s)",
				
				"gallery_message_added" => "La galer&iacute;a '{0}' ha sido agregada exitosamente",
				"gallery_message_errorAdding" => "Ha ocurrido un error al intentar agregar la galer&iacute;a",
				"gallery_message_updated" => "La galer&iacute;a '{0}' ha sido actualizada exitosamente",
				"gallery_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar la galer&iacute;a",
				"gallery_message_successWarningImages" => "&Eacute;xito al realizar la operaci&oacute;n, pero ha ocurrido un error al tratar de procesar la totalidad de las imagenes",
								
				"galleryValidation_nameRequired" => "El nombre de la galer&iacute;a es requerido (Espa&ntilde;ol)",
				"galleryValidation_nameRequired_e" => "El nombre de la galer&iacute;a es requerido (Ingl&eacute;s)",
				"galleryValidation_imagesRequired" => "Debes de cargar por lo menos una imagen",
				
				
				"video_message_added" => "El video '{0}' ha sido agregado exitosamente",
				"video_message_errorAdding" => "Ha ocurrido un error al intentar agregar el video",
				"video_message_updated" => "El video '{0}' ha sido actualizado exitosamente",
				"video_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el video",
				
				"videoValidation_nameRequired" => "El nombre del video es requerido (Espa&ntilde;ol)",
				"videoValidation_nameRequired_e" => "El nombre del video es requerido (Ingl&eacute;s)",
				"videoValidation_typeRequired" => "El tipo de video es requerido",
				"videoValidation_typeValueYTRequired" => "La ruta del video de youtube es requerida",
				"videoValidation_typeValuePCRequired" => "El video es requerido",
				"videoValidation_formatVideoValidate" => "El formato del video que intentas cargar no est&aacute; permitido. Formatos permitidos: [.flv, .mp4, .mp3]",
				"videoValidation_noExistsValidate" => "La URL que especificas de YouTube no existe o no puede ser reconocida, verif&iacute;cala e intenta nuevamente.",
				"videoValidation_imageRequired" => "La imagen del video es requerida.",
				
				"contactUs_responseValidate" => "La respuesta es requerida",
				"contactUs_success" => "La respuesta ha sido enviada exitosamente",
				"contactUs_error" => "Ha ocurrido un error al tratar de enviar la respuesta, por favor intenta m&aacute;s tarde.",
				
				"faq_message_addedItem" => "El FAQ ha sido agregado exitosamente",
				"faq_message_errorAdding" => "Ha ocurrido un error al intentar agregar el FAQ",
				"faq_message_updatedItem" => "El FAQ ha sido actualizado exitosamente",
				"faq_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el FAQ",
				
				"validationFaq_queryRequired" => "La pregunta es requerida (Espa&ntilde;ol)",
				"validationFaq_answerRequired" => "La respuesta es requerida (Espa&ntilde;ol)",
				"validationFaq_queryRequired_e" => "La pregunta es requerida (English)",
				"validationFaq_answerRequired_e" => "La respuesta es requerida (English)",

				"validationCharge_nameRequired" => "El nombre es requerido (Espa&ntilde;ol)",
				"validationCharge_nameRequired_e" => "El nombre es requerido (ingl&eacute;s)",
				"charge_message_added" => "El cargo '{0}' ha sido agregado exitosamente",
				"charge_message_errorAdding" => "Ha ocurrido un error al intentar agregar el cargo",
				"charge_message_updated" => "El cargo '{0}' ha sido actualizado exitosamente",
				"charge_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar el cargo",

				"personal_message_added" => "'{0}' ha sido agregado exitosamente al personal",
				"personal_message_errorAdding" => "Ha ocurrido un error al intentar agregar al personal",
				"personal_message_updated" => "'{0}' ha sido actualizado exitosamente",
				"personal_message_errorUpdating" => "Ha ocurrido un error al intentar actualizar",
				"" => "",
				"" => "",
				"" => "",
				"" => "",
				"" => "",
				"" => "",


			);
		} elseif ($lang == "en") {
			
		}
	}
	
	/**
	*	Función responsable de obtener el lenguaje que se usará en la app para los visitantes.
	*	@parameter lang: lenguaje a mostrar en la app.
	*	@return array, array con el idioma cargado para mostrar en la app.
	*/
	function getLanguajePublic($lang="es") {
		if ($lang == "es") {
			return array (
				"app_menu_service" => "servicio",
				"app_menu_gallery" => "galeria",
				"app_menu_videos" => "videos",
				
				"general_languaje" => "Idioma",
				"general_follow_us" => "S&iacute;guenos",
				"general_english" => "English",
				"general_spanish" => "Espa&ntilde;ol",
				"general_principal_office" => "Oficina Principal",
				"general_site_map" => "Mapa de sitio",
				"general_contact_us" => "Cont&aacute;ctenos",
				"general_contact_us_text" => "Si tienes preguntas o inquietudes env&iacute;alas mediante el siguiente formulario, tendremos el gusto de atenderte.",
				"general_send" => "Enviar",
				"general_our_personal" => "Nuestro personal",
				"general_social_information" => "Informacion Social",
				"general_showing" => "Mostrando {0}-{1} de {2}",
				"general_no_data" => "No se encontraron datos",
				"general_preview" => "Anterior",
				"general_next" => "Siguiente",
				"general_name" => "Nombre",
				"general_email" => "Correo electr&oacute;nico",
				"general_phone" => "Tel&eacute;fono",
				"general_country_state_city" => "Pa&iacute;s / Estado / Ciudad",
				"general_question_concern" => "Preguntas / inquietudes",
				"general_error" => "Error",
				"general_alert" => "Alerta",
				"general_information" => "Informaci&oacute;n",
				"general_confirm" => "Confirmar",
				"general_calcel" => "Cancelar",
				"general_acept" => "Aceptar",
				"general_loading" => "Cargando",
				"general_info_send" => "Tu informaci&oacute;n ha sido enviada exitosamente",
				"general_error_send" => "Ha ocurrido un error al tratar de enviar tu informaci&oacute;n, por favor intenta m&aacute;s tarde",
				"general_error_send_short" => "Error al enviar la informaci&oacute;n",
				"general_photos" => "Fotos",
				
				"validationContactUs_nameRequired" => "Tu nombre es requerido",
				"validationContactUs_emailPhoneRequired" => "Tu email y/o tel&eacute;fono es requerido",
				"validationContactus_emailValidation" => "El correo electr&oacute;nico es inv&aacute;lido",
				"validationContactUs_queryConcernRequired" => "Tu pregunta / inquietud es requerida",
				
				"validationContactUs_allDataRequired" => "Debes de llenar todos los campos",
			);
		} elseif ($lang == "en") {
			return array (
				"app_menu_service" => "service",
				"app_menu_gallery" => "gallery",
				
				"general_languaje" => "Language",
				"general_follow_us" => "Follow us",
				"general_english" => "English",
				"general_spanish" => "Espa&ntilde;ol",
				"general_principal_office" => "Principal Office",
				"general_site_map" => "Site map",
				"general_contact_us" => "Contact Us",
				"general_contact_us_text" => "For questions or restlessness send them using the form below, we will be happy to assist you.",
				"general_send" => "Send",
				"general_our_personal" => "Our personal",
				"general_social_information" => "Social Information",
				"general_showing" => "Showing {0}-{1} of {2}",
				"general_no_data" => "No data found",
				"general_preview" => "Preview",
				"general_next" => "Next",
				"general_name" => "Name",
				"general_email" => "Email",
				"general_phone" => "Phone",
				"general_country_state_city" => "Country / State / City",
				"general_question_concern" => "Questions / restlessness",
				"general_error" => "Error",
				"general_alert" => "Alert",
				"general_information" => "Information",
				"general_confirm" => "Confirm",
				"general_calcel" => "Cancel",
				"general_acept" => "Acept",
				"general_loading" => "Loading",
				"general_info_send" => "Your information has been sent successfully",
				"general_error_send" => "An error occurred while trying to send your information, please try again later",
				"general_error_send_short" => "Failed to send information",
				"general_photos" => "photos",
				
				"validationContactUs_nameRequired" => "your name is required",
				"validationContactUs_emailPhoneRequired" => "Your email and / or phone number is required",
				"validationContactus_emailValidation" => "The email is invalid",				
				"validationContactUs_queryConcernRequired" => "your question / restlessness is required",
				
				"validationContactUs_allDataRequired" => "You must fill in all fields",
				
			);
		}
	}
	
	/**
	*	Función reponsable de reemplazar en un mensaje los valores dinamicos 
	*	del mismo. Ej: con los parámetros: 
	*							$message="hola {0} hoy es {1}", 
	*							$args=array("mundo", "lunes") 
	*			   retorna: 
	*							"hola mundo hoy es lunes"
	*	@parameters message: mensaje a ser modificado.
	*				args: array de valores para reemplazar en el mensaje.
	*	@return String, mensaje con los valores reemplazados.
	*/
	function replaceMessage($message, $args=array()) {
		$amountItems = count ($args);
		for ($i=0; $i < $amountItems; $i++) {
			$message = str_replace("{".$i."}", $args[$i], $message);
		}		
		return $message;
	}
	
	
	/**
	*	Función responsable de convertir una fecha a otro formato.
	*  	tipe = 1: yyyy-mm-dd => dd/mm/yyyy. desde el modelo a la vista
	*  	tipe = 2: dd/mm/yyyy => yyyy-mm-dd. desde la vista al modelo.
	*  	tipe = 3: yyyy-mm-dd => mm/dd/yyyy. desde el modelo a la vista, formato inglés.
	*  	tipe = 4: mm/dd/yyyy => yyyy-mm-dd. desde la vista al modelo, formato inglés.
	*/	
	function changeFormatDate($date, $type, $isDatatime = false, $getTime = true) {
		$hour = "";
		
		if (empty($date)) {
			return "";	
		}
		
		if ($isDatatime) {			
			$hour = substr($date, 10,19);
			$date = substr($date, 0,10);
		} else {
			$getTime = false;	
		}
		
		$date = trim ($date);
		
		switch($type) {
			case 1: $aux = explode('-', $date);
				$dateFormat = $aux[2]."/".$aux[1]."/".$aux[0];
			break;
			case 2:	$aux = explode('/', $date);
				$dateFormat = $aux[2]."-".$aux[1]."-".$aux[0];
			break;
			case 3: $aux = explode('-', $date);
				$dateFormat = $aux[1]."/".$aux[2]."/".$aux[0];
			break;
			case 4:	$aux = explode('/', $date);
				$dateFormat = $aux[2]."-".$aux[0]."-".$aux[1];
			break;
		}
		
		if ($getTime) {
			return $dateFormat.' '.$hour;
		} else {
			return $dateFormat;	
		}
	}
	
	/**
	*	Trunca un texto largo para cuando se necesita solo una parte
	* 	@param $string Texto que va a ser truncado
	* 	@param $length Este determina para cuantos car�cteres truncar.
	* 	@param $etc Este es el texto para adicionar si el truncamiento ocurre. La longitud NO se incluye para la logitud del truncamiento
	* 	@param $break_words Este determina cuando truncar o no o al final de una palabra(false), o un car�cter 	exacto(true).
	* 	@param $middle Este determina cuando ocurre el truncamiento al final de la cadena(false), o en el centro de la 	
	*				cadena(true). Nota cuando este es true, entonces la palabra limite es ignorada.
	* 	@return String
	*/
	function truncate($string, $length = 80, $etc = '...',$break_words = false, $middle = false) {
	    if ($length == 0) {
	        return '';
		}
		
	    if (strlen ($string) > $length) {
	        $length -= strlen ($etc);
	        if (!$break_words && !$middle) {
	            $string = preg_replace ('/\s+?(\S+)?$/', '', substr ($string, 0, $length+1));
	        }
			
	        if(!$middle) {
	            return substr ($string, 0, $length).$etc;
	        } else {
	            return substr ($string, 0, $length/2) . $etc . substr($string, -$length/2);
	        }
	    } else {
	        return $string;
	    }
	}
		
	/**
	*	Funcion encargada de enviar los emails en la aplicación.
	*	@autor: JSL
	*	@date: 09 DIC 2011
	*/
	function sendApplicationEmail($data){
		include_once("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		
		$mail->Body = sendEmailSite($data->email_body);
		
		foreach($data->email_address as $address)
			$mail->AddAddress($address);
		
		for($i=0; $i < count($data->email_attachment); $i++) {
			$mail->AddAttachment($data->email_attachment[$i], $data->email_attachment_name[$i]);
		}
		
		if(isset($data->email_from) && $data->email_from != "")
			$mail->From = $data->email_from;		
		
		if(isset($data->email_fromName) && $data->email_fromName != "")
			$mail->FromName = $data->email_fromName;
		
		if(isset($data->email_sender) && $data->email_sender != "")
			$mail->sender = $data->email_sender;
		
		if(isset($data->email_subject) && $data->email_subject != "")		
			$mail->Subject = $data->email_subject;
		else
			$mail->Subject = "";
		
		return $mail->send();
	}
	
	/**
	*	Firma de la aplicacion
	*/
	function sendEmailSite($body){
		return '<div>'.$body.'</div><div>Signature site...</div>';
	}
	
	/**
	 * Función responsable de dar el formato necesario a un texto para que pueda ser utilizado en una URL semántica.
	 * @parameters $string: representa la cadena a la cuál se le dará formato.
	 * @return String, cadena con el formato necesario para la URL.
	 */
	function formatToUrl($string) {
		if ( @preg_match ('/.+/u', $string) ) {
			$string = utf8_decode ($string);
		}
	   
		$string = htmlentities ($string);
		$string = preg_replace ('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$string);
		$string = html_entity_decode ($string);
		$string = strtolower ($string);
		$string = str_replace ("Ã§","c",$string);
		$string = preg_replace ('@[ =()/\'\"\:\+\!\â€œ\â€�\â€˜\â€™\Â¡\Â¿\?\Âº\,\;\$\&\#\%\Â´\Â·\.\@\Â«\Â»]+@','_',trim($string));
		$string = preg_replace ('@[\W]+@','_',$string);
		$string = preg_replace ('@[-]*[^A-Za-z0-9._,]@','_',$string);
		$string = preg_replace ('@^[-]@','',$string);
		$string = preg_replace ('@([-])$@','',$string);
		
		$string = strtolower($string);
		
		return $string;
	}
	
?>