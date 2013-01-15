<?php include('src/listUser_cs.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo $titlePage." :: ".$messages["general_name_app"];?>
</title>
<?php require ("general_includes.php");?>
<script language="javascript" type="text/javascript">
	
	function userDelete(use_code,id) {
		coolMessage("confirm", '<?php echo $messages["user_message_confirmDelete"];?>',
			function (){
				jQuery.ajax({
					type: "POST",
					url: "ajaxUser.php",
					data: 'use_code='+use_code+'&use_status=4',
					success: function(msg){
						if (msg==1) {
							$("#tr_"+id).remove();
						} else {
							coolMessage("error", '<?php echo $messages["user_message_errorDelete"]?>');
						}			
					}
				});
			}
		)		
	}
	
</script>
</head>
<body onload="javascript: showMessage(<?php echo $message_show;?>)">
	<?php $item_select = 1; include("menu.php");?>
	<form name="form1" id="form1" method="post" action="">    
        <div class="content_grv">
            <table class="tbl_list">
                <?php include("headerList.php");?>
                <?php if ($listRows > 0) {?>
                <tr>
                    <?php for ( $i = 0; $i < count ($ord_href); $i++ ) {?>
                    <td class="item_head" width="<?php echo $item_width[$i];?>"><?php echo $ord_href[$i];?></td>
                    <?php }?>
                </tr>
                <?php 
                    $i=0;
                    while ($i < count ($list)) {
                        $status_value = "";
                        $class = "";
                        
                        if ($i%2 == 0) {
                            $class = 'item_a';
                        } else {
                            $class = 'item_b';
                        }
                        
                        if ($list[$i]->use_status == 1) {
                            $status_value = $messages["general_active"];
                        } elseif($list[$i]->use_status == 2) {
                            $status_value = $messages["general_inactive"];
                        } elseif($list[$i]->use_status == 3) {
                            $status_value = $messages["general_bloqued"];
                        }
                ?>
                <tr id="tr_<?php echo $i;?>">
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->use_name;?></td>
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->use_lastname;?></td>                
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->use_login;?></td>
                    <td class="<?php echo $class;?>"><?php echo $list[$i]->use_email;?></td>
                    <td class="<?php echo $class;?>"><?php echo $status_value;?></td>
                    <td class="<?php echo $class;?>">
                        <a href="addUpdateUser.php?use_code=<?php echo $list[$i]->use_code;?>" title="<?php echo $messages["general_title_users_update"];?>">
                        <img src="images/editar.png" width="16" height="16"  />
                        </a>                    
                        
                        <a href="javascript:;" onclick="javascript: return userDelete(<?php echo $list[$i]->use_code;?>,<?php echo $i;?>);" title="<?php echo $messages["general_title_users_delete"];?>">
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