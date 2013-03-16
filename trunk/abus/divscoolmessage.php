<div id='confirm' style='display: none'>
	<a href='javascript:;' title='Close' class='modalCloseX modalClose'>x</a>
	<div class='header'>
		<span>
			<?php echo $messages["general_confirm"];?>
		</span>
	</div>
	<table width="100%" style="vertical-align: top;">
		<tr>
			<td width="48"><img src="images/dialog-help.png" /></td>
			<td class="message"></td>
		</tr>
	</table>
	<div class='buttons'>
		<div class='no'>
			<input type="button" class="w8-icon grey" value="<?php echo $messages["general_cancel"];?>" />
		</div>
		<div class='yes'>
			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_acept"];?>" />
		</div>
	</div>
</div>
<div id='alert' style='display: none; padding-bottom: 20px'>
	<a href='javascript:;' title='Close' class='modalCloseX modalClose'>x</a>
	<div class='header'>
		<span>
			<?php echo $messages["general_alert"];?>
		</span>
	</div>
	<table width="100%" style="vertical-align: top;">
		<tr>
			<td width="48"><img src='images/dialog-warning.png' /></td>
			<td class='message'></td>
		</tr>
	</table>
	<div class='buttons'>
		<div class='yes'>
			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_acept"];?>" />
		</div>
	</div>
</div>
<div id='error' style='display: none; padding-bottom: 20px'>
	<a href='javascript:;' title='Close' class='modalCloseX modalClose'>x</a>
	<div class='header'>
		<span>
			<?php echo $messages["general_error"];?>
		</span>
	</div>
	<table width="100%" style="vertical-align: top;">
		<tr>
			<td width="48"><img src="images/dialog-error.png" /></td>
			<td class="message"></td>
		</tr>
	</table>
	<div class='buttons'>
		<div class='yes'>
			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_acept"];?>" />
		</div>
	</div>
</div>
<div id='information' style='display: none; padding-bottom: 20px'>
	<a href='javascript:;' title='Close' class='modalCloseX modalClose'>x</a>
	<div class='header'>
		<span>
			<?php echo $messages["general_information"];?>
		</span>
	</div>
	<table width="100%" style="vertical-align: top;">
		<tr>
			<td width="48"><img src="images/dialog-information.png" /></td>
			<td class="message"></td>
		</tr>
	</table>
	<div class='buttons'>
		<div class='yes'>
			<input type="button" class="w8-icon l-blue" value="<?php echo $messages["general_acept"];?>" />
		</div>
	</div>
</div>
<div id='loadingInfo' style='display: none;'>
	<div class='header'>
		<span><?php echo $messages["general_loading"];?>...</span>
	</div>
	<div class="contenidoPopup">
		<div>
			<table width="100%" style="vertical-align: top; margin-left: 10px">
				<tr>
					<td align="center"><img src="images/30.gif"></td>
				</tr>
			</table>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>