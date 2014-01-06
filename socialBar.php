<?php $socialBarClass = isset($socialBarClass) ? $socialBarClass : "socialbar-a";?>
<div class="<?php echo $socialBarClass;?>">
    <div class="item_social">
        <g:plusone size="medium"></g:plusone>
    </div>

    <div class="item_social">
        <a href="https://twitter.com/share" 
            class="twitter-share-button" 
            data-text="<?php echo truncate(isset($twitterText) ? $twitterText : "", 140);?>" 
            data-via="<?php echo TWITTER_ACCOUNT;?>" 
            data-lang="<?php echo $lang;?>" 
            counturl="<?php echo curPageURL();?>">
            Twittear
        </a>
    </div>
    
    <div class="item_social">
        <div class="fb-like" 
            data-href="<?php echo curPageURL();?>" 
            data-layout="standard" 
            data-action="like" 
            data-show-faces="false" data-share="true"></div>
    </div>
</div>
<?php if (!isset($hiddenCommentsPlugin) || $hiddenCommentsPlugin == false) {?>
<div class="<?php echo $socialBarClass;?>">
    <div class="fb-comments" data-href="<?php echo curPageURL();?>" data-numposts="5" data-colorscheme="light"></div>
</div>
<?php }?>