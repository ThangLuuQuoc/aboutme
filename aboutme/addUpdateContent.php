<?php include("src/addUpdateContent_cs.php"); ?>
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
		
		var cont_name = document.getElementById("cont_name").value;
		
		var cont_name_e = document.getElementById("cont_name_e").value;
		
		var cont_status = document.getElementById("cont_status").value;
		
		if (cont_name == "") {
			msg += "- <?php echo $messages["validationContent_titleRequired"];?><br />";
		}
		
		if (cont_name_e == "") {
			msgAux += "- <?php echo $messages["validationContent_englishRequired"];?><br />";
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
		} else {
			coolMessage("alert", msg)
			return false;
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
		elements : "cont_text",
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
		elements : "cont_text_e",
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
<?php $item_select = 3; include("menu.php");?><br />
    <form name="form1" id="form1" method="post" action="">
    <input type="hidden" name="save" id="save" value="1"/>
    <input type="hidden" name="cont_code" id="cont_code" value="<?php echo $cont_code;?>"/>    
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
                            	<td colspan="4"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_spanish"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="4"><hr /></td>
                            </tr>
                            <tr>
                            	<td width="5%">&nbsp;</td>
                            	<td width="15%"><label class="lbl_gray"><?php echo $messages["general_title"]." (".$messages["general_spanish"].")";?>:</label></td>
                                <td width="1%">&nbsp;</td>
                                <td><input type="text" name="cont_name" id="cont_name" value="<?php echo $cont_name;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td colspan="3">
                                	<label class="lbl_gray"><?php echo $messages["general_content"]." (".$messages["general_spanish"].")";?>:</label><br />
	                                <textarea id="cont_text" name="cont_text" rows="35" cols="80" style="width: 90%"><?php echo $cont_text;?></textarea>
                                </td>
                            </tr>
                            
                            
                            <tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="4"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_english"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="4"><hr /></td>
                            </tr>
                            <tr>
	                            <td>&nbsp;</td>
                            	<td><label class="lbl_gray"><?php echo $messages["general_title"]." (".$messages["general_english"].")";?>:</label></td>
                                <td>&nbsp;</td>
                                <td><input type="text" name="cont_name_e" id="cont_name_e" value="<?php echo $cont_name_e;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td colspan="3">
                                	<label class="lbl_gray"><?php echo $messages["general_content"]." (".$messages["general_english"].")";?>:</label><br />
	                                <textarea id="cont_text_e" name="cont_text_e" rows="35" cols="80" style="width: 90%"><?php echo $cont_text_e;?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="4"><label class="subtitle"><?php echo $messages["general_aditionalInformation"];?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="4"><hr /></td>
                            </tr>
                            <tr>
                            	<td colspan="4">
                                	<table>                                    	
                                        <tr>
                                        	<td><label class="lbl_gray"><?php echo $messages["general_status"];?>:</label></td>
                                            <td>&nbsp;</td>
                                            <td>
                                            	<select name="cont_status" id="cont_status" class="text_grv">
                                                	<option value="1" <?php if ($cont_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                                    <option value="2" <?php if ($cont_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                                </select>
                                                <label class="note"><?php echo $messages["general_note_status"];?></label>
                                            </td>
                                        </tr>
                                    </table>
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
									onClick="javascript:window.location.href='listContents.php';" />
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