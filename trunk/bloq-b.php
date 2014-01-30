<div class="bloq-b">
    <div class="contt">
        <?php 
        
        if ($dataAppPublic->app_advertising_type == 2) { // social
        ?>
    	<div class="fb-like-box" 
    		data-href="<?php echo $dataAppPublic->app_facebook;?>" 
    		data-width="305" 
    		data-show-faces="true" 
    		data-stream="true" 
    		data-show-border="false" 
    		data-header="true">
    	</div>
        <?php } 
        if ($dataAppPublic->app_advertising_type == 1) { // banner
            require ("includes/class/banner.class.php");
                
            $banner = new Banner();
            
            $imagePathBanner = "file_upload/banner/520x880/";
            $imagePathBannerSmall = "file_upload/banner/118x200/";

            $images = $banner->getBannerImages($_SESSION["lang"]);
            $countImages = $banner->countBannerImages();
        ?>
        <div class="ms-gallery-template" id="ms-gallery-1">
            <!-- masterslider -->
            <div class="master-slider ms-skin-black-2 round-skin" id="masterslider">
        <?php
            for ($i = 0; $i < $countImages; $i++) {
                $pathImage = $imagePathBanner . $images[$i]->imgb_rename;
                $pathImageSmall = $imagePathBannerSmall . $images[$i]->imgb_rename;
                if (!file_exists ($pathImage) || !file_exists ($pathImageSmall)) {
                    continue;
                }
        ?>
                <div class="ms-slide">
                    <img src="/masterslider/blank.gif" data-src="<?php echo $pathImage;?>" alt="<?php echo $images[$i]->imgb_name;?>"/> 
                    <img src="<?php echo $pathImageSmall;?>" alt="thumb-<?php echo ($i + 1);?>" class="ms-thumb"/>
                    <div class="ms-info">
                        <?php echo $images[$i]->imgb_name;?>
                    </div>
                </div>
        <?php } ?>
            </div>
            <!-- end of masterslider -->
        </div>
        <script type="text/javascript">     
        
            var slider = new MasterSlider();
            slider.setup('masterslider' , {
                width:520,
                height:880,
                space:10,
                preload:3,
                view:'basic',
                autoplay:true
            });
            slider.control('arrows');   
            
            var gallery = new MSGallery('ms-gallery-1' , slider);
            gallery.setup();
            
        </script>
        <?php }?>
	</div>
</div>