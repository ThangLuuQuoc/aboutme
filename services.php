<?php require ("src/services_cs.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="favicon.ico">
            <title><?php echo $appMenuPublic[$menu_code]->menu_value . SEPARATOR_A . SITE_NAME; ?></title>
            <?php require("general_includes.php"); ?>
    </head>
    <body>
        <div class="wrap">
            <?php include ("header.php"); ?>
            <?php include ("menu.php"); ?>		
            <div id="Main" class="shadowB">
                <div class="bloq-a">            	
                    <?php
                    if ($showServices) {
                        if ($listRows == 0) {
                            ?>
                            <div class="content-a">
                                <div class="spc"><div class="no_data"><?php echo $messages_p["general_no_data"]; ?></div></div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="title-a">
                                <div class="spc">
                                    <h1><?php echo $sertype_name_value;?></h1>
                                </div>
                            </div>
                            <?php
                            for ($i = 0; $i < $countRows; $i++) {
                                $serv_image = $serv_image_default;
                                if (!empty($list[$i]->serv_image)) {
                                    $path_img = "file_upload/service/620x465/" . $list[$i]->serv_image;
                                    if (file_exists($path_img)) {
                                        $serv_image = '<img src="/'.$path_img.'" width="200" height="150" alt="'.$list[$i]->serv_name.'"/></a>';
                                    }
                                }

                                $num_words = 120;
                                if (strlen($list[$i]->serv_name) > 22) {
                                    $num_words = 90;
                                }
                                ?>
                                <div class="list-a" onclick="window.location.href='/<?php echo $messages_p["app_menu_service"] . '/' . $list[$i]->serv_code . '/' . formatToUrl($list[$i]->serv_name); ?>'">
                                    <div class="spc">
                                        <div class="thumb"><?php echo $serv_image; ?></div>
                                        <h2><?php echo $list[$i]->serv_name; ?></h2>
                                        <div class="descrip"><?php echo truncate($list[$i]->serv_summary, $num_words); ?></div>
                                    </div>                    
                                </div>
                                <?php
                            }
                            ?>
                            <?php include ("pagination.php"); ?>

                            <?php
                        }
                    } elseif ($serv_code > 0 && $isServiceValid) {
                        ?>
                        <div class="content-a" style="overflow:hidden; height:auto;">
                            <div class="spc">
                                <h1><?php echo $serv_name; ?></h1>
                                <div class="sthumb"><?php echo $serv_image; ?></div>
                                <div class="descrip"><?php echo $serv_description; ?></div>
                            </div>
                        </div>
                        <?php } else {
                        ?>
                        <div class="content-a">
                            <div class="spc">
                                <h1><?php echo $appMenuPublic[$menu_code]->menu_value; ?></h1>
                                <div class="descrip"><?php echo $submenuServiceType; ?></div>
                            </div>
                        </div>
                    <?php } ?>


                </div>
                <?php include ("bloq-b.php"); ?>
            </div>
        </div>
        <?php include ("footer.php"); ?>
    </body>

</html>
<?php include('divscoolmessage.php'); ?>