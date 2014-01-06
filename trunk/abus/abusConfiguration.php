<?php
$dbname = 'abus';

if (!mysql_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

$sql = "SHOW TABLES FROM $dbname";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
printf('<ul>');
while ($row = mysql_fetch_row($result)) {
    printf ('<li>' . $row[0] . '</li>');
}
printf('</ul>');
mysql_free_result($result);
?>

<?php include("src/addUpdateCharge_cs.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage . " :: " . $messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>

<script language="javascript" type="text/javascript">
	function validate() {
		var msg = '';

		var chg_name = document.getElementById("chg_name").value;
		var chg_name_e = document.getElementById("chg_name_e").value;		

		if (chg_name == '') {
			msg += '- <?php echo $messages["validationCharge_nameRequired"];?><br />';
		}

		if (chg_name_e == '') {
			msg += '- <?php echo $messages["validationCharge_nameRequired_e"];?><br />';
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
	<?php $item_select = 10; include ("menu.php");?>
	<form name="form" id="form" method="post" action="">
		<input type="hidden" name="save" id="save" value="1" />
		<input type="hidden" name="chg_code" id="chg_code" value="<?php echo $chg_code;?>" />
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
								<td width="35%" align="right"><span class="lbl_gray">
										<?php echo $messages["general_name"]." ".$messages["general_spanish"];?>:
								</span></td>
								<td width="1%">&nbsp;</td>
								<td><input type="text" name="chg_name" id="chg_name"
									class="text_grv" size="30" maxlength="45" value="<?php echo $chg_name;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["general_name"]." ".$messages["general_english"];?>:
								</span></td>
								<td>&nbsp;</td>
								<td><input type="text" name="chg_name_e"
									id="chg_name_e" class="text_grv" size="30" maxlength="45" value="<?php echo $chg_name_e;?>"/></td>
							</tr>
							<tr>
								<td align="right"><span class="lbl_gray">
										<?php echo $messages["general_status"]?>:
								</span></td>
								<td>&nbsp;</td>
								<td>
                                	<select name="chg_status" id="chg_status" class="text_grv">
                                        <option value="1" <?php if ($chg_status == 1) {?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                                        <option value="2" <?php if ($chg_status == 2) {?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                                    </select>
                                    <label class="note"><?php echo $messages["general_note_status"];?></label>
                                </td>
							</tr>
							<tr>
								<td colspan="3" align="center">
                                	<input type="button"
									class="button_grv" value="<?php echo $messages["general_save"]?>"
									onclick="javascript: validate ();"/>
                                    
                                    <input type="reset"
									value="<?php echo $messages["general_clear"]?>"
									class="button_grv_cancel"/>
                                    
                                    <input type="button"
									class="button_grv_cancel" value="<?php echo $messages["general_cancel"]?>"
									onClick="javascript:window.location.href='listServicesType.php';" /></td>
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