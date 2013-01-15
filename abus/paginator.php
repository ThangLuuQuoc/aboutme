<?php if ( $listRows > $amount){ ?>
<tr>
	<td colspan="<?php echo count ($fields_sql_order_by);?>" align="center">
		<table width="100%">
			<tr>
				<td align="center" width="25%"><a <?php if ($init == 0){ ?> class="lbl_gray" <?php } else {?> href="<?php echo $preview; ?>"<?php } ?>>&lt;&lt;<?php echo $messages["general_preview"];?></a></td>
				<td align="center" width="50%"><?php echo $pages; ?></td>
				<td align="center"><a <?php if ($totalPages == $actualPage){ ?> class="lbl_gray" <?php } else {?> href="<?php echo $next; ?>"<?php } ?>><?php echo $messages["general_next"];?>&gt;&gt;</a></td>
			</tr>
		</table>
	</td>
</tr>            
<?php } ?>

<tr>
	<td colspan="<?php echo count ($fields_sql_order_by);?>" class="item_c"><?php echo $band_list;?></td>
</tr>