jQuery.noConflict();
jQuery(document).ready(function(){
 jQuery("#categories_strip ul li, #page_nav ul li").hover(function(){
   jQuery(this).addClass("hover");
   jQuery('> .dir',this).addClass("open");
   jQuery('ul:first',this).css('visibility', 'visible');
 },function(){
   jQuery(this).removeClass("hover");
   jQuery('.open',this).removeClass("open");
   jQuery('ul:first',this).css('visibility', 'hidden');
 });

});