<?php include("src/addUpdatePersonal_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script language="javascript" type="text/javascript">
		
	function validate(){
		var msg = "";
		var msgAux = "";
		
		var chg_code = document.getElementById("chg_code").value;
		
		var pers_name = document.getElementById("pers_name").value;
		var pers_profesional_objetive = document.getElementById("pers_profesional_objetive").value;
		var pers_photo_rename = document.getElementById("pers_photo_rename").value;
		
		if (chg_code == "") {
			msg += "- <?php echo $messages["serviceValidation_serviceTypeRequired"];?><br />";
		}
		
		if (pers_name == "") {
			msg += "- <?php echo $messages["serviceValidation_nameRequired"];?><br />";
		}
		
		if (pers_profesional_objetive == "") {
			msg += "- <?php echo $messages["serviceValidation_summaryRequired"];?><br />";
		}
		
		if (pers_photo_rename == "") {
			msg += "- <?php echo $messages["serviceValidation_imageRequired"];?><br />";
		}
		
		if (pers_name_e == "") {
			msg += "- <?php echo $messages["serviceValidation_nameRequired_e"];?><br />";
		}
		
		if (serv_summary_e == "") {
			msg += "- <?php echo $messages["serviceValidation_summaryRequired_e"];?><br />";
		}
		
		if (pers_photo_rename_e == "") {
			msg += "- <?php echo $messages["serviceValidation_imageRequired_e"];?><br />";
		}
				
		if (msg == '') {
			document.getElementById("form1").submit();
			return true;
		} else {
			coolMessage("alert", msg)
			return false;
		}		
	}
	
	function chargerImage(image_rename, input_hidden, div) {	
		document.getElementById(div).innerHTML = '<a href="javascript:;" onclick="javascript: return deleteImage(\''+div+'\')"><img src="images/delete.png" width="16" height="16" alt="<?php echo $messages["general_remove"]?>" /></a><br /><a class="fancytoImage" href="../file_upload/images_bank/'+image_rename+'"><img src="../file_upload/images_bank/'+image_rename+'" width="620" height="465"/></a>';
		
		document.getElementById(input_hidden).value = image_rename;
		
		initFancy();
		
		$.fn.fancybox.close();
		
		if (div == 'div_content_pers_photo_rename') {			
			document.getElementById('check_imagen').style.display = displayRow;
		} else if (div == 'div_content_pers_photo_rename_e') {
			document.getElementById('check_imagen_e').style.display = displayRow;
		}
	}

	function deleteImage(div){
		coolMessage("confirm", "<?php echo $messages["general_message_confirmDeleteImage"]?>", function(){
			clearImage(div);
		});
	}
	
	function clearImage(div) {
		if ( div == 'div_content_pers_photo_rename' ) {
			document.getElementById('pers_photo_rename').value = "";
			document.getElementById('check_imagen').style.display = 'none';
		}
		else if ( div == 'div_content_pers_photo_rename_e' ) {
			document.getElementById('pers_photo_rename_e').value = "";
			document.getElementById('check_imagen_e').style.display = 'none';
		}
		
		document.getElementById(div).innerHTML = '<img src="../images/broken-image.png" width="620" height="465" />';
	}
		
	function copyInfo(id_obj_from, id_obj_to, component){
		if (component.checked) {
			document.getElementById(id_obj_to).value = document.getElementById(id_obj_from).value;
		
			var value_obj_from = document.getElementById(id_obj_from).value;
			
			document.getElementById("div_content_"+id_obj_to).innerHTML = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_'+id_obj_to+'\')"><img src="images/delete.png" width="16" height="16" alt="<?php echo $messages["general_remove"];?>" /></a><br /><a class="fancytoImage" href="../file_upload/images_bank/'+value_obj_from+'"><img src="../file_upload/images_bank/'+value_obj_from+'" width="620" height="465"/></a>';
			initFancy();
		} else {
			clearImage("div_content_"+id_obj_to);
		}
	}
</script>

<!-- TinyMCE -->
<script type="text/javascript" src="../includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	// Default skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "serv_description",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../includes/tinymce/examples/lists/template_list.js",
		external_link_list_url : "../includes/tinymce/examples/lists/link_list.js",
		external_image_list_url : "../includes/tinymce/examples/lists/image_list.js",
		media_external_list_url : "../includes/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

	// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "serv_description_e",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../includes/tinymce/examples/lists/template_list.js",
		external_link_list_url : "../includes/tinymce/examples/lists/link_list.js",
		external_image_list_url : "../includes/tinymce/examples/lists/image_list.js",
		media_external_list_url : "../includes/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"

		}
	});

</script>
<!-- /TinyMCE -->

</head>
<body onload="showMessage('<?php echo $message_show;?>')">
<?php $item_select = 10; include("menu.php");?><br />
    <form name="form1" id="form1" method="post" action="">
    <input type="hidden" name="save" id="save" value="1"/>
    <input type="hidden" name="serv_code" id="serv_code" value="<?php echo $serv_code;?>"/>    
        <div class="content_grv">
            <table width="90%" align="center" class="shadow">
                <tr>
                    <td class="title">
                        <?php echo $titlePage;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tbl_form" align="center">
                        	<tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_general_information"];?></label></td>                                
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            
                            <tr>
                            	<td>&nbsp;</td>
                            	<td align="right"><label class="lbl_gray"><?php echo $messages["general_charges"];?>:</label></td>
                                <td>
                                	<select name="chg_code" id="chg_code" class="text_grv">
                                    	<option value=""><?php echo $messages["general_select"];?>...</option>
                                        <?php 
										for ($i = 0; $i < $countCharges; $i++) {
											if ($data->chg_code == $listCharges[$i]->chg_code) {
												$select = ' selected="selected" ';
											} else {
												$select = '';
											}
										?>
                                        <option value="<?php echo $listCharges[$i]->chg_code;?>" <?php echo $select;?>><?php echo $listCharges[$i]->chg_name;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_spanish"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td width="5%">&nbsp;</td>
                            	<td width="20%" align="right"><label class="lbl_gray"><?php echo $messages["general_name"]." (".$messages["general_spanish"].")";?>:</label></td>
                                <td><input type="text" name="pers_name" id="pers_name" value="<?php echo $pers_name;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_image"]." (".$messages["general_spanish"].")";?>:</label>
								</td>
                                <td>
                                	<a href="addImageJcrop.php?div=div_content_pers_photo_rename&input_hidden=pers_photo_rename&w_ini=620&h_ini=465" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." (".$messages["general_spanish"].")";?></a>
                                    
                                	<div id="div_content_pers_photo_rename" style="width:620; height:465;">
                                        <?php echo $pers_photo_rename_element;?>
                                    </div>
                                    <div id="check_imagen" style="display:none">
                                    <br />
                                    <input type="checkbox" name="check_imagen" onclick="javascript: copyInfo('pers_photo_rename', 'pers_photo_rename_e', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_spanish"];?></label></div>
                                    
                                    <input type="hidden" name="pers_photo_rename" id="pers_photo_rename" value="<?php echo $pers_photo_rename?>" />
                                    <input type="hidden" name="pers_photo_rename_prev" id="pers_photo_rename_prev" value="<?php echo $pers_photo_rename?>" />
								</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_summary"]." (".$messages["general_spanish"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="pers_profesional_objetive" id="pers_profesional_objetive" cols="40" rows="5" class="text_grv"><?php echo $pers_profesional_objetive;?></textarea>
								</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
	                                <label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_spanish"].")";?>:</label>
                                </td>
                            	<td>
	                                <textarea id="serv_description" name="serv_description" rows="35" cols="80" style="width: 90%"><?php echo $serv_description;?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_english"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td align="right"><label class="lbl_gray"><?php echo $messages["general_name"]." (".$messages["general_english"].")";?>:</label></td>
                                <td><input type="text" name="pers_name_e" id="pers_name_e" value="<?php echo $pers_name_e;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_image"]." (".$messages["general_english"].")";?>:</label>
								</td>
                                <td>
                                	<a href="addImageJcrop.php?div=div_content_pers_photo_rename_e&input_hidden=pers_photo_rename_e&w_ini=620&h_ini=465" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." (".$messages["general_english"].")";?></a>
                                    
                                	<div id="div_content_pers_photo_rename_e" style="width:620; height:465;">
                                        <?php echo $pers_photo_rename_e_element;?>
                                    </div>
                                    <div id="check_imagen_e" style="display:none">
                                    <br />
                                    <input type="checkbox" name="check_imagen_e" onclick="javascript: copyInfo('pers_photo_rename_e', 'pers_photo_rename', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_spanish"];?></label></div>
                                    
                                    <input type="hidden" name="pers_photo_rename_e" id="pers_photo_rename_e" value="<?php echo $pers_photo_rename_e;?>" />
                                    <input type="hidden" name="pers_photo_rename_e_prev" id="pers_photo_rename_e_prev" value="<?php echo $pers_photo_rename_e;?>" />
								</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_summary"]." (".$messages["general_english"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="serv_summary_e" id="serv_summary_e" cols="40" rows="5" class="text_grv"><?php echo $serv_summary_e;?></textarea>
								</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_english"].")";?>:</label>
                                </td>
                            	<td>
	                                <textarea id="serv_description_e" name="serv_description_e" rows="35" cols="80" style="width: 90%"><?php echo $serv_description_e;?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_aditionalInformation"];?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right"><label class="lbl_gray"><?php echo $messages["general_status"];?>:</label></td>                                
                                <td>
                                    <select name="serv_status" id="serv_status" class="text_grv">
                                        <option value="1" <?php if ($serv_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($serv_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="4" align="center">
                                	<input type="button" class="button_grv" value="<?php echo $messages["general_save"]?>"
									onclick="javascript: validate();"/>
                                    
                                    <input type="reset" value="<?php echo $messages["general_clear"]?>" class="button_grv_cancel"/>
                                    
                                    <input type="button" class="button_grv_cancel" value="<?php echo $messages["general_cancel"]?>"
									onClick="javascript:window.location.href='listServices.php';" />
                                </td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <?php include ("footer.php");?>
	</form>
</body>
</html>