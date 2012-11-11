<?php include('src/listContactUs_cs.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<link rel="stylesheet" href="css/styleLightbox.css" type="text/css" media="screen" />
<?php require ("general_includes.php");?>
<script src="js/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript" type="text/javascript">
	
	function viewContactUs (contact_code) {
		document.getElementById("contact_code").value = contact_code;
		var contact_status = document.getElementById("contact_status_" + contact_code).value;
		
		document.getElementById("lbl_name").innerHTML = document.getElementById("contact_name_" + contact_code).value;
		document.getElementById("lbl_email").innerHTML = document.getElementById("contact_email_" + contact_code).value;
		document.getElementById("lbl_phone").innerHTML = document.getElementById("contact_phone_" + contact_code).value;
		document.getElementById("lbl_city").innerHTML = document.getElementById("contact_city_" + contact_code).value;
		document.getElementById("lbl_text").innerHTML = document.getElementById("contact_text_" + contact_code).value;
		document.getElementById("lbl_date_create").innerHTML = document.getElementById("contact_date_create_" + contact_code).value;
		document.getElementById("lbl_status").innerHTML = document.getElementById("contact_status_value_" + contact_code).value;
		
		document.getElementById("tr_response").style.display = 'none';
		
		document.getElementById("btn_reply").style.display = 'none';
		document.getElementById("btn_disregard").style.display = 'none';
		
		if ((contact_status == 1) || (contact_status == 3)) {//sin responder o ignorado
			if (contact_status == 1) {
				document.getElementById("btn_reply").style.display = displayRow;
				document.getElementById("btn_disregard").style.display = displayRow;				
			}
			
			document.getElementById("tr_response_view").style.display = 'none';
			document.getElementById("tr_response_date").style.display = 'none';
			document.getElementById("tr_use_login").style.display = 'none';
		} else if (contact_status == 2) {//respuesto
			document.getElementById("tr_response_view").style.display = displayRow;
			document.getElementById("tr_response_date").style.display = displayRow;
			document.getElementById("tr_use_login").style.display = displayRow;
			
			document.getElementById("lbl_contact_answer").innerHTML = document.getElementById("contact_answer_"+contact_code).value;
			document.getElementById("lbl_contact_date_answer").innerHTML = document.getElementById("contact_date_answer_"+contact_code).value;
			document.getElementById("lbl_use_login").innerHTML = document.getElementById("use_login_"+contact_code).value;
		} else {
			coolMessage("error", "error");
			return;
		}
		
		
						
		showLightBox();
	}
	
	function replyContactus() {		
		document.getElementById("tr_response").style.display = displayRow;
		document.getElementById("btn_reply").style.display = 'none';
	}
	
	function sendResponse() {
		var contact_code = document.getElementById("contact_code").value;
		var contact_answer = $.trim(document.getElementById("contact_answer").value);
		var msg = '';
		
		if (contact_answer == '') {
			msg += '<?php echo $messages["contactUs_responseValidate"]?>';
		}
		
		if (contact_code > 0) {
		
			jQuery.ajax({
				type: "POST",
				url: "ajaxContactUs.php",
				data: 'contact_code='+contact_code+"&contact_answer="+contact_answer,
				success: function(result){
					if (result == 1) {
						coolMessage("alert", "<?php echo $messages["contactUs_success"];?>");
						
						document.getElementById("contact_status_" + contact_code).value = 2;
						document.getElementById("lbl_contact_status_" + contact_code).innerHTML = "<?php echo $messages["general_answered"];?>";
						document.getElementById("contact_answer_" + contact_code).value = contact_answer;
						document.getElementById("contact_date_answer_" + contact_code).value = "<?php echo $messages["general_today"];?>";
						document.getElementById("contact_status_value_" + contact_code).value = "<?php echo $messages["general_answered"];?>";
						document.getElementById("tr_response").style.display = 'none';
						document.getElementById("contact_answer").value = "";
						document.getElementById("lbl_contact_answer").innerHTML = contact_answer;
						document.getElementById("lbl_status").innerHTML = "<?php echo $messages["general_answered"];?>";
						document.getElementById("tr_response_view").style.display = displayRow;
						document.getElementById("btn_reply").style.display = 'none';
						
						//window.location.href = window.location.href
					} else {
						coolMessage("alert", "<?php echo $messages["contactUs_error"];?>");
					}
				}
			});
		} else {
			msg += '<?php echo $messages["contactUs_error"]?>';
		}
		
		if (msg != '') {
			coolMessage("alert", msg);
			return false;
		}
		
	}
	
	//ignorar
	function disregardContactus() {
		var contact_code = document.getElementById("contact_code").value;
		if (contact_code > 0) {
			coolMessage("confirm", "<?php echo $messages["general_message_confirmDisregar"];?>", function() {
				changeStatusContact(contact_code, 3);
			});
		} else {
			coolMessage("alert", "<?php echo $messages["general_message_errorUpdatingStatusItem"]?>");
		}
	}
	
	function deleteContactUs() {		
		var contact_code = document.getElementById("contact_code").value;
		if (contact_code > 0) {
			coolMessage("confirm", "<?php echo $messages["general_message_confirmDelete"];?>", function() {
				changeStatusContact(contact_code, 4);
			});
		} else {
			coolMessage("alert", "<?php echo $messages["general_message_errorDelete"]?>");
		}
	}
	
	function changeStatusContact(contact_code, contact_status) {
		jQuery.ajax({
			type: "POST",
			url: "ajaxContactUs.php",
			data: 'contact_code='+contact_code+"&contact_status="+contact_status,
			success: function(result){
				if (result == 1) {
					closebox();
				} else {
					coolMessage("error", "<?php echo $messages["general_error"];?>");
				}
			}
		});
	}
	
</script>

</head>
<body onload="javascript: showMessage(<?php echo $message_show;?>)">
	<div id="sign_up">
    	<input type="hidden" id="contact_code" value="0" />
        <input type="hidden" id="contact_status" value="0" />
        <table class="tbl_form_fancy">
        	<tr>
            	<td colspan="2" style="border-bottom:1px solid #c0c0c0;" align="center"><label class="title"><?php echo $messages["general_ticket_contact"];?></label></td>
            </tr>
            <tr>
                <td width="40%" align="right"><label class="lbl_gray"><?php echo $messages["general_name"];?>:</label></td>
                <td id="lbl_name" class="lbl_black">-</td>
            </tr>
            <tr>
                <td align="right"><label class="lbl_gray"><?php echo $messages["general_email"];?>:</label></td>
                <td id="lbl_email" class="lbl_black">-</td>
            </tr>
            <tr>
                <td align="right"><label class="lbl_gray"><?php echo $messages["general_phone"];?>:</label></td>
                <td id="lbl_phone" class="lbl_black">-</td>
            </tr>
            <tr>
                <td align="right"><label class="lbl_gray"><?php echo $messages["general_city"];?>:</label></td>
                <td id="lbl_city" class="lbl_black">-</td>
            </tr>            
            <tr>
                <td align="right" valign="top"><label class="lbl_gray"><?php echo $messages["general_question_concern"];?>:</label></td>
                <td id="lbl_text" class="lbl_black">-</td>
            </tr>
            <tr>
                <td align="right"><label class="lbl_gray"><?php echo $messages["general_date_create"];?>:</label></td>
                <td id="lbl_date_create" class="lbl_black">-</td>
            </tr>
            <tr>
                <td align="right"><label class="lbl_gray"><?php echo $messages["general_status"];?>:</label></td>
                <td id="lbl_status" class="lbl_black">-</td>
            </tr>
            <tr id="tr_response" style="display:none">
                <td align="right" valign="top"><label class="lbl_gray"><?php echo $messages["general_response"];?>:</label></td>
                <td id="lbl_date_create" class="lbl_black">
                	<textarea name="contact_answer" rows="4" id="contact_answer"></textarea>
                    <input type="button" class="button_grv" style="float:right" id="contact_answer" value="<?php echo $messages["general_send_response"]?>" 
                    	onclick="javascript: sendResponse();"/>
                </td>
            </tr>
            <tr id="tr_response_view" style="display:none">
                <td align="right" valign="top"><label class="lbl_gray"><?php echo $messages["general_response"];?>:</label></td>
                <td id="lbl_date_create" class="lbl_black"><label class="lbl_black" id="lbl_contact_answer">-</label></td>
            </tr>
            <tr id="tr_response_date" style="display:none">
                <td align="right" valign="top"><label class="lbl_gray"><?php echo $messages["general_date_response"];?>:</label></td>
                <td id="lbl_date_response" class="lbl_black"><label class="lbl_black" id="lbl_contact_date_answer">-</label></td>
            </tr>
            <tr id="tr_use_login" style="display:none">
                <td align="right" valign="top"><label class="lbl_gray"><?php echo $messages["general_response_by"];?>:</label></td>
                <td id="lbl_date_response" class="lbl_black"><label class="lbl_black" id="lbl_use_login">-</label></td>
            </tr>
            <tr>
            	<td colspan="2" align="center">
                	<input type="button" class="button_grv" id="btn_reply" value="<?php echo $messages["general_reply"];?>" onclick="javascript: replyContactus();" />
                    <input type="button" class="button_grv" id="btn_disregard" value="<?php echo $messages["general_disregard"];?>" onclick="javascript: disregardContactus();" />
                    <input type="button" class="button_grv" id="btn_delete" value="<?php echo $messages["general_remove"];?>" onclick="javascript: deleteContactUs();" />
                    <input type="button" class="button_grv" id="btn_delete" value="<?php echo $messages["general_close"];?>" onclick="javascript: closebox();" />
                </td>
            </tr>
        </table>    
    </div>
	<?php $item_select = 8; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="">
        <div class="content_grv">
            <table class="tbl_list">
                <?php include("headerList.php");?>
                <?php if ($listRows > 0) {?>
                <tr>
                    <?php for ($i = 0; $i < count ($ord_href); $i++ ){?>
                    <td class="item_head" width="<?php echo $item_width[$i];?>"><?php echo $ord_href[$i];?></td>
                    <?php }?>
                </tr>
                <?php 
                    $i = 0;
                    while ($i < $countRows) {
                        $class = "";
                        
                        if ($i%2 == 0) {
                            $class = 'item_a';
                        } else {
                            $class = 'item_b';
                        }
						
						$contact_status = '-';
						$contact_city = '-';
						
						if ($list[$i]->contact_status == 1) {
							$contact_status = $messages["general_unanswered"];
						} elseif ($list[$i]->contact_status == 2) {
							$contact_status = $messages["general_answered"];
						} elseif ($list[$i]->contact_status == 3) {
							$contact_status = $messages["general_noteless"];
						}
						
						if (! empty ($list[$i]->contact_city)) {
							$contact_city = $list[$i]->contact_city;
						}
                ?>
                <tr id="tr_<?php echo $i;?>">
                    <td class="<?php echo $class;?>">
                    <input type="hidden" id="contact_date_create_<?php echo $list[$i]->contact_code;?>" value="<?php echo changeFormatDate($list[$i]->contact_date_create, 1, true, false);?>" />
					<input type="hidden" id="contact_status_value_<?php echo $list[$i]->contact_code;?>" value="<?php echo $contact_status;?>" />
                    <input type="hidden" id="use_login_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->use_login;?>" />
                    <input type="hidden" id="contact_answer_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->contact_answer;?>" />
                    <input type="hidden" id="contact_date_answer_<?php echo $list[$i]->contact_code;?>" value="<?php echo changeFormatDate($list[$i]->contact_date_answer, 1, true, false);?>" />
					<?php echo changeFormatDate($list[$i]->contact_date_create, 1, true, false);?></td>
                    <td class="<?php echo $class;?>">
                    	<input type="hidden" id="contact_text_<?php echo $list[$i]->contact_code;?>" value="<?php echo nl2br($list[$i]->contact_text);?>" />
                    	<input type="hidden" id="contact_name_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->contact_name;?>" />
						<?php echo $list[$i]->contact_name;?></td>
                    <td class="<?php echo $class;?>"><input type="hidden" id="contact_email_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->contact_email;?>" /><?php echo $list[$i]->contact_email;?></td>
                    <td class="<?php echo $class;?>"><input type="hidden" id="contact_phone_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->contact_phone;?>" /><?php echo $list[$i]->contact_phone;?></td>
                    <td class="<?php echo $class;?>"><input type="hidden" id="contact_city_<?php echo $list[$i]->contact_code;?>" value="<?php echo $contact_city;?>" /><?php echo $contact_city;?></td>
                    <td class="<?php echo $class;?>"><input type="hidden" id="contact_status_<?php echo $list[$i]->contact_code;?>" value="<?php echo $list[$i]->contact_status;?>" /><label id="lbl_contact_status_<?php echo $list[$i]->contact_code;?>"><?php echo $contact_status;?></label></td>
                    
                    <td class="<?php echo $class;?>">
                        <a href="javascript:;" onclick="viewContactUs(<?php echo $list[$i]->contact_code;?>)"><?php echo $messages["general_view"];?></a>
                    </td>
                </tr>            
                <?php $i++; }?>            
                <?php include("paginator.php");?>
                <?php }else{?>
                <tr>
                    <td colspan="<?php echo count ($fields_sql_order_by);?>" class="no_data"><?php echo $messages["general_no_data"];?></td>
                </tr>
                <?php }?>
            </table>
        </div>
        <?php include ("footer.php");?>
	</form>
</body>
</html>