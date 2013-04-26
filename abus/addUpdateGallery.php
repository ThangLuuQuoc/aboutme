<?php include("src/addUpdateGallery_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script language="javascript" type="text/javascript">
	
	var countImages = parseInt (<?php echo $amountImages;?>);
	
	function validate(){
        var msg = "";
		var msgAux = "";
		
		var gall_name = $.trim(document.getElementById("gall_name").value);
		var gall_name_e = $.trim(document.getElementById("gall_name_e").value);
		
		if (gall_name == "") {
			msg += "- <?php echo $messages["galleryValidation_nameRequired"];?><br />";
		}
		
		if (gall_name_e == "") {
			msgAux += "- <?php echo $messages["galleryValidation_nameRequired_e"];?><br />";
		}
		
		if (countImages == 0) {
			msg += "- <?php echo $messages["galleryValidation_imagesRequired"];?><br />";
		}
		
		if (msgAux != "") {
            msgAux += "<br /> <?php echo $messages["validationGeneral_englishRequired"];?><br />";
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
	
	$(document).ready(function(){
		
		var button = $('#upload'), interval;
		
		new AjaxUpload(button,{
			action: 'processingImage.php', 
			name: 'image',
			onSubmit : function(file, ext){
				// cambiar el texto del boton cuando se selecicione la imagen		
				button.text('Subiendo');
				// desabilitar el boton
				this.disable();
				
				interval = window.setInterval(function(){
					var text = button.text();
					if (text.length < 11){
						button.text(text + '.');					
					} else {
						button.text('Subiendo');				
					}
				}, 200);
			},
			onComplete: function(file, response){
				button.text('Subir Foto');
							
				window.clearInterval(interval);
							
				// Habilitar boton otra vez
				this.enable();
				
				// Añadiendo las imagenes a mi lista
				if ($('#gallery li').length == 0) {
					$('#gallery').html(response).fadeIn("fast");
					$('#gallery li').eq(0).hide().show("slow");
				} else {
					$('#gallery').prepend(response);
					$('#gallery li').eq(0).hide().show("slow");
				}
			}
		});
		
		// Listar  fotos que hay en mi tabla
		$("#gallery").load("processingImage.php?action=getImages&id=<?php echo $gall_code;?>");
		
		// Eliminar		
		$("#gallery li a").live("click",function(){
			var a = $(this)
			$.get("processingImage.php?action=delete", {id:a.attr("id")}, function() {
				a.parent().fadeOut("slow");
				countImages --;
				document.getElementById("hidden_" + a.attr("id")).value = 0;
			})
		})
	});

	function loadImageCropper(image_rename) {
		close_fancy();
		var response = '<li style="display: block;"><a href="javascript:;" id="'+ image_rename +'"><img src="../images/delete.png"></a><img src="../file_upload/images_bank/'+ image_rename +'"><input type="hidden" name="array_images[]" value="' + image_rename + ',0" /><input type="hidden" name="array_images_valid[]" id="hidden_' + image_rename + '" value="1" /></li>';
		if ($('#gallery li').length == 0) {
			$('#gallery').html(response).fadeIn("fast");
			$('#gallery li').eq(0).hide().show("slow");
		} else {
			$('#gallery').prepend(response);
			$('#gallery li').eq(0).hide().show("slow");
		}
		
		countImages ++;
	}
</script>


</head>
<body onload="showMessage('<?php echo $message_show;?>')">
<?php $item_select = 6; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="">
    <input type="hidden" name="save" id="save" value="1"/>
    <input type="hidden" name="gall_code" id="gall_code" value="<?php echo $gall_code;?>"/>
    <input type="hidden" name="img_code" id="img_code" value="<?php echo $img_code;?>"/>
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
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_spanish"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td width="5%">&nbsp;</td>
                            	<td width="20%" align="right"><label class="lbl_gray"><?php echo $messages["general_name"]." (".$messages["general_spanish"].")";?>:</label></td>
                                <td><input type="text" name="gall_name" id="gall_name" value="<?php echo $gall_name;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>                            
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_spanish"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="gall_description" id="gall_description" cols="40" rows="5" class="text_grv"><?php echo $gall_description;?></textarea>
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
                                <td><input type="text" name="gall_name_e" id="gall_name_e" value="<?php echo $gall_name_e;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>                            
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_english"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="gall_description_e" id="gall_description_e" cols="40" rows="5" class="text_grv"><?php echo $gall_description_e;?></textarea>
								</td>
                            </tr>                            
                            <tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_images"];?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td colspan="4">
                            		<div id="content">
                                        <a href="javascript:;" id="upload"></a>
                                        <a href="addImageJcrop.php?function=loadImageCropper&w_ini=870&h_ini=522" class="fancytoJcrop link_upload"><?php echo $messages["general_load_image"];?></a>
                                        <ul id="gallery">
                                            <!-- Cargar Fotos -->
                                        </ul>
                                    </div>
                            	</td>
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
                                    <select name="gall_status" id="gall_status" class="text_grv">
                                        <option value="1" <?php if ($gall_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($gall_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="4" align="center">
                            		<div class="div_items_c">
                                        <div class="item">
                                			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate();"/>
                                        </div>
                                        <div class="item">                                            
                                    		<input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listGalleries.php';" />
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