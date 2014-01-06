<?php include("src/home_cs.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $messages["general_title_welcome"]." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script src="js/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script language="javascript" type="text/javascript">
	function copyInfo(id_obj_from, id_obj_to, component){
		var id_content = '';
		var response = '<li style="display: block;"><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/><input type="hidden" name="app_background" id="app_background" value=""/></li>';
		
		if (component.checked) {		
			var value_obj_from = document.getElementById(id_obj_from).value;			
			
			if (file_exists('../file_upload/background/' + value_obj_from) && file_exists('../file_upload/background/thumb-' + value_obj_from)) {
				response = '<li style="display: block;"><img src="../file_upload/background/thumb-' + value_obj_from + '" style="border:0px" width="500" height="300"/><input type="hidden" name="' + id_obj_to + '" id="' + id_obj_to + '" value="' + value_obj_from +'"/></li>';
				//flagSave = false;
			} else if (file_exists('../file_upload/images_bank/' + value_obj_from) && file_exists('../file_upload/images_bank/thumb-' + value_obj_from)) {
				response = '<li style="display: block;"><img src="../file_upload/images_bank/thumb-' + value_obj_from + '" style="border:0px" width="500" height="300"/><input type="hidden" name="' + id_obj_to + '" id="' + id_obj_to + '" value="' + value_obj_from +'"/></li>';
				//flagSave = false;
			}
			
			id_content = id_obj_to;			
		} else {
			var value_obj_to_prev = document.getElementById(id_obj_to + '_prev').value;
			
			if (file_exists('../file_upload/background/' + value_obj_to_prev) && file_exists('../file_upload/background/thumb-' + value_obj_to_prev)) {
				response = '<li style="display: block;"><img src="../file_upload/background/thumb-' + value_obj_to_prev + '" style="border:0px" width="500" height="300"/><input type="hidden" name="' + id_obj_to + '" id="' + id_obj_to + '" value="' + value_obj_to_prev +'"/></li>';
				//flagSave = false;
			}
			
			id_content = id_obj_to;
		}
		
		if (id_content != '') {
			$("#div_content_" + id_content).html(response).fadeIn("fast");
			$("#div_content_" + id_content + " li").eq(0).hide().show("slow");
		}
	}
	/*--------------------*/
	
	function paintBgElement(element) {
		if (element) {
			element.style.backgroundColor = "#FFDAD6";
		}
	}
	
	function saveInfo(event, code, element, table) {		
		var field = element.name;
		var field_value = element.value;
		
		var keyEvent = null;
		if (event != null) {
			var keyEvent = event.keyCode ? event.keyCode: event.which ? event.which : event.charCode;
		} else {
			var keyEvent = 13;	
		}
	
		var isBackgroundImage = false;
		var parameterAux = "";
		var msg = '';
		if (field == 'app_background' || field == 'app_background_e') {
			isBackgroundImage = true;
			parameterAux = "&" + field + "_prev=" + document.getElementById(field + "_prev").value;
			
			if (field_value == '') {
				msg += "<?php echo $messages["general_message_imageHomeValidation"];?>";	
			}
		}
		
		if ((keyEvent == 13 || event == null) && msg == '') {
			jQuery.ajax({
				type : "POST",
				async : false,
				url : "ajaxHome.php",
				data : 'field=' + field + "&field_value=" + field_value + "&code=" + code + "&table=" + table + parameterAux + "&flagSave=" + flagSave + "&flagSave_e=" + flagSave_e,
				success : function(result) {
					if (result.indexOf("-1") != -1) {
						coolMessage('error', "<?php echo $messages["general_errorSaving"];?>");
					} else if (result.indexOf("1") != -1) {
						element.style.backgroundColor = "#FFF";
						
						if (field == 'app_background_color') {
							document.getElementById("app_background_color_prev").value = field_value;
						} else if (field == 'app_background') {
							flagSave = false;
						} else if (field == 'app_background_e') {
							flagSave_e = false;
						}
						
						if (isBackgroundImage == true) {
							document.getElementById(field + "_prev").value = field_value;
						}
					} 
				}
			});
		} else if (keyEvent != 9) {
			element.style.backgroundColor = "#FFDAD6";
		} else if (msg != '') {
			coolMessage("alert", msg);
		}
	}
	
	function saveInformationApp(btn, element_id, code, table) {		
		var element = document.getElementById(element_id);

		if (element) {
			btn.value = "<?php echo $messages["general_saving"];?>...";
			saveInfo(null, code, element, table);
			btn.value = "<?php echo $messages["general_save"];?>";			
		} else {
			coolMessage("error", "<?php echo $messages["general_errorSaving"];?>");
		}
	}
	
	function changeBgType(type) {
		var bg_color = document.getElementById("bg_color");
		var bg_image = document.getElementById("bg_image");
		var colorPreview = document.getElementById("content_color");
				
		switch (type) {
			case 1:
				colorPreview.style.backgroundColor = "#F2F2F2";
				document.getElementById("app_background_color").value = "#F2F2F2";				
				bg_color.style.display = displayRow;
				bg_image.style.display = 'none';
			break;
			case 2:
				bg_color.style.display = 'none';
				bg_image.style.display = displayRow;				
			break;
			
			case 3:
				var app_background_color_prev = document.getElementById("app_background_color_prev").value;
				colorPreview.style.backgroundColor = app_background_color_prev;
				document.getElementById("app_background_color").value = app_background_color_prev;				
				bg_color.style.display = displayRow;
				bg_image.style.display = 'none';				
			break;	
		}
		
		return false;
	}
	
	var flagSave = false;//bandera que se activa cuando existe una imagen para cambiar el background (español)
	var flagSave_e = false;//bandera que se activa cuando existe una imagen para cambiar el background (ingels)
	
	$(document).ready(function(){
		
		var button = $('#upload'), interval;
		
		new AjaxUpload(button,{
			action: 'processingImage.php', 
			name: 'image',
			data: '1',
			onSubmit : function(file, ext){
				// cambiar el texto del boton cuando se selecicione la imagen		
				button.val('<?php echo $messages["general_uploading"];?>');
				// desabilitar el boton
				this.disable();
				
				interval = window.setInterval(function(){
					var text = button.val();
					if (text.length < 11){
						button.val(text + '.');
					} else {
						button.val('<?php echo $messages["general_uploading"];?>');
					}
				}, 200);
			},
			onComplete: function(file, response){
				button.val('<?php echo $messages["general_load_image"]." (".html_entity_decode ($messages["general_spanish"]).")";?>');
							
				window.clearInterval(interval);
							
				// Habilitar boton otra vez
				this.enable();
				if (response == -1) {//formato no permitido
					coolMessage("alert", "<?php echo replaceMessage($messages["general_message_invalidImageExtension"], array ("[.jpg, .png, .gif]"));?>");
				} else {
					flagSave = true;
					$('#div_content_app_background').html(response).fadeIn("fast");
					$('#div_content_app_background li').eq(0).hide().show("slow");
				}
			}
		});
				
		// Eliminar		
		$("#div_content_app_background li a").live("click",function(){
			var a = $(this)
			$.get("processingImage.php?action=delete", {id:a.attr("id")}, function() {
				a.parent().fadeOut("slow");
				
				var app_background_prev = $.trim(document.getElementById("app_background_prev").value);
				var response = '<li style="display: block;"><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/><input type="hidden" name="app_background" id="app_background" value=""/></li>';
				
				if (app_background_prev != "") {
					if (file_exists('../file_upload/background/' + app_background_prev) && file_exists('../file_upload/background/thumb-' + app_background_prev)) {
						response = '<li style="display: block;">'
								 + '<img src="../file_upload/background/thumb-' + app_background_prev + '" style="border:0px" width="500" height="300"/>' 
								 + '<input type="hidden" name="app_background" id="app_background" value="' + app_background_prev +'"/>'
								 + '</li>';
						flagSave = false;
					}
				}
				
				$('#div_content_app_background').html(response).fadeIn("fast");
				$('#div_content_app_background li').eq(0).hide().show("slow");
			})
		})
		
		//en
		
		var button_e = $('#upload_e'), interval;
		
		new AjaxUpload(button_e,{
			action: 'processingImage.php', 
			name: 'image',
			data: '2',
			onSubmit : function(file, ext){
				// cambiar el texto del boton cuando se selecicione la imagen		
				button_e.val('<?php echo $messages["general_uploading"];?>');
				// desabilitar el boton
				this.disable();
				
				interval = window.setInterval(function(){
					var text = button_e.val();
					if (text.length < 11){
						button_e.val(text + '.');
					} else {
						button_e.val('<?php echo $messages["general_uploading"];?>');
					}
				}, 200);
			},
			onComplete: function(file, response){
				button_e.val('<?php echo $messages["general_load_image"]." (".html_entity_decode ($messages["general_english"]).")";?>');
				
				window.clearInterval(interval);
							
				// Habilitar boton otra vez
				this.enable();
				
				if (response == -1) {//formato no permitido
					coolMessage("alert", "<?php echo replaceMessage($messages["general_message_invalidImageExtension"], array ("[.jpg, .png, .gif]"));?>");
				} else {
					flagSave_e = true;
					$('#div_content_app_background_e').html(response).fadeIn("fast");
					$('#div_content_app_background_e li').eq(0).hide().show("slow");
				}
			}
		});
				
		// Eliminar
		$("#div_content_app_background_e li a").live("click",function(){
			var a = $(this)
			$.get("processingImage.php?action=delete", {id:a.attr("id")}, function() {
				a.parent().fadeOut("slow");
				var app_background_prev = $.trim(document.getElementById("app_background_e_prev").value);
				var response = '<li style="display: block;"><img src="../images/broken-image.png" style="border:0px" width="500" height="300"/><input type="hidden" name="app_background_e" id="app_background_e" value=""/></li>';
				
				if (app_background_prev != "") {
					if (file_exists('../file_upload/background/' + app_background_prev) && file_exists('../file_upload/background/thumb-' + app_background_prev)) {
						response = '<li style="display: block;"><img src="../file_upload/background/thumb-' + app_background_prev + '" style="border:0px" width="500" height="300"/><input type="hidden" name="app_background_e" id="app_background_e" value="' + app_background_prev +'"/></li>';
						flagSave_e = false;
					}
				}
				
				$('#div_content_app_background_e').html(response).fadeIn("fast");
				$('#div_content_app_background_e li').eq(0).hide().show("slow");
			})
		})
	});
	
</script>
<?php require ("pick.php");?>
</head>
<body onload="javascript: showMessage(<?php echo $messageShow;?>)">
	<?php $item_select = 0; include ("menu.php");?>
    <div class="content_grv">
        <table class="tbl_list">
			<tr>
                <td><label class="title"><?php echo $messages["general_genaral_configuration"];?></label></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            
            <tr>
            	<td>
                	<label class="subtitle"><?php echo $messages["general_background_type"];?>:</label>
                    
                    <input type="radio" name="app_background_type" id="app_background_type1" value="1" <?php echo $checked1;?> onclick="changeBgType(1)"/>
                    <label class="lbl_black"><?php echo $messages["general_default"];?></label>
                    
                    <input type="radio" name="app_background_type" id="app_background_type2" value="2" <?php echo $checked2;?> onclick="changeBgType(2)"/>
					<label class="lbl_black"><?php echo $messages["general_image"];?></label>
                    
                    <input type="radio" name="app_background_type" id="app_background_type3" value="3" <?php echo $checked3;?> onclick="changeBgType(3)"/>
                    <label class="lbl_black"><?php echo $messages["general_color"];?></label>                    
				</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            
			<tr id="bg_color" <?php if ($app_background_type == 2) {?> style="display:none" <?php }?>>
            	<td>
                	<table width="100%">
                    	<tr>
                        	<td colspan="2"><label class="subtitle"><?php echo $messages["general_background_color"];?>:</label><hr /></td>
                        </tr>
                        <tr>
                        	<td width="5%">
                            	<div id="colorSelector2">
                                    <div id="content_color" style="background-color: <?php echo $app_background_color;?>"></div>
                                    
                                 </div>
                                
                                <div id="colorpickerHolder2">
                                    
                                </div>
                                <input type="hidden" id="app_background_color" name="app_background_color" value="<?php echo $app_background_color;?>" />                                
                                <input type="hidden" id="app_background_color_prev" value="<?php echo $app_background_color;?>" name="app_background_color_prev"/>
							</td>
                            <td>
                            	<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" id="app_background_color_button"
                                	onclick="saveInformationApp(this, 'app_background_color', <?php echo $app_code;?>, 'general_app')"/>
                            </td>
                        </tr>
                    </table>
				</td>
            </tr>
            <tr id="bg_image" <?php if ($app_background_type != 2) {?> style="display:none" <?php }?>>
            	<td>
                	<label class="subtitle"><?php echo $messages["general_background_image"];?></label><hr />
                	<table width="100%">
                    	<tr>
                        	<td width="45%" valign="top">
                            	<div style="margin:10px;">
	                                <input type="hidden" name="app_background_prev" id="app_background_prev" value='<?php echo $dataApp->app_background;?>'/>
                                
	                                <div class="div_items">
	                                    <div class="item">
	                                    	<input type="button" id="upload" class="w8-icon l-blue" value="<?php echo $messages["general_load_image"]." (".$messages["general_spanish"].")";?>" style="width:200px; margin:0px;"/>
	                                    </div>
	                                    <div class="item">
	                                    	<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>"  id="app_background_button"
	                                	onclick="saveInformationApp(this, 'app_background', <?php echo $app_code;?>, 'general_app')"/>
	                                    </div>
	                                </div>
                                </div>
                                <div id="div_content_app_background" class="ajax_upload">
                                    <?php echo $app_background;?>
                                </div>
                                <div id="check_imagen" <?php if (empty ($app_background)) {?>style="display:none"<?php }?>>
                                <br />
                                <input type="checkbox" name="check_imagen" onclick="javascript: copyInfo('app_background', 'app_background_e', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_english"];?></label></div>
                                
                            </td>
                            <td width="10%">&nbsp;</td>
                            <td valign="top">
                            	<div style="margin:10px;">
	                                <input type="hidden" name="app_background_e_prev" id="app_background_e_prev" value='<?php echo $dataApp->app_background_e;?>'/>
                            		<div class="div_items">
	                                    <div class="item">
	                                    	<input type="button" id="upload_e" class="w8-icon l-blue" value="<?php echo $messages["general_load_image"]." (".$messages["general_english"].")";?>" style="width:200px; margin:0px;"/>
	                                    </div>
	                                    <div class="item">
	                                    	<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" id="app_background_e_button"
	                                	onclick="saveInformationApp(this, 'app_background_e', <?php echo $app_code;?>, 'general_app')"/>
	                                    </div>
	                                </div>	                                
                                </div>
                                <div id="div_content_app_background_e" class="ajax_upload">
                                    <?php echo $app_background_e;?>
                                </div>
                                <div id="check_imagen_e" <?php if (empty ($app_background_e)) {?>style="display:none"<?php }?>>
                                <br />
                                <input type="checkbox" name="check_imagen_e" onclick="javascript: copyInfo('app_background_e', 'app_background', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_spanish"];?></label></div>
                            </td>
                        </tr>
                    </table>                	
				</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
            	<td><label class="lbl_gray"><?php echo $messages["general_slogan"].' ('.$messages["general_spanish"].')';?>:</label></td>
            </tr>
            <tr>
            	<td>
                	<input type="text" name="app_slogan" id="app_slogan" class="text_grv" size="100" maxlength="100" 
                    value="<?php echo $app_slogan;?>" onKeyUp="return saveInfo(event, <?php echo $app_code;?>, this, 'general_app')"/>
				</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
            	<td><label class="lbl_gray"><?php echo $messages["general_slogan"].' ('.$messages["general_english"].')';?>:</label></td>
            </tr>
            <tr>
            	<td>
                	<input type="text" name="app_slogan_e" id="app_slogan_e" class="text_grv" size="100" maxlength="100" 
                        value="<?php echo $app_slogan_e;?>"
                        onKeyUp="return saveInfo(event, <?php echo $app_code;?>, this, 'general_app')"/>
				</td>
            </tr>
            
            
            <tr><td>&nbsp;</td></tr>
            <tr>
            	<td>
                	<table width="100%">
                    	<tr>
                        	<td width="35%">
                            	<label class="lbl_gray"><?php echo $messages["general_information_office"].' ('.$messages["general_spanish"].')';?>:</label>
                            </td>
                            <td width="35%">
                            	<label class="lbl_gray"><?php echo $messages["general_information_office"].' ('.$messages["general_english"].')';?>:</label>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td valign="bottom">
                            	<textarea cols="25" rows="12" class="text_grv" name="app_information_office" id="app_information_office" onkeyup="paintBgElement(this); limitLength(this, 'numero', <?php echo $maxlength_app_information_office;?>)"><?php echo $app_information_office;?></textarea>
                                
                                <label id="numero" class="note"><?php echo $messages["general_messageCharacters"].($maxlength_app_information_office - strlen ($app_information_office));?></label>
                                
                                <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" style="float:right;"
                                	onclick="saveInformationApp(this, 'app_information_office', <?php echo $app_code;?>, 'general_app')"/>
                            </td>
                            <td valign="bottom">
                            	<textarea cols="25" rows="12" class="text_grv" name="app_information_office_e" id="app_information_office_e" onkeyup="paintBgElement(this); limitLength(this, 'numero_e', <?php echo $maxlength_app_information_office_e;?>)"><?php echo $app_information_office_e;?></textarea>
                                
                                <label id="numero_e" class="note"><?php echo $messages["general_messageCharacters"].($maxlength_app_information_office_e - strlen ($app_information_office_e));?></label>
                                
                                <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" style="float:right;"
                                	onclick="saveInformationApp(this, 'app_information_office_e', <?php echo $dataApp->app_code;?>, 'general_app')"/>
                            </td>
                            <td valign="bottom">&nbsp;
                            	
                            </td>
                        </tr>                        
                    </table>
                </td>
            </tr>
            
            <tr>
            	<td>
                	<table width="100%">
                    	<tr>
                        	<td width="28%">
                            	<label class="lbl_gray"><?php echo $messages["general_keywords"].' ('.$messages["general_spanish"].')';?>:</label>
                            </td>
                            <td width="28%">
                            	<label class="lbl_gray"><?php echo $messages["general_keywords"].' ('.$messages["general_english"].')';?>:</label>
                            </td>
                            <td>&nbsp;</td>
                        </tr>                       
                        
                        <tr>
                        	<td valign="top">
                            	<textarea cols="18" rows="6" class="text_grv" name="app_keywords" id="app_keywords" onkeyup="paintBgElement(this); limitLength(this, 'numero_k', <?php echo $maxlength_app_keywords;?>)"><?php echo $app_keywords;?></textarea>
                                
                                <label id="numero_k" class="note"><?php echo $messages["general_messageCharacters"].($maxlength_app_keywords - strlen ($app_keywords));?></label>
                                
                                <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" style="float:right;"
                                	onclick="saveInformationApp(this, 'app_keywords', <?php echo $dataApp->app_code;?>, 'general_app')"/>
                            </td>
                            <td valign="top">
                            	<textarea cols="18" rows="6" class="text_grv" name="app_keywords_e" id="app_keywords_e" onkeyup="paintBgElement(this); limitLength(this, 'numero_k_e', <?php echo $maxlength_app_keywords_e;?>)"><?php echo $app_keywords_e;?></textarea>
                                
                                <label id="numero_k_e" class="note"><?php echo $messages["general_messageCharacters"].($maxlength_app_keywords_e - strlen ($app_keywords_e));?></label>
                                
                                <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"];?>" style="float:right;"
                                	onclick="saveInformationApp(this, 'app_keywords_e', <?php echo $dataApp->app_code;?>, 'general_app')"/>
                            </td>
                            <td valign="top" class="note_important">
								<?php echo $messages["general_note_keywords"];?> 
							
								<a href="http://support.google.com/adwords/bin/answer.py?hl=es-419&answer=2453981&from=16928&rd=1" target="_blank"><?php echo $messages["general_more_tips"];?></a>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
        <br />
        <br />
        <br />
	</div>
    <?php include ("footer.php");?>
</body>
</html>
<?php include('divscoolmessage.php');?>