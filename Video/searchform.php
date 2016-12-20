<div class="searchform">
  <form method="get" id="searchform" action="<?php home_url(); ?>">
    <input name="s" id="s" class="s" type="text" onfocus="if(this.value=='<?php _e('Search here','templatic');?>') this.value='';" onblur="if(this.value=='') this.value='<?php _e('Search here','templatic');?>';" value="<?php _e('Search here','templatic');?>" />   
    <input type="image" class="search_btn" src="<?php bloginfo('template_url'); ?>/images/search_icon.png" alt="Submit button" />
  </form>
</div>
