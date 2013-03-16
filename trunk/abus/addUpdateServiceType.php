<?php include("src/addUpdateServiceType_cs.php"); ?>
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

		var sertype_name = document.getElementById("sertype_name").value;
		var sertype_name_e = document.getElementById("sertype_name_e").value;		

		if (sertype_name == '') {
			msg += '- <?php echo $messages["validationServiceType_nameRequired"];?><br />';
		}

		if (sertype_name_e == '') {
			msg += '- <?php echo $messages["validationServiceType_nameRequired_e"];?><br />';
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
<body onload="javascript: showMessage(<?php echo $message_show;?>)">
	<?php $item_select = 4; include ("menu.php");?>
	<form name="form" id="form" method="post" action="">
		<input type="hidden" name="save" id="save" value="1" />
		<input type="hidden" name="sertype_code" id="sertype_code" value="<?php echo $sertype_code;?>" />
		<div class="content_grv">
			<table width="90%" align="center" class="shadow">
				<tr>
					<td class="title">
						<?php echo $messages["general_title_services_type_add"];?>
					</td>
				</tr>
				<tr>
					<td>
						<table class="tbl_form" align="center">
							<tr>
								<td width="35%" align="right"><span class="lbl_gray">
										<?php echo $messages["general_name"]." ".$messages["general_spanish"];?>:
								</span></td>
								<td width="1%">&nbsp;</td>
								<td><input type="text" name="sertype_name" id="sertype_name"
									class="text_grv" size="30" maxlength="45" value="<?php echo $sertype_name;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["general_name"]." ".$messages["general_english"];?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="text" name="sertype_name_e"
									id="sertype_name_e" class="text_grv" size="30" maxlength="45" value="<?php echo $sertype_name_e;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["general_status"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td>
                                	<select name="sertype_status" id="sertype_status" class="text_grv">
                                        <option value="1" <?php if ($sertype_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($sertype_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
							</tr>
							<tr>
                            	<td colspan="4">&nbsp;</td>
                            </tr>
							<tr>
								<td colspan="3" align="center">
									<div class="div_items_c">
	                                    <div class="item">
                                			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_save"]?>" onclick="javascript: validate ();"/>
	                                    </div>
	                                    <div class="item">
                                    		<input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"]?>" onClick="javascript:window.location.href='listServicesType.php';" /></td>
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