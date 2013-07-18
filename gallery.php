<?php require ("src/gallery_cs.php");?>
<!DOCTYPE html>
<html lang="">
<head>  
<meta charset="utf-8">
<title><?php echo $appMenuPublic[$menu_code]->menu_value.SEPARATOR_A.SITE_NAME;?></title>
<link href="/css/gallery.css" rel="stylesheet" type="text/css" />
<?php require("general_includes.php");?>
<!-- Add jQuery library -->
<script type="text/javascript" src="/js/fancybox_gallery/jquery-1.9.0.min.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="/js/fancybox_gallery/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="/css/fancybox_gallery/jquery.fancybox.css?v=2.1.4" media="screen" />

<script type="text/javascript">
    $(document).ready(function() {
        /*
         *  Simple image gallery. Uses default settings
         */
        $('.fancybox').fancybox();
    });
    </script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<body>
    <div class="wrap">
        <?php include ("header.php");?>
        <?php include ("menu.php");?>
        <div id="Main">
            <div id="box">
                <h1 style="padding-left:15px;"><?php echo $data->gall_name;?></h1>
                <div class="description"><?php echo $data->gall_decription;?></div>
                <ul id="thumb">
                <?php echo $html_images_thumb;?>
                </ul>                
            </div>
        </div>
    </div>
    <?php include ("footer.php");?>
</body>
</html>
