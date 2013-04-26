<div class="header_app">
    <table width="100%" align="center">
        <tr>
            <td width="10%"><img src="../images/logo-h.png" /></td>
            <td align="right" valign="bottom">
                <div class="div_items_r">
                    <div class="item">
                        <?php if (isset ($_SESSION['use_name'])) {?>
                        <input type="button" class="w8-icon" value="<?php echo $_SESSION['use_name'].' '.$_SESSION['use_lastname'].' ('.$_SESSION['use_login'].')';?>"/>
                        <?php }?>
                    </div>
                    <div class="item"><input type="button" class="w8-icon pink" value="<?php echo $messages["general_logout"];?>" onclick="window.location.href='logout.php'" /></div>                    
                </div>
            </td>
        </tr>
    </table>
    <div>
        <ul id="nav">
            <li><a href="home.php"<?php if ($item_select == 0){ ?>class="current"<?php }?>><?php echo $messages["general_title_init"];?></a></li>
            <li><a href="listUser.php"<?php if ($item_select == 1){?>class="current"<?php }?>><?php echo $messages["general_title_users"];?></a></li>
            <li><a href="listItemsSlider.php"<?php if ($item_select == 2){?>class="current"<?php }?>><?php echo $messages["general_title_slider"];?></a></li>
            <li><a href="listContents.php"<?php if ($item_select == 3){?>class="current"<?php }?>><?php echo $messages["general_title_contents"];?></a></li>


            <li class="sub"><a href="listServices.php"<?php if ($item_select == 4){?>class="current"<?php }?>><?php echo $messages["general_title_services"];?></a>
                <ul>
                    <li><a href="listServicesType.php" style="font-weight:bold; color:#009FD3"><?php echo $messages["general_title_services_type"];?></a></li>
                </ul>
            </li>
            
            <li><a href="listGalleries.php"<?php if ($item_select == 6){?>class="current"<?php }?>><?php echo $messages["general_title_galleries"];?></a></li>
            <li><a href="listVideos.php"<?php if ($item_select == 7){?>class="current"<?php }?>><?php echo $messages["general_title_videos"];?></a></li>
            <li><a href="listContactUs.php"<?php if ($item_select == 8){?>class="current"<?php }?>><?php echo $messages["general_title_contact_us"];?></a></li>
			<li><a href="listFaq.php"<?php if ($item_select == 9){?>class="current"<?php }?>><?php echo $messages["general_title_faqs"];?></a></li>
            
        </ul>
    </div>
</div>
<br />