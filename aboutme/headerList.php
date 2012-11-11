<tr>
    <td colspan="<?php echo count ($fields_sql_order_by);?>"><span class="title"><?php echo $titlePage;?></span></td>
</tr>
<tr>
    <td colspan="<?php echo count ($fields_sql_order_by);?>">
        <table class="tbl_search">
            <tr>
                <td width="10%"><?php if (!empty ($titleAdd)) {?><input type="button" value="<?php echo $titleAdd;?>" class="button_grv" onclick="javascript: window.location.href='<?php echo $scriptAdd;?>'"/><?php }?></td>
                <?php if (isset ($searcher)) {?>
                <td><?php echo $searcher;?></td>
                <?php }?>
                <td width="35%" align="right"><input type="text" name="search" size="40" value="<?php echo $search;?>" class="text_grv" /><input type="submit" name="Submit" value="<?php echo $messages["general_search"];?>" class="button_grv"/></td>
            </tr>
        </table>
    </td>
</tr>