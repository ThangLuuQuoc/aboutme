<script language="javascript" type="text/javascript">
		
	function validateContactUs(){
		var msg = "";
		
		var contact_name = $.trim(document.getElementById("contact_name_f").value);
		var contact_email = $.trim(document.getElementById("contact_email_f").value);		
		var contact_phone = $.trim(document.getElementById("contact_phone_f").value);
		var contact_text = $.trim(document.getElementById("contact_text_f").value);
		
		if (contact_email != "" && ! isMail(contact_email)) {
			msg = " <?php echo $messages_p["validationContactus_emailValidation"];?>";
		}
		
		if (contact_name == "" || contact_email == "" || contact_phone == "" || contact_text == "") {
			msg = " <?php echo $messages_p["validationContactUs_allDataRequired"];?>";
		}
				
		if (msg == '') {
			jQuery.ajax({
				type : "POST",
				async : false,
				url : "/src/contact_us_cs.php",
				data : 'contact_name=' + contact_name + '&contact_email=' + contact_email + '&contact_phone=' + contact_phone + '&contact_text=' + contact_text + '&save=2',
				success : function(result) {
					if (result == 1) {
						document.getElementById("contact_name_f").value = "";
						document.getElementById("contact_email_f").value = "";
						document.getElementById("contact_phone_f").value = "";
						document.getElementById("contact_text_f").value = "";
						document.getElementById("message_validation").innerHTML = '<img src="/images/accepted_48.png" style="border: 0px" width="16" height="16" /> <?php echo $messages_p["general_info_send"];?>';
					} else {
						document.getElementById("message_validation").innerHTML = '<img src="/images/cancel_16.png" style="border: 0px" width="16" height="16" /> <?php echo $messages_p["general_error_send_short"];?>';
					}
				}
			});
		} else {
			document.getElementById("message_validation").innerHTML = '<img src="/images/warning_16.png" style="border: 0px" />' + msg;
			return false;
		}
	}
	
</script>
<div id="Footer">
    <div class="scp">
        <div class="colm-a">
            <div class="contt">
                <h2><?php echo $messages_p["general_principal_office"];?></h2>
                <?php echo nl2br ($dataAppPublic->app_information_office);?>
            </div>
        </div>
        <div class="colm-a">
            <div class="contt">
                <h2><?php echo $messages_p["general_site_map"];?></h2>
                <ul>
                    <?php 
                    for ($i = 1; $i < ($countMenuPublic + 1); $i++) {
                        if (! isset ($appMenuPublic[$i]->menu_code)) {
                            continue;
                        }
                        
                        $class_li = '';
                        if ($menu_code == $appMenuPublic[$i]->menu_code) {
                            $class_li = 'class="current"';
                        }
                    ?>
                    <li <?php echo $class_li;?>><a href="/<?php echo $appMenuPublic[$i]->menu_link;?>"><?php echo $appMenuPublic[$i]->menu_value;?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="colm-b">
            <div class="contt">
                <h2><?php echo $messages_p["general_contact_us"];?></h2>
                <div class="dat"><?php echo $messages_p["general_contact_us_text"];?></div>
                <div class="c-fr-a" style="margin-right: 5px;">
                    <input name="contact_name_f" id="contact_name_f" type="text" class="inp-field" maxlength="50" placeholder="<?php echo $messages_p["general_name"];?>:" /> 
                    
                    <input name="contact_email_f" id="contact_email_f" type="text" class="inp-field" maxlength="50" 
                        placeholder="<?php echo $messages_p["general_email"];?>:" /> 
                    
                    <input name="contact_phone_f" id="contact_phone_f" type="text" class="inp-field" maxlength="25" 
                        placeholder="<?php echo $messages_p["general_phone"];?>:" />
                </div>
                <div class="c-fr-a">
                    <textarea name="contact_text_f" id="contact_text_f" class="inp-fieldt" placeholder="<?php echo $messages_p["general_question_concern"];?>:"></textarea>
                </div>
                
                <div class="dbutt" style="">
                    <div class="msg_value" id="message_validation"></div><input type="button" name="button" value="<?php echo $messages_p["general_send"];?>" class="button_am" onclick="javascript: validateContactUs();"/>
                </div>
            </div>
        </div>
        <div class="footCop"><?php echo $dataAppPublic->app_text_footer;?></div>
    </div>
</div>
<?php include ("divscoolmessage.php");?>