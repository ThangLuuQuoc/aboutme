<?php require ("src/contact_us_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $appMenuPublic[$menu_code]->menu_value . SEPARATOR_A . SITE_NAME; ?></title>
        <?php require("general_includes.php"); ?>
        <script language="javascript" type="text/javascript">
		
            function validate(){
                var msg = "";
		
                var contact_name = $.trim(document.getElementById("contact_name").value);
                var contact_email = $.trim(document.getElementById("contact_email").value);		
                var contact_phone = $.trim(document.getElementById("contact_phone").value);
                var contact_text = $.trim(document.getElementById("contact_text").value);
		
                if (contact_name == "") {
                    msg += "- <?php echo $messages_p["validationContactUs_nameRequired"]; ?><br />";
                }
		
                if (contact_email == "" || contact_phone == "") {
                    msg += "- <?php echo $messages_p["validationContactUs_emailPhoneRequired"]; ?><br />";
                }
		
                if (contact_email != "" && ! isMail(contact_email)) {
                    msg += '- <?php echo $messages_p["validationContactus_emailValidation"]; ?><br />';
                }
		
                if (contact_text == "") {
                    msg += "- <?php echo $messages_p["validationContactUs_queryConcernRequired"]; ?><br />";
                }
		
                if (msg == '') {
                    document.getElementById("save").value = 1;
                    document.getElementById("form1").submit();
                    return true;
                } else {
                    coolMessage("alert", msg)
                    return false;
                }		
            }
	
        </script>
    </head>

    <body onload="javascript: showMessage(<?php echo $message_show; ?>)">
        <div class="wrap">
            <?php include ("header.php"); ?>
            <?php include ("menu.php"); ?>
            <div id="Main">
                <div class="bloq-a">
                    <div id="Contents" class="shadowC">
                        <div class="spc">
                            <div class="iCont">
                                <div class="title"><?php echo $appMenuPublic[$menu_code]->menu_value; ?></div>
                                <div class="c-form">
                                    <div class="descrip"><?php echo $messages_p["general_contact_us_text"]; ?></div>
                                    <form id="form1" method="post" action="">
                                        <input type="hidden" name="save" id="save" value="0" />
                                        <div class="lab"> <?php echo $messages_p["general_name"]; ?>: </div>
                                        <input type="text" name="contact_name" id="contact_name" maxlength="50" size="50" class="inp-field" />
                                        <div class="lab"> <?php echo $messages_p["general_email"]; ?>: </div>
                                        <input type="text" name="contact_email" id="contact_email" maxlength="50" size="50" class="inp-field" />
                                        <div class="lab"> <?php echo $messages_p["general_phone"]; ?>: </div>
                                        <input type="text" name="contact_phone" id="contact_phone" maxlength="25" size="25" class="inp-field" />
                                        <div class="lab"> <?php echo $messages_p["general_country_state_city"]; ?>: </div>
                                        <input type="text" name="contact_city" id="contact_city" maxlength="50" size="50" class="inp-field" />
                                        <div class="lab"> <?php echo $messages_p["general_question_concern"]; ?>: </div>
                                        <textarea name="contact_text" id="contact_text" rows="6" style="width:80%" class="inp-field"></textarea>
                                        <div class="lab-bt">
                                            <input type="button" name="button2" id="button" class="shadowB" value="<?php echo $messages_p["general_send"]; ?>" 
                                                   onclick="return validate()"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include ("bloq-b.php"); ?>
            </div>
        </div>
        <?php include ("footer.php"); ?>

    </body>
</html>
