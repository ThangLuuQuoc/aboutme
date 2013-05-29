<?php include("src/addUpdateSlider_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script language="javascript" type="text/javascript">
	
	function chargerImage(image_rename, input_hidden, div) {
		document.getElementById(div).innerHTML = '<a href="javascript:;" onclick="javascript: return deleteImage(\''+div+'\')"><img src="images/delete.png" width="16" height="16" alt="<?php echo $messages["general_remove"]?>" /></a><br /><a class="fancytoImage" href="../file_upload/images_bank/'+image_rename+'"><img src="../file_upload/images_bank/'+image_rename+'"/></a>';
		
		document.getElementById(input_hidden).value = image_rename;
		
		initFancy();
		
		$.fn.fancybox.close();
		
		if (div == 'div_content_slid_image_rename') {			
			document.getElementById('check_imagen').style.display = displayRow;
		} else if (div == 'div_content_slid_image_rename_e') {
			document.getElementById('check_imagen_e').style.display = displayRow;
		}
	}

	function deleteImage(div){
		coolMessage("confirm", "<?php echo $messages["general_message_confirmDeleteImage"]?>", function(){
			clearImage(div);
		});
	}
	
	function clearImage(div) {
		if ( div == 'div_content_slid_image_rename' ){
			document.getElementById('slid_image_name').value = "";
			document.getElementById('slid_image_rename').value = "";
			document.getElementById('check_imagen').style.display = 'none';
		}
		else if ( div == 'div_content_slid_image_rename_e' ){
			document.getElementById('slid_image_name_e').value = "";
			document.getElementById('slid_image_rename_e').value = "";
			document.getElementById('check_imagen_e').style.display = 'none';
		}
		
		document.getElementById(div).innerHTML = '<img src="../images/broken-image.png" width="620" height="320" />';
	}
	
	function validate(){
		var msg = "";
		var msgAux = "";
		
		var slid_title = document.getElementById("slid_title").value;
		var slid_image_rename = document.getElementById("slid_image_rename").value;
		var slid_content = document.getElementById("slid_content").value;
		
		var slid_title_e = document.getElementById("slid_title_e").value;
		var slid_image_rename_e = document.getElementById("slid_image_rename_e").value;
		var slid_content_e = document.getElementById("slid_content_e").value;
		
		var slid_url = document.getElementById("slid_url").value;
		
		if (slid_title == "") {
			msg += "- <?php echo $messages["validationSlider_titleRequired"];?><br />";
		}
		
		if (slid_image_rename == "") {
			msg += "- <?php echo $messages["validationSlider_imageRequired"];?><br />";
		}
		
		if (slid_content == "") {
			msg += "- <?php echo $messages["validationSlider_contentRequired"];?>";
		}

        if (slid_title_e == "") {
            msgAux += "- <?php echo $messages["validationSlider_titleRequired_e"];?><br />";
        }
        
        if (slid_image_rename_e == "") {
            msgAux += "- <?php echo $messages["validationSlider_imageRequired_e"];?><br />";
        }
        
        if (slid_content_e == "") {
            msgAux += "- <?php echo $messages["validationSlider_contentRequired_e"];?><br />";
        }
		
		if (msgAux != "") {
			msgAux += "<br /> <?php echo $messages["validationGeneral_englishRequired"];?><br />";
		}
		
		if (slid_url != "" && !validateURL(slid_url)) {
			msg += "- <?php echo $messages["validationSlider_urlValidation"];?><br />";
		}
		
		if (msg == '') {
			if (msgAux != '') {
				coolMessage("confirm", msgAux, function(){
					document.getElementById("form1").submit();
					return true;
				});
			} else {
				document.getElementById("form1").submit();
				return true;
			}
		}
		else{
			coolMessage("alert", msg)
			return false;
		}		
	}
	
	
	function copyInfo(id_obj_from, id_obj_to, component){
		if (component.checked) {
			document.getElementById(id_obj_to).value = document.getElementById(id_obj_from).value;
		
			var value_obj_from = document.getElementById(id_obj_from).value;
			
			document.getElementById("div_content_"+id_obj_to).innerHTML = '<a href="javascript:;" onclick="javascript: return deleteImage(\'div_content_'+id_obj_to+'\')"><img src="images/delete.png" width="16" height="16" alt="<?php echo $messages["general_remove"];?>" /></a><br /><a class="fancytoImage" href="../file_upload/images_bank/'+value_obj_from+'"><img src="../file_upload/images_bank/'+value_obj_from+'"/></a>';
			initFancy();
		} else {
			clearImage("div_content_"+id_obj_to);
		}
	}
</script>
</head>
<body onload="showMessage('<?php echo $message_show;?>')">
<?php $item_select = 2; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="save" id="save" value="1"/>
        <input type="hidden" name="slid_code" id="slid_code" value="<?php echo $slid_code;?>"/>
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
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["slider_lable_informationItem"]." (".$messages["general_spanish"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                                <td width="66%">
	                                <input type="hidden" name="slid_image_rename" id="slid_image_rename" value="<?php echo $slid_image_rename?>" />
                                    <input type="hidden" name="slid_image_rename_prev" id="slid_image_rename_prev" value="<?php echo $slid_image_rename?>" />
                                	<div id="div_content_slid_image_rename" style="width:620; height:320; border:1px solid;">
                                        <?php echo $slid_image;?>
                                    </div>
                                    <div id="check_imagen" style="display:none">
                                    <br />
                                    <input type="checkbox" name="check_imagen" onclick="javascript: copyInfo('slid_image_rename', 'slid_image_rename_e', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_english"];?></label></div>
                                    <label class="lbl_gray"><?php echo $messages["slider_image_name"]." (".$messages["general_spanish"].")";?>:</label><input type="text" class="text_grv" name="slid_image_name" id="slid_image_name" value="<?php echo $slid_image_name;?>" maxlength="45" size="45" />
                                </td>
                                <td width="1%">&nbsp;</td>
                                <td valign="top">
                                	<table width="100%">
                                    	<tr>
                                        	<td width="25%"><label class="lbl_gray"><?php echo $messages["general_title"]." (".$messages["general_spanish"].")";?>:</label></td>
                                            <td width="1%">&nbsp;</td>
                                            <td><input type="text" name="slid_title" id="slid_title" class="text_grv" value="<?php echo $slid_title;?>" size="34" maxlength="45"/></td>
                                        </tr>
                                        <tr>
                                        	<td><label class="lbl_gray"><?php echo $messages["general_image"]." (".$messages["general_spanish"].")";?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<!--<a href="addImageJcrop.php?div=div_content_slid_image_rename&input_hidden=slid_image_rename&w_ini=620&h_ini=320" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." (".$messages["general_spanish"].")";?></a></br> -->
                                                <a href="simpleJcropImage.php?divContent=div_content_slid_image_rename&idInputHidden=slid_image_rename&widthAreaSelection=620&hightAreaSelection=320" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." [".$messages["general_spanish"]."]";?></a>
											</td>
                                        </tr>                                        
                                        <tr>
                                        	<td valign="top"><label class="lbl_gray"><?php echo $messages["general_content"]." (".$messages["general_spanish"].")";?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<textarea name="slid_content" id="slid_content" cols="26" rows="12" class="text_grv"><?php echo $slid_content;?></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["slider_lable_informationItem"]." (".$messages["general_english"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                                <td width="66%">
	                                <input type="hidden" name="slid_image_rename_e" id="slid_image_rename_e" value="<?php echo $slid_image_rename_e?>" />
                                    <input type="hidden" name="slid_image_rename_e_prev" id="slid_image_rename_e_prev" value="<?php echo $slid_image_rename_e?>" />
                                	<div id="div_content_slid_image_rename_e" style="width:620; height:320; border:1px solid;">
                                        <?php echo $slid_image_e;?>
                                    </div>
                                    <div id="check_imagen_e" style="display:none">
                                    <br />
                                    <input type="checkbox" name="check_imagen_e" onclick="javascript: copyInfo('slid_image_rename_e', 'slid_image_rename', this)" /><label class="lbl_gray"><?php echo $messages["general_message_use_image"]." ".$messages["general_spanish"];?></label></div>
                                    <label class="lbl_gray"><?php echo $messages["slider_image_name"]." (".$messages["general_english"].")";?>:</label><input type="text" class="text_grv" name="slid_image_name_e" id="slid_image_name_e" value="<?php echo $slid_image_name_e;?>" maxlength="45" size="45" />
                                </td>
                                <td width="1%">&nbsp;</td>
                                <td valign="top">
                                	<table width="100%">
                                    	<tr>
                                        	<td width="25%"><label class="lbl_gray"><?php echo $messages["general_title"]." (".$messages["general_english"].")";?>:</label></td>
                                            <td width="1%">&nbsp;</td>
                                            <td><input type="text" name="slid_title_e" id="slid_title_e" class="text_grv" value="<?php echo $slid_title_e;?>" size="34" maxlength="45"/></td>
                                        </tr>
                                        <tr>
                                        	<td><label class="lbl_gray"><?php echo $messages["general_image"]." (".$messages["general_english"].")";?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<!--<a href="addImageJcrop.php?div=div_content_slid_image_rename_e&input_hidden=slid_image_rename_e&w_ini=620&h_ini=320" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." (".$messages["general_english"].")";?></a>&nbsp; -->
                                                <a href="simpleJcropImage.php?divContent=div_content_slid_image_rename_e&idInputHidden=slid_image_rename_e&widthAreaSelection=620&hightAreaSelection=320" class="fancytoJcrop">[+] <?php echo $messages["general_load_image"]." [".$messages["general_spanish"]."]";?></a>
											</td>
                                        </tr>                                        
                                        <tr>
                                        	<td valign="top"><label class="lbl_gray"><?php echo $messages["general_content"]." (".$messages["general_english"].")";?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<textarea name="slid_content_e" id="slid_content_e" cols="26" rows="12" class="text_grv"><?php echo $slid_content_e;?></textarea>
                                            </td>
                                        </tr>
                                    </table>
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
                            	<td colspan="3">
                                	<table>
                                    	<tr>
                                        	<td><label class="lbl_gray"><?php echo $messages["general_url"];?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td><input type="text" name="slid_url" id="slid_url" class="text_grv" value="<?php echo $slid_url;?>" size="80" maxlength="120"/>
                                            &nbsp;<label class="note"><?php echo $messages["slider_message_exampleULR"];?>:</label></td>
                                        </tr>
                                        <tr>
                                        	<td><label class="lbl_gray"><?php echo $messages["general_status"];?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<select name="slid_status" id="slid_status" class="text_grv">
                                                	<option value="1" <?php if ($slid_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                                    <option value="2" <?php if ($slid_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                                </select>
                                                <label class="note"><?php echo $messages["general_note_status"];?></label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3" align="center">
                                    <div class="div_items_c">
                                        <div class="item">
                                            <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate();"/>
                                        </div>
                                        <div class="item">                                            
                                            <input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listItemsSlider.php';" />
                                        </div>
                                    </div>
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