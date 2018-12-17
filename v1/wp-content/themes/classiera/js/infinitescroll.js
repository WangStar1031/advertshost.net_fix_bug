jQuery(window).on('load', function() {
    "use strict";
    //Blog 
    jQuery('#all').each(function(i){
        var $currentPortfolio = jQuery(this);
        var $currentInfinite = $currentPortfolio.find('.jw-infinite-scroll');
        var $currentIsotopeContainer = $currentPortfolio.children('.container').children('.row');
        $currentIsotopeContainer=$currentIsotopeContainer?$currentIsotopeContainer:$currentPortfolio;
        // Infinite
        $currentInfinite.find('a').unbind('click').bind('click',function(e){e.preventDefault();
            var $currentNextLink = jQuery(this);
            if($currentInfinite.attr('data-has-next')==='true'&&$currentNextLink.hasClass('next')){
                var $infiniteURL = $currentNextLink.attr('href');
                $currentInfinite.find('.next').hide();
                $currentInfinite.find('.loading').show();
                jQuery.ajax({
                    type: "POST",
                    url: $infiniteURL,
                    success: function(response){
						//alert(response);
                        var $newElements = jQuery(response).find('#all').children('.container').children('.row').hasClass('row')?jQuery(response).find('#all').children('.container').children('.row').html():jQuery(response).find('#all').eq(i).html();
                        var $newURL      = jQuery(response).find('#all').find('.jw-infinite-scroll>a.next').attr('href');
                        var $hasNext     = jQuery(response).find('#all').find('.jw-infinite-scroll').attr('data-has-next');
                        jQuery(".classiera-advertisement .item.item-list .classiera-box-div figure figcaption h5 a").textlimit(10);
						if($newElements){
                            jQuery(".classiera-advertisement .classiera-box-div h5 > a").textlimit(10);
                            //$newElements=jQuery('<div />').append($newElements).find('item').css('opacity','0');
                            if($currentIsotopeContainer.hasClass('row')){
                                $currentIsotopeContainer.append($newElements);
                            }else{
                                $currentInfinite.before($newElements);
                            }
                            if($hasNext==='false'){
                                $currentInfinite.attr('data-has-next','false');
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.no-more').show();
                            }else{
                                $currentNextLink.attr('href',$newURL);
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.next').fadeIn();
                            }
                        }else{
                            $currentInfinite.attr('data-has-next','false');
                            $currentInfinite.find('.loading').hide();
                            $currentInfinite.find('.no-more') .show();
                        }
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },1000);
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },6000);
                    }
                });
            }
        });
    });
	
	
	
	
	    //Blog 
    jQuery('#panel2').each(function(i){
        var $currentPortfolio=jQuery(this);
        var $currentInfinite=$currentPortfolio.find('.jw-infinite-scroll');
        var $currentIsotopeContainer=$currentPortfolio.children('.loop-content2');
        $currentIsotopeContainer=$currentIsotopeContainer?$currentIsotopeContainer:$currentPortfolio;
        // Infinite
        $currentInfinite.find('a').unbind('click').bind('click',function(e){e.preventDefault();
            var $currentNextLink=jQuery(this);
            if($currentInfinite.attr('data-has-next')==='true'&&$currentNextLink.hasClass('next')){
                var $infiniteURL=$currentNextLink.attr('href');
                $currentInfinite.find('.next').hide();
                $currentInfinite.find('.loading').show();
                jQuery.ajax({
                    type: "POST",
                    url: $infiniteURL,
                    success: function(response){
                        var $newElements = jQuery(response).find('#panel2').children('.loop-content2').hasClass('loop-content2')?jQuery(response).find('#panel2').children('.loop-content2').html():jQuery(response).find('#panel2').eq(i).html();
                        var $newURL      = jQuery(response).find('#panel2').find('.jw-infinite-scroll>a.next').attr('href');
                        var $hasNext     = jQuery(response).find('#panel2').find('.jw-infinite-scroll').attr('data-has-next');
						if($newElements){
                            //$newElements=jQuery('<div />').append($newElements).find('item').css('opacity','0');
                            if($currentIsotopeContainer.hasClass('loop-content2')){
                                $currentIsotopeContainer.append($newElements);
                            }else{
                                $currentInfinite.before($newElements);
                            }
                            if($hasNext==='false'){
                                $currentInfinite.attr('data-has-next','false');
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.no-more').show();
                            }else{
                                $currentNextLink.attr('href',$newURL);
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.next').fadeIn();
                            }
                        }else{
                            $currentInfinite.attr('data-has-next','false');
                            $currentInfinite.find('.loading').hide();
                            $currentInfinite.find('.no-more') .show();
                        }
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },1000);
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },6000);
                    }
                });
            }
        });
    });
	
	
	   //Blog 
    jQuery('#panel3').each(function(i){
        var $currentPortfolio=jQuery(this);
        var $currentInfinite=$currentPortfolio.find('.jw-infinite-scroll');
        var $currentIsotopeContainer=$currentPortfolio.children('.loop-content3');
        $currentIsotopeContainer=$currentIsotopeContainer?$currentIsotopeContainer:$currentPortfolio;
        // Infinite
        $currentInfinite.find('a').unbind('click').bind('click',function(e){e.preventDefault();
            var $currentNextLink=jQuery(this);
            if($currentInfinite.attr('data-has-next')==='true'&&$currentNextLink.hasClass('next')){
                var $infiniteURL=$currentNextLink.attr('href');
                $currentInfinite.find('.next').hide();
                $currentInfinite.find('.loading').show();
                jQuery.ajax({
                    type: "POST",
                    url: $infiniteURL,
                    success: function(response){
                        var $newElements = jQuery(response).find('#panel3').children('.loop-content3').hasClass('loop-content3')?jQuery(response).find('#panel3').children('.loop-content3').html():jQuery(response).find('#panel3').eq(i).html();
                        var $newURL      = jQuery(response).find('#panel3').find('.jw-infinite-scroll>a.next').attr('href');
                        var $hasNext     = jQuery(response).find('#panel3').find('.jw-infinite-scroll').attr('data-has-next');
						if($newElements){
                            //$newElements=jQuery('<div />').append($newElements).find('item').css('opacity','0');
                            if($currentIsotopeContainer.hasClass('loop-content3')){
                                $currentIsotopeContainer.append($newElements);
                            }else{
                                $currentInfinite.before($newElements);
                            }
                            if($hasNext==='false'){
                                $currentInfinite.attr('data-has-next','false');
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.no-more').show();
                            }else{
                                $currentNextLink.attr('href',$newURL);
                                $currentInfinite.find('.loading').hide();
                                $currentInfinite.find('.next').fadeIn();
                            }
                        }else{
                            $currentInfinite.attr('data-has-next','false');
                            $currentInfinite.find('.loading').hide();
                            $currentInfinite.find('.no-more') .show();
                        }
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },1000);
                        setTimeout(function(){
                            $currentIsotopeContainer.children('.ad-box').css('opacity','1');
                            
                        },6000);
                    }
                });
            }
        });
    });
});