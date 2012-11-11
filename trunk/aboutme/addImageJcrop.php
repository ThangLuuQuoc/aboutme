<?php include("src/addImageJcrop_cs.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>    
	<title><?php echo $messages["general_title_jcrop"];?></title>
    <?php require ("general_includes.php");?>
	<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js" type="text/javascript"></script>
	<script src="cropper/cropper.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
		
		function onEndCrop( coords, dimensions ) {
			$( 'x' ).value = coords.x1;
			$( 'y' ).value = coords.y1;
			$( 'x2' ).value = coords.x2;
			$( 'y2' ).value = coords.y2;
			$( 'w' ).value = dimensions.width;
			$( 'h' ).value = dimensions.height;
		}
		
		Event.observe( 
			window, 
			'load', 
			function() { 
				new Cropper.ImgWithPreview(
					'testImage', { 
						minWidth: (<?php echo $w_iniAux;?>), 
						minHeight: (<?php echo $h_iniAux;?>),
						ratioDim: { x: (<?php echo $w_iniAux;?>), y: (<?php echo $h_iniAux;?>)},
						displayOnInit: true, 
						onEndCrop: onEndCrop,
						previewWrap: 'previewArea'
					} 
				) 
			} 
		);
		
		function checkCoords() {			
			var msg = '';
			if ($( 'x' ).value == '') {
				msg += '<?php echo $messages["jcrop_message_select_image"];?>\n';
			}
			
			if (msg == '') {				
				document.getElementById("save_thumb").value = "<?php echo $messages["general_loading"];?>...";
				document.getElementById("form1").submit();
				return true;				
			} else {
				coolMesage ("alert", msg);
				return false;
			}
		};
		
		function uploadImage() {
			document.getElementById("upload_file").value = "<?php echo $messages["general_loading"];?>...";
			document.getElementById("upload_image").value = 1;
			document.getElementById("form1").submit();
			return true;	
		}
		
	</script>
</head>
<body>
	<div class="content_jcrop">
		<form name="form1" id="form1" enctype="multipart/form-data" method="post">
            <input type="hidden" id="x2" name="x2" value="0" /> 
            <input type="hidden" id="y2" name="y2" value="0" /> 
            <input type="hidden" id="x" name="x" value="<?php echo $x_ini;?>" /> 
            <input type="hidden" id="y" name="y" value="<?php echo $y_ini;?>" /> 
            <input type="hidden" id="w" name="w" value="<?php echo $w_ini;?>" />
            <input type="hidden" id="h" name="h" value="<?php echo $h_ini;?>" /> 
            <input type="hidden" id="realScale" name="realScale" value="<?php echo $realScale;?>" /> 
            <input type="hidden" name="large_image_name" id="large_image_name" value="<?php echo $large_image_name;?>" />

			<?php 
			$lbl_charge_img = $messages["general_load_image"].":";
			$display_table = 'style="display:none"';
			
			if ((($w_orig < $w_ini) || ($h_orig < $h_ini)) && ($w_orig > 0 && $h_orig > 0)) {
				$error = replaceMessage($messages["general_message_errorSizeImage"], array ($w_ini, $h_ini, $w_orig, $h_orig));
			}
			
			if ( strlen ($error) > 0 ) {
				echo $messages["general_error"].": ".$error;
			} elseif ( strlen ( $large_photo_exists ) > 0 ) {
				$lbl_charge_img = $messages["general_load_other_image"].":";
				$display_table = '';
			}
			?>
			<table width="90%" cellpadding="2" cellspacing="2" align="center" class="white_table" <?php echo $display_table;?>>
                <tr><td><a onClick="javascript: window.location.href = window.location.href"><?php echo $messages["general_recharge"];?></a></td></tr>
                    <tr>
                        <td>
                        <label class="subtitle"><?php echo $messages["general_original_image"];?> (<?php echo $w_orig.'X'.$h_orig;?>)</label>
                        <?php if ($scale < 1) {?>
                        <label class="subtitle"><?php echo $messages["general_original_image_charged"];?> (<?php echo ceil ($w_orig * $scale).'x'.ceil ($h_orig * $scale);?>)</label>
                        <?php }?>
                        </td>
                    </tr>
                <tr>
                    <td align="center">
                        <div>
	                        <img src="<?php echo $upload_path.$large_image_name;?>" alt="image" id="testImage"/>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td><label class="subtitle"><?php echo $messages["general_preview_show"];?> (<?php echo $w_ini."x".$h_ini;?>).</label></td></tr>
                <tr>                    	
                	<td align="center">                   
                    <div id="previewArea" style="border:1px solid #000;"></div></td>
                </tr>                                    
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="center">
	                    <input type="submit" class="button_grv" value="<?php echo $messages["general_save_selection"];?>" id="save_thumb" onclick="return checkCoords();"/>
    	                <input type="hidden" name="upload_thumbnail"/>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
			</table>

			<table width="100%" cellpadding="2" cellspacing="2" align="center"
				class="white_table">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center">
						<table width="90%">
							<tr>
								<td colspan="2">
                                <label class="subtitle"><?php echo $lbl_charge_img;?></label>
								</td>
							</tr>
							<tr>
								<td>
                                	<input type="hidden" name="x_ini" value="<?php echo $x_ini;?>" />
                                    <input type="hidden" name="y_ini" value="<?php echo $y_ini;?>" /> 
                                    <input type="hidden" name="h_ini" value="<?php echo $h_ini;?>" />
                                    <input type="hidden" name="w_ini" value="<?php echo $w_ini;?>" />

									<label class="lbl_black"><?php echo $messages["general_image"];?></label>
                                    <input type="file" name="image" size="30"/>
                                    <input type="button" name="upload_file" id="upload_file" value="<?php echo $messages["general_load_image"];?>" onclick="javascript: uploadImage()" class="button_grv"/>
                                    <input type="hidden" name="upload_image" id="upload_image" value="0" />
								</td>
                                <td align="right">
                                <input type="button" class="button_grv_cancel" onclick="javascript: window.top.$.fn.fancybox.close();" value="<?php echo $messages["general_cancel"];?>" />
                                </td>
							</tr>
						</table>
					</td>
				</tr>				
			</table>
		</form>
	</div>
</body>
</html>