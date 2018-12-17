/*-----------------------------------------------------------------------------------*/
/*	Custom Script
/*-----------------------------------------------------------------------------------*/
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery("#select-author").change(function() {
		$val = jQuery("#select-author").val();
		jQuery(this).parent().parent().find(".wrap-content").css({"display":"none"});
		jQuery(this).parent().parent().find("#author-" + $val).css({"display":"block"});
	});
});