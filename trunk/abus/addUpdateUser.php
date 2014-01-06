<?php include("src/addUpdateUser_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>

<script language="javascript" type="text/javascript">
	function validate() {
		var msg = '';

		var name = document.getElementById("use_name").value;
		var lastname = document.getElementById("use_lastname").value;
		var email = document.getElementById("use_email").value;
		var login = document.getElementById("use_login").value;
		var p1 = document.getElementById("use_password").value;
		var p2 = document.getElementById("confirm_pass").value;
		
		var use_code = document.getElementById("use_code").value;

		if (name == '') {
			msg += '- <?php echo $messages["validationUser_nameRequired"];?><br />';
		}

		if (lastname == '') {
			msg += '- <?php echo $messages["validationUser_lastnameRequired"];?><br />';
		}

		if (email == '') {
			msg += '- <?php echo $messages["validationUser_emailRequired"];?><br />';
		} else {
			if (!isMail(email)) {
				msg += '- <?php echo $messages["validationUser_emailValidation"];?><br />';
			}
		}

		if (login == '') {
			msg += '- <?php echo $messages["validationUser_userRequired"];?><br />';
		} else if(use_code == 0) {
			jQuery.ajax({
				type : "POST",
				async : false,
				url : "ajaxUser.php",
				data : 'use_login=' + login,
				success : function(result) {
					if (result != 1) {
						msg += result;
						document.getElementById("use_login").value = "";
					}
				}
			});
		}
		
		if (use_code == 0) {
			if (p1.length == 0 || p2.length == 0) {
				msg += '- <?php echo $messages["validationUser_passwordRequired"];?><br />';
			}
		}
		
		if ((p1 != p2 && use_code == 0) || ((p1.length > 0 || p2.length > 0) && (p1 != p2) && (use_code != 0))) {
			msg += '- <?php echo $messages["validationUser_passwordValidation"];?><br />';
		}

		if (msg == '') {
			document.getElementById('form').submit();
			return true;
		} else {
			coolMessage('alert', msg);
			return false;
		}
	}
</script>
</head>
<body onload="javascript: showMessage(<?php echo $messageShow;?>)">
	<?php $item_select = 1; include ("menu.php");?>
	<form name="form" id="form" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" name="save" id="save" value="1" />
		<input type="hidden" name="use_code" id="use_code" value="<?php echo $use_code;?>" />
		<div class="content_grv">
			<table width="90%" align="center" class="shadow">
				<tr>
					<td class="title">
						<?php echo $messages["general_title_users_add"];?>
					</td>
				</tr>
				<tr>
					<td>
						<table class="tbl_form" align="center">
							<tr>
								<td width="35%" align="right"><span class="lbl_gray">
										<?php echo $messages["user_name"]?>:
								</span></td>
								<td width="1%">&nbsp;</td>
								<td><input type="text" name="use_name" id="use_name"
									class="text_grv" size="21" maxlength="20" value="<?php echo $use_name;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["user_lastname"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="text" name="use_lastname"
									id="use_lastname" class="text_grv" size="21" maxlength="20" value="<?php echo $use_lastname;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["user_email"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="text" name="use_email" id="use_email"
									class="text_grv" size="51" maxlength="30" value="<?php echo $use_email;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["user_user"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="text" name="use_login" id="use_login"
									class="text_grv" size="15" maxlength="15" <?php if ($use_code > 0){?> readonly="readonly" <?php }?>
                                    value="<?php echo $use_login;?>"/>
                                    <label class="note"><?php echo $messages["user_note_userLogin"];?></label>
								</td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["user_password"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="password" name="use_password"
									id="use_password" class="text_grv" size="21" maxlength="20" /></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["user_confirmPassword"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="password" name="confirm_pass" id="confirm_pass"
									class="text_grv" size="21" maxlength="20" /></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" align="center">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<div class="div_items_c">
	                                    <div class="item">
	                                    	<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate ();"/> 
	                                    </div>
	                                    <div class="item">
											<input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listUser.php';" />
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
<?php include('divscoolmessage.php');?>