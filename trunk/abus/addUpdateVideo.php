<?php include("src/addUpdateVideo_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script type="text/javascript" src="/js/jwplayer.js"></script>
<script language="javascript" type="text/javascript">
		
	function validate(){
        var msg = "";
		var msgAux = "";
		
		var vid_name = $.trim(document.getElementById("vid_name").value);		
		var vid_name_e = $.trim(document.getElementById("vid_name_e").value);
		
		var vid_type_pc = document.getElementById("vid_type_pc").checked;
		var vid_type_yt = document.getElementById("vid_type_yt").checked;
		
		var vid_file_pc = document.getElementById("vid_file_pc").value;
		var vid_file_yt = $.trim(document.getElementById("vid_file_yt").value);
		
		var vid_file_prev = $.trim(document.getElementById("vid_file_prev").value);
		
		var vid_image = $.trim(document.getElementById("vid_image").value);
		
		if (vid_name == "") {
			msg += "- <?php echo $messages["videoValidation_nameRequired"];?><br />";
		}
		
		if (vid_name_e == "") {
			msgAux += "- <?php echo $messages["videoValidation_nameRequired_e"];?><br />";
		}
		
		if (vid_type_pc == false && vid_type_yt == false) {
			msg += "- <?php echo $messages["videoValidation_typeRequired"];?><br />";
		} else {
			if (vid_type_yt == true && vid_file_yt == '') {
				msg += "- <?php echo $messages["videoValidation_typeValueYTRequired"];?><br />";
			} else if (vid_type_pc == true ) {
				if (vid_file_pc == '' && vid_file_prev == '') {
					msg += "- <?php echo $messages["videoValidation_typeValuePCRequired"];?><br />";
				} else if (!validateExtension(vid_file_pc, new Array (".flv", ".mp4", ".mp3"))) {
					msg += "- <?php echo $messages["videoValidation_formatVideoValidate"];?><br />";
				}
			}
		}
		
		if (vid_type_pc == 1 && vid_image == '') {
			msg += "- <?php echo $messages["videoValidation_imageRequired"];?><br />";
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
    	try {
			jwplayer("container").setup({ 
				flashplayer: "/player.swf"
			});
		} catch(e) {}
    
		// Eliminar		
		$("#gallery li a").live("click",function(){
			var a = $(this)
			$.get("processingImage.php?action=delete", {id:a.attr("id")}, function() {
				a.parent().fadeOut("slow");
			})
		})
	});

	function loadImageCropper(image_rename) {
		close_fancy();
		var response = '<li style="display: block;"><a href="javascript:;" id="'+ image_rename +'"><img src="../images/delete.png"></a><img src="../file_upload/images_bank/'+ image_rename +'"></li>';
		
		$('#gallery').html(response).fadeIn("fast");
		$('#gallery li').eq(0).hide().show("slow");
		
		document.getElementById("vid_image").value = image_rename;
	}
	
	function showElement(id) {
		if (id == 1) {
			document.getElementById("tr_video_pc").style.display = displayRow;
			document.getElementById("tr_video_yt").style.display = 'none';
		} else if (id == 2) {
			document.getElementById("tr_video_pc").style.display = 'none';
			document.getElementById("tr_video_yt").style.display = displayRow;
		}
	}
	
</script>
</head>
<body onload="showMessage('<?php echo $message_show;?>')">
<?php $item_select = 7; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="save" id="save" value="1"/>
    <input type="hidden" name="vid_code" id="vid_code" value="<?php echo $vid_code;?>"/>
    <input type="hidden" name="vid_image_prev" id="vid_image_prev" value="<?php echo $vid_image;?>"/>
    <input type="hidden" name="vid_image" id="vid_image" value="<?php echo $vid_image;?>"/>
    <input type="hidden" name="vid_file_prev" id="vid_file_prev" value="<?php echo $vid_file;?>"/>
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
                                <td><input type="text" name="vid_name" id="vid_name" value="<?php echo $vid_name;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>                            
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_spanish"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="vid_summary" id="vid_summary" cols="40" rows="5" class="text_grv"><?php echo $vid_summary;?></textarea>
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
                                <td><input type="text" name="vid_name_e" id="vid_name_e" value="<?php echo $vid_name_e;?>" class="text_grv" size="45" maxlength="45"/></td>
                            </tr>                            
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_description"]." (".$messages["general_english"].")";?>:</label>
								</td>
                                <td>
                                    <textarea name="vid_summary_e" id="vid_summary_e" cols="40" rows="5" class="text_grv"><?php echo $vid_summary_e;?></textarea>
								</td>
                            </tr>                            
                            <tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="3"><label class="subtitle"><?php echo $messages["general_information"].' '.$messages["general_video"];?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right">
                                	<label class="lbl_gray"><?php echo $messages["general_video_type"];?>:</label>
								</td>
                                <td>
                                    <input type="radio" name="vid_type" id="vid_type_pc" <?php if ($vid_type == 1){?> checked="checked" <?php }?> onclick="javascript: showElement(1)" value="1" /> <label class="lbl_gray"><?php echo $messages["general_loaded_from_computer"];?></label> 
                                    
                                    <input type="radio" name="vid_type" id="vid_type_yt" style="padding-left:15px;" <?php if ($vid_type == 2){?> checked="checked" <?php }?> onclick="javascript: showElement(2)" value="2"/> <label class="lbl_gray"><?php echo $messages["general_loaded_from_youtube"];?></label>
								</td>
                            </tr>                            
                            <tr <?php if ($vid_type == 2){?> style="display:none" <?php }?> id="tr_video_pc">
                            	<td>&nbsp;</td>
                                <td align="right">
                                	<label class="lbl_gray"><?php echo $messages["general_video"];?>:</label>                                    
								</td>
                                <td>
                                    <input type="file" name="vid_file_pc" id="vid_file_pc" />
								</td>
                            </tr>                            
                            <tr <?php if ($vid_type == 1){?> style="display:none" <?php }?> id="tr_video_yt">
                            	<td>&nbsp;</td>
                                <td align="right" valign="top">                                	
                                    <label class="lbl_gray"><?php echo $messages["general_url_youtube"];?>:</label>
								</td>
                                <td>                                    
                                    <input type="text" name="vid_file_yt" id="vid_file_yt"  value="<?php if ($vid_type == 2) echo $vid_original;?>" class="text_grv" maxlength="100" size="80" /><br />
                                    <label class="note" id="note_yt"><?php echo $messages["general_url_youtube_example"];?></label>
								</td>
                            </tr>
                            <tr <?php if ($action == "add"){?> style="display:none" <?php }?> id="tr_video_view">
                            	<td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td>
                                    <a href="playVideo.php?vid_code=<?php echo $vid_code;?>" class="fancytoVideo"><?php echo $messages["general_view_video"];?></a>
								</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_image"];?>:</label>
								</td>                                
                                <td>
                                	<table width="80%">
                                    	<tr>
                                        	<td valign="top" class="left" width="30%">
	                                            <a href="javascript:;" id="upload"></a>
    	                                        <a href="simpleJcropImage.php?function=loadImageCropper&widthAreaSelection=840&hightAreaSelection=512" class="fancytoJcrop link_upload" style="margin-top:-5px;"><?php echo $messages["general_load_image"];?></a>
											</td>
                                            <td align="center">
                                                <ul id="gallery" style="margin-top:-9px; padding:0px; height:114px;">
                                                    <?php echo $vid_image_dafault;?>
                                                </ul>
											</td>
                                            <td><input type="hidden" name="vid_imag_type" id="vid_imag_type" value="1" /></td>
										</tr>
									</table>
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
                                    <select name="vid_status" id="vid_status" class="text_grv">
                                        <option value="1" <?php if ($vid_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($vid_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="4" align="center">
                                    <div class="div_items_c">
                                        <div class="item">
                                            <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate();"/>
                                        </div>
                                        <div class="item">
                                            <input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listVideos.php';" />
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