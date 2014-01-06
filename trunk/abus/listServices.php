<?php require ('src/listServices_cs.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>

<script language="javascript" type="text/javascript">
	
	function sendForm() {
		document.getElementById('form1').submit();
	}
	
	function orderItem(index, valor, serv_code) {
		var amount_list = document.getElementById("amount_list").value;
		var order_prev = document.getElementById("order_prev_"+index).value;
		var serv_order = document.getElementById("serv_order_"+index).value;

		jQuery.ajax({
			type: "POST",
			url: "ajaxService.php",
			data: 'serv_code='+serv_code+"&serv_order="+serv_order,
			success: function(result){
				if (result == 1) {
					var itemOrder;
					for (var i=0; i<amount_list; i++) {
						for (var j=0; j<amount_list; j++) {
							itemOrder = document.getElementById("order_"+i+"_"+j);
							if ((itemOrder.value == serv_order) && index != i && serv_order != '-1') {
								itemOrder.disabled = 1;
							}
							
							if ((itemOrder.value == order_prev) && order_prev != '-1' ) {
								itemOrder.disabled = 0;
							}
						}	
					}
					
					document.getElementById("order_prev_"+index).value = serv_order;
				} else {
					coolMessage("alert", "<?php echo $messages["general_message_errorOrder"];?>");
				}
			}
		});
	}
	
	function changeStatusItem(index, new_serv_status, serv_code){
		
		jQuery.ajax({
		type: "POST",
		url: "ajaxService.php",
		data: 'serv_code='+serv_code+"&serv_status="+new_serv_status,
		success: function(result) {
			
			if (result == 1) {
				coolMessage("information", "<?php echo $messages["general_message_updatedStatusItem"];?>");
			} else {
				coolMessage("error", "<?php echo $messages["general_message_errorUpdatingStatusItem"];?>");
			}
		}
		});
	}
	
	function deleteItem(index, new_serv_status, serv_code){
		coolMessage("confirm", "<?php echo $messages["general_message_confirmDelete"]?>", function(){
			jQuery.ajax({
			type: "POST",
			url: "ajaxService.php",
			data: 'serv_code='+serv_code+"&serv_status="+new_serv_status,
			success: 
				function(result) {
					if (result == 1) {
						$("#tr_"+index).remove();
					} else {
						coolMessage("error", "<?php echo $messages["general_message_errorDelete"];?>");
					}
				}
			});
		});
	}
	
	function highlightItem(index, serv_code){
		var serv_highlight = get("serv_highlight_" + index);
		var new_serv_highlight = null;
		var new_image = '';
		var msgConfirm = "";
		
		if (serv_highlight.value == '1') {
			new_serv_highlight = 0;
			new_image = 'images/medal-off.png';
			msgConfirm = "<?php echo $messages["general_message_confirmNoHighlight"];?>";
		} else if (serv_highlight.value == '0') {
			new_serv_highlight = 1;
			new_image = 'images/medal-on.png';
			msgConfirm = "<?php echo $messages["general_message_confirmHighlight"];?>";
		} else {
			return;	
		}
		
		coolMessage("confirm", msgConfirm, function(){
			jQuery.ajax({
			type: "POST",
			url: "ajaxService.php",
			data: 'serv_code='+serv_code+"&serv_highlight="+new_serv_highlight,
			success: 
				function(result) {
					if (result == 1) {
						get("img_highlight_" + index).setAttribute("src", new_image);
						serv_highlight.value = new_serv_highlight;
					} else {
						coolMessage("error", "<?php echo $messages["general_message_errorUpdatingStatusItem"];?>");
					}
				}
			});
		});
	}
	
</script>

</head>
<body onload="javascript: showMessage(<?php echo $messageShow;?>)">
	<?php $item_select = 4; include("menu.php");?>
    <form name="form1" id="form1" method="post" action="">
    <input type="hidden" id="amount_list" value="<?php echo $countOrders;?>" />
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
						
						$serv_image = '<img src="../images/broken-image.png" style="border:0px" width="160" height="120"/>';
                        if ( ! empty ($list[$i]->serv_image)) {
                            $path_img = "../file_upload/service/620x465/".$list[$i]->serv_image;
                            if (file_exists ($path_img)) {
                                $serv_image = '<a href="'.$path_img.'" class="fancytoImage" title="'.truncate($list[$i]->serv_summary, 40).'"><img src="'.$path_img.'" style="border:0px" width="160" height="120"/></a>';
							}
                        }
						
						if ($list[$i]->serv_highlight) {
							$img_serv_highlight = 'images/medal-on.png';
						} else {
							$img_serv_highlight = 'images/medal-off.png';
						}
                ?>
                <tr id="tr_<?php echo $i;?>">
                    <td class="<?php echo $class;?>"><?php echo $serv_image;?></td>
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->sertype_name;?></td>
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->serv_name;?></td>
                    <td class="<?php echo $class;?>"><?php echo changeFormatDate($list[$i]->serv_date_create, 1, true, false);?></td>
                    <td class="<?php echo $class;?>">
                        <select id="serv_status_<?php echo $i;?>" onchange="javascript: changeStatusItem(<?php echo $i;?>, this.value, <?php echo $list[$i]->serv_code;?>)"
		                        class="text_grv">
                            <option value="1" <?php if ($list[$i]->serv_status == 1 ){ ?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                            <option value="2" <?php if ($list[$i]->serv_status == 2 ){ ?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                        </select>
                    </td>
                    <td class="<?php echo $class;?>">
                        <select id="serv_order_<?php echo $i;?>" onchange="javascript: orderItem(<?php echo $i;?>, this.value, <?php echo $list[$i]->serv_code;?>)"
                        	class="text_grv">
                            <?php 
                                for ($j = 0; $j < $countOrders; $j++) {
                                    if ( in_array ($j, $arrayOrders)) {
                                        $disabled = "disabled";
									} else {
                                        $disabled = "";
									}
									
                                    if ($list[$i]->serv_order == $j) {
                                        $selected = "selected";
									} else {
                                        $selected = "";
									}
                            ?>
                            <option <?php echo $disabled;?> <?php echo $selected;?> value="<?php echo $j;?>" id="order_<?php echo $i?>_<?php echo $j?>"><?php echo $j;?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" id="order_prev_<?php echo $i?>" value="<?php echo (int) $list[$i]->serv_order;?>" />
                    </td>
                    <td class="<?php echo $class;?>">
                        <a href="addUpdateService.php?serv_code=<?php echo $list[$i]->serv_code;?>" title="<?php echo $messages["general_update"];?>"><img src="images/editar.png" width="16" height="16"  /></a>
                        
                        <a href="javascript:;" onclick="javascript: return deleteItem(<?php echo $i;?>, 3, <?php echo $list[$i]->serv_code;?>);" title="<?php echo $messages["general_remove"];?>"><img src="images/delete.png" width="16" height="16"  /></a>
                        
                        <a href="javascript:;" onclick="javascript: return highlightItem(<?php echo $i;?>, <?php echo $list[$i]->serv_code;?>);" title="<?php echo $messages["general_highlight"];?>"><img src="<?php echo $img_serv_highlight;?>" width="16" height="16" id="img_highlight_<?php echo $i;?>"/></a>
                        
                        <input type="hidden" name="serv_highlight" id="serv_highlight_<?php echo $i;?>" value="<?php echo $list[$i]->serv_highlight;?>" />
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