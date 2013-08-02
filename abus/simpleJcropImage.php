<?php require ("src/jcropImage_cs.php");?>
<html lang="en">
<head>
    <title><?php echo $titlePage;?></title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

    <script src="js/jcrop/jquery.min.js"></script>
    <script src="js/jcrop/jquery.Jcrop.js"></script>
    <script src="js/jcrop/simpleJcropControl.js"></script>

    <link rel="stylesheet" href="css/jcrop/styles_jcrop.css" type="text/css" />
    <link rel="stylesheet" href="css/jcrop/jquery.Jcrop.css" type="text/css" />
</head>
<body>
    <div class="jc-demo-box">
        <form id="formJcrop" name="formJcrop" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="tmpImageName" id="tmpImageName" value="<?php echo $tmpImageName;?>" />
            <input type="hidden" name="widthAreaSelection" id="widthAreaSelection" value="<?php echo $widthAreaSelection;?>" />
            <input type="hidden" name="hightAreaSelection" id="hightAreaSelection" value="<?php echo $hightAreaSelection;?>" />
            <input type="hidden" name="widthAreaSelectionAux" id="widthAreaSelectionAux" value="<?php echo $widthAreaSelectionAux;?>" />
            <input type="hidden" name="hightAreaSelectionAux" id="hightAreaSelectionAux" value="<?php echo $hightAreaSelectionAux;?>" />
            <input type="hidden" name="positionXAreaSelection" id="positionXAreaSelection" value="<?php echo $positionXAreaSelection;?>" />
            <input type="hidden" name="positionYAreaSelection" id="positionYAreaSelection" value="<?php echo $positionYAreaSelection;?>" />
            <input type="hidden" name="tmpImageName" id="tmpImageName" value="<?php echo $tmpImageName;?>" />
            <input type="hidden" name="scaleResize" id="scaleResize" value="<?php echo $scaleResize;?>" />
            <input type="hidden" name="msgSelectImageArea" id="msgSelectImageArea" value="<?php echo $msgSelectImageArea;?>" />
            <input type="hidden" name="divContent" id="divContent" value="<?php echo $divContent;?>" />
            <input type="hidden" name="idInputHidden" id="idInputHidden" value="<?php echo $idInputHidden;?>" />
            <input type="hidden" name="function" id="function" value="<?php echo $function;?>" />
            

            <!-- Variables JCrop -->
            <input type="hidden" size="4" id="x1" name="x1" />
            <input type="hidden" size="4" id="y1" name="y1" />
            <input type="hidden" size="4" id="x2" name="x2" />
            <input type="hidden" size="4" id="y2" name="y2" />
            <input type="hidden" size="4" id="w" name="w" />
            <input type="hidden" size="4" id="h" name="h" />

            <div>
                <input type="file" name="imageJcrop" id="imageJcrop"/>
                <?php if (strlen($pathImageToCrop) > 0) {?>
                <input type="submit" class="btn-mini-azul" value="<?php echo $lblEndCrop;?>" onclick="return checkCoords();"/>
                <label><input type="checkbox" id="ar_lock" />Aspect ratio</label>
                <?php }?>
            </div>

            <div id="div.message">
                <?php if (strlen ($messageValue) > 0) {?>
                <p class="<?php echo $messageType;?>">
                    <strong><?php echo $lblAtention;?></strong>
                    <?php echo $messageValue;?>
                </p>
                <?php }?>
            </div>
            <div class="div_items">
            <?php if (strlen($pathImageToCrop) > 0) {?>
            <img src="<?php echo $pathImageToCrop;?>" id="target" alt="[Original Image]"/>
            <?php }?>
            </div>
        </form>
    </div>                
</body>
</html>

