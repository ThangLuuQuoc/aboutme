<?php include("src/addUpdateFaq_cs.php"); ?>
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
		
		var faq_query = $.trim(document.getElementById("faq_query").value);
		var faq_answer = $.trim(document.getElementById("faq_answer").value);
		var faq_query_e = $.trim(document.getElementById("faq_query_e").value);
		var faq_answer_e = $.trim(document.getElementById("faq_answer_e").value);
		
		if (faq_query == "") {
			msg += "- <?php echo $messages["validationFaq_queryRequired"];?><br />";
		}
		
		if (faq_answer == "") {
			msg += "- <?php echo $messages["validationFaq_answerRequired"];?><br />";
		}
		
		if (faq_query_e == "") {
			msgAux += "- <?php echo $messages["validationFaq_queryRequired_e"];?><br />";
		}
		
		if (faq_answer_e == "") {
			msgAux += "- <?php echo $messages["validationFaq_answerRequired_e"];?><br />";
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
	
</script>

</head>
<body onload="showMessage('<?php echo $messageShow ;?>')">
<?php $item_select = 9; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="">
    <input type="hidden" name="save" id="save" value="1"/>
    <input type="hidden" name="faq_code" id="faq_code" value="<?php echo $faq_code;?>"/>    
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
                            	<td colspan="5"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_spanish"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="5"><hr /></td>
                            </tr>
                            <tr>
                            	<td width="5%">&nbsp;</td>
                            	<td width="15%" align="right"><label class="lbl_gray"><?php echo $messages["general_query"]." (".$messages["general_spanish"].")";?>:</label></td>
                                <td width="1%">&nbsp;</td>
                                <td><input type="text" name="faq_query" id="faq_query" value="<?php echo $faq_query;?>" class="text_grv" size="100" maxlength="200"/></td>
                                <td width="5%">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_answer"]." (".$messages["general_spanish"].")";?>:</label>
								</td>
                                <td>&nbsp;</td>
                                <td valign="top">
	                                <textarea id="faq_answer" name="faq_answer" rows="10" class="text_grv"><?php echo $faq_answer;?></textarea>
                                </td>
                                <td>&nbsp;</td>
                            </tr>                            
                            <tr>
                            	<td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="5"><label class="subtitle"><?php echo $messages["general_information"]." (".$messages["general_english"].")";?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="5"><hr /></td>
                            </tr>
                            <tr>
                            	<td width="5%">&nbsp;</td>
                            	<td width="15%" align="right"><label class="lbl_gray"><?php echo $messages["general_query"]." (".$messages["general_english"].")";?>:</label></td>
                                <td width="1%">&nbsp;</td>
                                <td><input type="text" name="faq_query_e" id="faq_query_e" value="<?php echo $faq_query_e;?>" class="text_grv" size="100" maxlength="200"/></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td align="right" valign="top">
                                	<label class="lbl_gray"><?php echo $messages["general_answer"]." (".$messages["general_english"].")";?>:</label>
								</td>
                                <td>&nbsp;</td>
                                <td valign="top">
	                                <textarea id="faq_answer_e" name="faq_answer_e" rows="10" class="text_grv"><?php echo $faq_answer_e;?></textarea>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            
                            <tr>
                            	<td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="5"><label class="subtitle"><?php echo $messages["general_aditionalInformation"];?></label></td>
                            </tr>
                            <tr>
                            	<td colspan="5"><hr /></td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td align="right"><label class="lbl_gray"><?php echo $messages["general_status"];?>:</label></td>
                                <td>&nbsp;</td>
                                <td>
                                    <select name="faq_status" id="faq_status" class="text_grv">
                                        <option value="1" <?php if ($faq_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($faq_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td colspan="5" align="center">
                                    <div class="div_items_c">
                                        <div class="item">
                                            <input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate();"/>
                                        </div>
                                        <div class="item">                                            
                                            <input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listFaq.php';" />
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