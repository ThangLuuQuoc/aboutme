<?php require ("src/menu_cs.php");?>
<nav>
    <ul id="appleNav">
    <?php
	$i = 0;
	$continueLoop = true;
	$cont = $countMenuPublic;
	while ($cont) {
		$i++;
		
		if (! isset ($appMenuPublic[$i])) {
			continue;
		}
		$cont--;
		$class_li = '';
		if ($menu_code == $appMenuPublic[$i]->menu_code) {
			$class_li = 'current';
			$color_a = "#fff";
		} else {
			$color_a = "#fff";	
		}
		
		$submenu = "";
		if (isset ($appMenuPublic[$i]->submenu) && ! empty ($appMenuPublic[$i]->submenu)) {
			$class_li .= ' sub';
			$submenu = $appMenuPublic[$i]->submenu;
		}

		if ($i == 1) {
			$textLink = $imgLogoSmall;
		} else {
			$textLink = $appMenuPublic[$i]->menu_value;
		}
	?>
    <li class="<?php echo trim ($class_li);?>"><a href="/<?php echo $appMenuPublic[$i]->menu_link;?>" style="color:<?php echo $color_a;?>;"><?php echo $textLink;?></a><pre><?php echo $submenu;?></pre></li>
    <?php }?>
        <li>
            <form>
                <input type="text" />
            </form>
        </li>
    </ul>
</nav>