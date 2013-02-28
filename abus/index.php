<?php require ("src/index_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php echo $messages["general_title_init"] . " :: " . $messages["general_name_app"]; ?>
        </title>
        <script language="javaScript" type="text/javascript" src="js/jquery.js"></script>
        <?php require("general_includes.php"); ?>
        <script language="javaScript" type="text/javascript">
            function enter(event) {
                var enterCodigo = event.keyCode ? event.keyCode
                : event.which ? event.which : event.charCode;
                if (enterCodigo == 13) {
                    validateForm();
                }
            }
            function validateForm() {
                f = window.document.form1;

                var msg = '';

                if (document.getElementById("login").value == "")
                    msg += '- <?php echo $messages["validationUser_userRequired"]; ?><br />';

                if (document.getElementById("password").value == "")
                    msg += '- <?php echo $messages["validationUser_passwordRequired"]; ?><br />';

                if (document.getElementById("code")) {
                    if (document.getElementById("code").value == '') {
                        msg += '- <?php echo $messages["validationUser_securityCodeRequired"]; ?>.<br />';
                    }
                }

                if (msg == '') {
                    f.submit();
                    return true;
                } else {
                    coolMessage('alert', msg);
                    return false;
                }
            }
        </script>

    </head>
    <body onload="javascript: showMessage(<?php echo $message_show; ?>)">
        <div class="logo"></div>
        <form name="form1" method="post" action="">
            <table width="99%" class="tbl_login">
                <tr>
                    <td width="85%">
                        <table width="100%">
                            <tr>
                                <td colspan="3" class="lbl_title">
                                    <?php echo $messages["general_authentication"]; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right"><span class="lbl_gray"> <?php echo $messages["user_user"]; ?>:
                                    </span></td>
                                <td width="1%">&nbsp;</td>
                                <td><input type="text" name="login" id="login"
                                           class="text_grv" size="30"
                                           value="<?php echo $loginUsername; ?>"
                                           onKeyPress="return enter(event)" /></td>
                            </tr>
                            <tr>
                                <td align="right"><span class="lbl_gray"> <?php echo $messages["user_password"]; ?>:
                                    </span></td>
                                <td>&nbsp;</td>
                                <td><input type="password" name="password" id="password"
                                           class="text_grv" size="30" value=""
                                           onKeyPress="return enter(event)" /></td>
                            </tr>
                            <?php if ($_SESSION['intentosLog'] >= 4) { ?>
                                <tr>
                                    <td align="right"><span class="lbl_gray"> <?php echo $messages["general_securityImage"]; ?>:
                                        </span></td>
                                    <td>&nbsp;</td>
                                    <td valign="top"><img
                                            src="includes/generar_imagen_seguridad.php" align="absmiddle"
                                            style="padding-left: 5px;" /></td>
                                </tr>
                                <tr>
                                    <td align="right"><span class="lbl_gray"> <?php echo $messages["general_insertSecurityImage"]; ?>:
                                        </span></td>
                                    <td>&nbsp;</td>
                                    <td valign="top"><input name="code" id="code" type="text"
                                                            class="text_grv" size="12" maxlength="6"
                                                            onKeyPress="return enter(event)"></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <input type="button"
                                           class="button_grv"
                                           value="<?php echo $messages["general_login"]; ?>"
                                           onclick="javascript: validateForm()" /> <input type="button"
                                           class="button_grv_cancel"
                                           value="<?php echo $messages["general_clear"]; ?>" />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top"><img src="../images/logo.png" style="border: 0px;" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php include ('divscoolmessage.php'); ?>