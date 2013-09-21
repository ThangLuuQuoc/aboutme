<?php include('src/listFaq_cs.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>

<script language="javascript" type="text/javascript">
	
	function orderItem(index, valor, faq_code) {
		var amount_list = document.getElementById("amount_list").value;
		var order_prev = document.getElementById("order_prev_"+index).value;
		var faq_order = document.getElementById("faq_order_"+index).value;

		jQuery.ajax({
			type: "POST",
			url: "ajaxFaq.php",
			data: 'faq_code='+faq_code+"&faq_order="+faq_order,
			success: function(result){
				if (result == 1) {
					var itemOrder;
					for (var i=0; i<amount_list; i++) {
						for (var j=0; j<amount_list; j++) {
							itemOrder = document.getElementById("order_"+i+"_"+j);
							if ((itemOrder.value == faq_order) && index != i && faq_order != '-1') {
								itemOrder.disabled = 1;
							}
							
							if ((itemOrder.value == order_prev) && order_prev != '-1' ) {
								itemOrder.disabled = 0;
							}
						}	
					}
					
					document.getElementById("order_prev_"+index).value = faq_order;
				} else {
					alert("<?php echo $messages["general_message_errorOrder"];?>");
				}
			}
		});
	}
	
	function changeStatusItem(index, new_faq_status, faq_code){
		jQuery.ajax({
		type: "POST",
		url: "ajaxFaq.php",
		data: 'faq_code='+faq_code+"&faq_status="+new_faq_status,
		success: function(result) {
			
			if (result == 1) {
				coolMessage("information", "<?php echo $messages["general_message_updatedStatusItem"];?>");
			} else {
				coolMessage("error", "<?php echo $messages["general_message_errorUpdatingStatusItem"];?>");
			}
		}
		});
	}
	
	function deleteItem(index, new_faq_status, faq_code){
		coolMessage("confirm", "<?php echo $messages["general_message_confirmDelete"]?>", function(){
			jQuery.ajax({
			type: "POST",
			url: "ajaxFaq.php",
			data: 'faq_code='+faq_code+"&faq_status="+new_faq_status,
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
</script>

</head>
<body onload="javascript: showMessage(<?php echo $message_show;?>)">
	<?php $item_select = 9; include("menu.php");?>
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
                ?>
                <tr id="tr_<?php echo $i;?>">
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->faq_query;?></td>
                    <td class="<?php echo $class;?>">
                        <select id="faq_status_<?php echo $i;?>" onchange="javascript: changeStatusItem(<?php echo $i;?>, this.value, <?php echo $list[$i]->faq_code;?>)"
                        		class="text_grv">
                            <option value="1" <?php if ($list[$i]->faq_status == 1 ){ ?> selected="selected" <?php }?>><?php echo $messages["general_active"];?></option>
                            <option value="2" <?php if ($list[$i]->faq_status == 2 ){ ?> selected="selected" <?php }?>><?php echo $messages["general_inactive"];?></option>
                        </select>
                    </td>
                    <td class="<?php echo $class;?>">
                        <select id="faq_order_<?php echo $i;?>" onchange="javascript: orderItem(<?php echo $i;?>, this.value, <?php echo $list[$i]->faq_code;?>)"
                        		class="text_grv">
                            <?php 
                                for ($j = 1; $j < $countOrders; $j++) {									
                                    if ($list[$i]->faq_order == $j) {
                                        $selected = "selected";
									} else {
                                        $selected = "";
									}
                            ?>
                            <option  <?php echo $selected;?> value="<?php echo $j;?>" id="order_<?php echo $i?>_<?php echo $j?>"><?php echo $j;?></option>
                            <?php }?>
                        </select>
                        <input type="hidden" id="order_prev_<?php echo $i?>" value="<?php echo (int) $list[$i]->faq_order;?>" />
                    </td>
                    <td class="<?php echo $class;?>">
                        <a href="addUpdateFaq.php?faq_code=<?php echo $list[$i]->faq_code;?>" title="<?php echo $messages["general_update"];?>">
                        <img src="images/editar.png" width="16" height="16"  />
                        </a>
                        
                        <a href="javascript:;" onclick="javascript: return deleteItem(<?php echo $i;?>, 3, <?php echo $list[$i]->faq_code;?>);" title="<?php echo $messages["general_remove"];?>">
                        <img src="images/delete.png" width="16" height="16"  />
                        </a>
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