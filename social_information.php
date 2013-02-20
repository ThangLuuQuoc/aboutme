<?php require ("src/personal_cs.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico">
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<?php require("general_includes.php");?>
</head>
<body>
	<div class="wrap">
		<?php include ("header.php");?>
		<?php include ("menu.php");?>
		<div id="Main" class="shadowB">
			<div class="bloq-a">
				<div class="content-a">
					<div class="spc">
                        <img src="/informacion social.PNG" style="margin-left:-5px;"/>
                    </div>
				</div>
			</div>
			<?php include ("bloq-b.php");?>
		</div>
	</div>
	<?php include ("footer.php");?>
</body>
</html>