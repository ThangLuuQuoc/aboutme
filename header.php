<div id="Header">
    <div class="logo"></div>	
    <div class="Datinfo">
        <div class="langs">
            <?php echo $messages_p["general_languaje"]; ?>: <a href="/en" <?php if ($_SESSION["lang"] == "en") { ?> style="font-weight:bold;"<?php } ?>><?php echo $messages_p["general_english"]; ?></a> - <a href="/es" <?php if ($_SESSION["lang"] == "es") { ?> style="font-weight:bold;"<?php } ?>><?php echo $messages_p["general_spanish"]; ?></a>
        </div>
        <div class="redes">
            <?php echo $messages_p["general_follow_us"]; ?>: <a href="#"><img src="/images/facebook.png" align="absmiddle" width="24" height="24" /></a> <a href="#"><img src="/images/twitter.png"  align="absmiddle" width="24" height="24"/></a>
        </div>
        <div class="Slogan"><?php echo $dataAppPublic->app_slogan; ?></div>
    </div>
</div>