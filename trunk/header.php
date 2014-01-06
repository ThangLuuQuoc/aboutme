<div id="Header">
    <div class="logo"></div>	
    <div class="Datinfo">
        <div class="langs">
            <?php echo $messages_p["general_languaje"]; ?>: <a href="/en" <?php if ($_SESSION["lang"] == "en") { ?> style="font-weight:bold;"<?php } ?>><?php echo $messages_p["general_english"]; ?></a> - <a href="/es" <?php if ($_SESSION["lang"] == "es") { ?> style="font-weight:bold;"<?php } ?>><?php echo $messages_p["general_spanish"]; ?></a>
        </div>
        <div class="redes">
            <?php if (strlen(FACEBOOK_URL)) {?>
            <a href="<?php echo FACEBOOK_URL;?>" target="_blank"><img src="/images/facebook.png" align="absmiddle" width="24" height="24" /></a> 
            <?php }?>
            
            <?php if (strlen(TWITTER_URL)) {?>
            <a href="<?php echo TWITTER_URL;?>" target="_blank"><img src="/images/twitter.png"  align="absmiddle" width="24" height="24"/></a>
            <?php }?>
            
            <?php if (strlen(WHATSAPP)) {?>
            <a href="#"><img src="/images/whatsapp28x28.png"  align="absmiddle" width="28" height="28"/> <?php echo WHATSAPP;?></a>
            <?php }?>
        </div>
        <div class="Slogan"><?php echo $app_slogan; ?></div>
    </div>
</div>
<script src="js/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>
<?php 
    if (strlen(SPECIAL_MODULE)) {
        include (SPECIAL_MODULE);
    }
?>