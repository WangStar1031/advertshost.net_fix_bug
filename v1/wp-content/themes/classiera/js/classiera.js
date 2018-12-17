/*
 * Show More jQuery Plugin
 * Author: Jason Alvis
 * Author Site: http://www.jasonalvis.com
 * License: Free General Public License (GPL)
 * Version: 1.0.4
 * Date: 21.05.2013
 */
(function(a){a.fn.showMore=function(b){var c={speedDown:300,speedUp:300,height:"265px",showText:"Show",hideText:"Hide"};var b=a.extend(c,b);return this.each(function(){var e=a(this),d=e.height();if(d>parseInt(b.height)){e.wrapInner('<div class="showmore_content" />');e.find(".showmore_content").css("height",b.height);e.append('<div class="showmore_trigger"><span class="more">'+b.showText+'</span><span class="less" style="display:none;">'+b.hideText+"</span></div>");e.find(".showmore_trigger").on("click",".more",function(){a(this).hide();a(this).next().show();a(this).parent().prev().animate({height:d},b.speedDown)});e.find(".showmore_trigger").on("click",".less",function(){a(this).hide();a(this).prev().show();a(this).parent().prev().animate({height:b.height},b.speedUp)})}})}})(jQuery);


//custom file input
( function ( document, window, index )
{
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
}( document, window, 0 ));




jQuery.fn.textlimit = function(limit)
{
    return this.each(function(index,val)
    {
        var $elem = jQuery(this);
        var $limit = limit;
        var $strLngth = jQuery(val).text().length;  // Getting the text
        if($strLngth > $limit)
        {
            jQuery($elem).text(jQuery($elem).text().substr( 0, $limit )+ "...");
        }
    })
};
//classiEra JS
jQuery(document).ready(function(jQuery){
    "use strict";
    jQuery.noConflict();
	jQuery('[data-toggle="tooltip"]').tooltip();
	//click on parent menu
    jQuery('.navbar .dropdown > a').on('click', function(){
        location.href = this.href;
    });
	
	jQuery('#myNavmenu .nav .dropdown').on('shown.bs.dropdown', function() {		
		jQuery(this).children().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
	}).on('hidden.bs.dropdown', function() {
		jQuery(this).children().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
	});	
    //remove class and attribute from off canvas
    jQuery(".offcanvas ul li a.dropdown-toggle").removeClass('dropdown-toggle');	
	jQuery(".classiera-box-div.classiera-box-div-v7 .buy-sale-tag").removeClass('active');
	jQuery(".classiera-box-div.classiera-box-div-v6 .classiera-buy-sel").removeClass('active');
	jQuery(".offcanvas .dropdown a:first-of-type").removeAttr('data-toggle data-hover data-animations');
	//Menu Open	
	jQuery("button[data-toggle='offcanvas']").on('click', function(event){
		event.stopPropagation();
		jQuery('.offcanvas').toggleClass('open');
    });	
	jQuery(document).on('click', function(event){
		jQuery('.offcanvas').removeClass('open');
	});
    //custom menu close and open
    jQuery("a.menu-btn").on('click', function (event) {
        event.preventDefault();
        jQuery(this).next().toggle();
        if(jQuery(".custom-menu-v5").hasClass("menu-open")){
            jQuery(".custom-menu-v5").removeClass("menu-open");
            jQuery(".menu-btn").children().removeClass("fa-times");
            jQuery(".menu-btn").children().addClass("fa-bars");
        }else{
            setTimeout( function(){
                jQuery(".custom-menu-v5").addClass("menu-open");
            },300);
            jQuery(".menu-btn").children().removeClass("fa-bars");
            jQuery(".menu-btn").children().addClass("fa-times");
        }
    });
    
    var total = jQuery('#single-post-carousel .item').length;
    jQuery('.num .total-num').html(total);
    //single post carousel
    // This triggers after each slide change
	if (window.matchMedia('(max-width: 1024px)').matches){
		jQuery('.carousel').attr('data-interval', false);
	}
    jQuery('.carousel').on('slid.bs.carousel', function () {
        var carouselData = jQuery(this).data('bs.carousel');
        var currentIndex = jQuery('#single-post-carousel .active').index('#single-post-carousel .item');
        var total = carouselData.$items.length;

        // Now display this wherever you want
        var text = (currentIndex + 1);        
        jQuery('.num .init-num').html(text);
        jQuery('.num .total-num').html(total);
    });

    //match height
    jQuery('.match-height').matchHeight();

    //active for grid list
    jQuery('.view-head .view-as li').on('click', function(){
        if(jQuery(this).hasClass("active")!== true)
        {
            jQuery('.view-head .view-as li').removeClass("active");
            jQuery(this) .addClass("active");
        }
    });

    //list and grid view
    jQuery('.view-head .view-as a').on('click', function(event){
        event.preventDefault();
        
        //add remove active class
        if(jQuery(this).hasClass("active")!== true)
        {
            jQuery('.view-head .view-as a').removeClass("active");
            jQuery(this) .addClass("active");
        }
        
        // add remove grid and list class
        var aclass = jQuery(this).attr('class');
        var st = aclass.split(' ');
        var firstClass = st[0];        
        var selector = jQuery(this).closest('.view-head').next().find('div.item');
        var classStr = jQuery(selector).attr('class'),
            lastClass = classStr.substr( classStr.lastIndexOf(' ') + 1);
        jQuery(selector)
        // Remove last class
            .removeClass(lastClass)
            // Put back .item class + the clicked elements class with the added prefix "group-item-".
            .addClass('item-' + firstClass );
        jQuery('.item-grid').matchHeight();
        jQuery('.item-list').matchHeight();

        if(jQuery('div').hasClass('item-list')){
            jQuery(".masonry-content").masonry('destroy');
            jQuery('.item-list').matchHeight({ remove: true });
            var itemList = jQuery('.item-list');
            jQuery(itemList).find('figure').addClass('clearfix');
            jQuery(itemList).parent().removeClass('masonry-content');
            var mqxs = window.matchMedia( "(min-width: 1024px)" );
            if (mqxs.matches) {
                jQuery(".classiera-advertisement .classiera-box-div h5 > a").textlimit(60);
            }else{
                jQuery(".classiera-advertisement .classiera-box-div h5 > a").textlimit(60);
            }
        }else{
            if(jQuery('div').hasClass('item-masonry')){
				jQuery('.item-masonry').parent().addClass('masonry-content');
				//masonry
                var $container = jQuery('.masonry-content');
					$container.masonry('reloadItems').masonry({
                    itemSelector: '.item-masonry',
					columnWidth: '.item-masonry'
                });
			}
		}
        
    });
	if(jQuery('div').hasClass('item-list')){
        jQuery(".masonry-content").masonry('destroy');
        jQuery('.item-list').parent().removeClass('masonry-content');
    }    
    jQuery('.classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption h5 > a').textlimit(30);
    //back to top
    var backtotop = '#back-to-top';
    if (jQuery(backtotop).length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    jQuery(backtotop).addClass('show');
                } else {
                    jQuery(backtotop).removeClass('show');
                }
            };
        backToTop();
        jQuery(window).on('scroll', function () {
            backToTop();
        });
        jQuery('#back-to-top').on('click', function (e) {
            e.preventDefault();
            jQuery('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    //category v2 hover color
    jQuery('.category-content .av-2').on('mouseenter', function(){
        var color = jQuery(this).attr('data-color');
        jQuery(this).css('background', color);

    }).on( "mouseleave", function() {
        jQuery(this).css('background', '#fafafa');
    });

    //advance search collapse
    if(jQuery(window).innerWidth() < 1024){
        jQuery("#innerSearch").removeClass('in');
    }
	//Mobile APP Button//
	var mobileNavButton = jQuery(".mobile-submit").outerHeight();
    if(jQuery(window).innerWidth() < 1025){
        jQuery('.footer-bottom').css("margin-bottom", mobileNavButton);
    }


    //user comments
   jQuery(".user-comments .media .media-body p + h5 > a").on('click', function (event) {
        event.preventDefault();
        jQuery(this).parent().next('.reply-comment-div').toggle();
    });
   jQuery(".reply-comment-div > .reply-tg-button").on('click', function () {
		jQuery(this).parent().toggle();
   });
   /*=====================================
		Comments AJAX
		This function will run Comments 
		AJAX function.
	======================================*/
   jQuery(document).on('submit', '#commentform', function(event){
		event.preventDefault();
		jQuery('.comment-success').hide();
		jQuery('.comment-error').hide();
		var commentform = jQuery('#commentform');
		var formdata = jQuery(this).serialize();		
		jQuery('.classiera--loader').show();
	    var formurl = commentform.attr('action');
		jQuery.ajax({
			type: 'post',
			url: formurl,
			data: formdata,
			error: function(XMLHttpRequest, textStatus, errorThrown){
                jQuery('.comment-error').show();
				jQuery('.classiera--loader').hide();
            },
			success: function(data, textStatus){				
                if(data == "success" || textStatus == "success"){                    
					jQuery('.user-comments').append(data);					
					jQuery('.comment-success').show();
					jQuery('.classiera--loader').hide();										
                }else{
                    jQuery('.comment-error').show();
					jQuery('.classiera--loader').hide();                    
                }
            }			
		});
		
   });
   /*=====================================
		Sub Comments AJAX
		This function will run Comments 
		AJAX function.
	======================================*/
   jQuery(document).on('submit', '#commentformSUB', function(event){
		event.preventDefault();
		jQuery('.comment-success').hide();
		jQuery('.comment-error').hide();
		var commentform = jQuery('#commentformSUB');
		var commentSub = jQuery(this);		
		var formdata = jQuery(this).serialize();		
		jQuery(this).parent().parent().find('.classiera--loader').show();	
	    var formurl = commentform.attr('action');
		jQuery.ajax({
			type: 'post',
			url: formurl,
			data: formdata,
			error: function(XMLHttpRequest, textStatus, errorThrown){
                jQuery('.comment-error').show();
				jQuery('.classiera--loader').hide();
            },
			success: function(data, textStatus){				
                if(data == "success" || textStatus == "success"){
					commentSub.parent().parent().parent().append(data);					
					commentSub.parent().parent().find('.comment-success').show();					
					commentSub.parent().parent().find('.classiera--loader').hide();				
					
                }else{                     
					jQuery(this).parent().parent().find('.comment-error').show();					
					jQuery(this).parent().parent().find('.classiera--loader').hide();
                }
            }			
		});
		
   });
   /*=====================================
		Price Range Slider function
	======================================*/
	jQuery( function() {
		var classieraMaxPrice;
		var classieraMaxPrice = jQuery("input#classieraMaxPrice").val();
		var cursign = jQuery('input#amount').attr('data-cursign');
		jQuery( "#slider-range" ).slider({
		  range: true,
		  min: 0,
		  max: classieraMaxPrice,
		  values: [ 0, classieraMaxPrice ],
		  slide: function( event, ui ) {
			jQuery( "#amount" ).val( cursign + ui.values[ 0 ] + " - "+ cursign + ui.values[ 1 ] );
			jQuery("input#range-first-val").val(ui.values[ 0 ]);
            jQuery("input#range-second-val").val(ui.values[ 1 ]);
		  }
		});
		jQuery( "#amount" ).val( cursign + jQuery( "#slider-range" ).slider( "values", 0 ) +
		  " - "+ cursign + jQuery( "#slider-range" ).slider( "values", 1 ) );		 
	});
    if(jQuery('div').hasClass('range-slider')){
       
    }
    //show more and less
    jQuery('.inner-search-box-child').showMore({
        speedDown: 300,
        speedUp: 300,
        height: '165px',
        showText: 'Show more',
        hideText: 'Show less'
    });	
    /*=====================================
		Categories AJAX Function
		This function will show sub categories
		list When click on main category.
	======================================*/
	jQuery('.classiera-post-sub-cat').hide();
    var mainCatText;
    jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
        event.preventDefault();
		jQuery('.classiera-post-sub-cat').hide();
		jQuery('.classiera_third_level_cat').hide();
		jQuery('.selectCatDisplay').hide();		
        var mainCatId = jQuery(this).attr('id');
        mainCatText = jQuery(this).find('span').text();
        jQuery(this).parent().parent().next().val(mainCatId);
        jQuery('.form-control-static').text(mainCatText);
		jQuery('#selectCatCheck').val(mainCatId);
        jQuery(this).closest('li').addClass('active');
        jQuery(this).closest('li').siblings().removeClass('active');
		var data = {
			'action': 'classieraGetSubCatOnClick',
			'mainCat': mainCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraSubReturn').html(response);
			if(response){
				jQuery('.classiera-post-sub-cat').show();
			}			
		});

    });
    var subCatText;
	
   jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classiera_third_level_cat').hide();
        var subCatId = jQuery(this).attr('id');
		var data = {
			'action': 'classieraGetSubCatOnClick',
			'subCat': subCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraSubthird').html(response);
			if(response){
				jQuery('.classiera_third_level_cat').show();
			}			
		});
        subCatText = jQuery(this).text();
        jQuery(this).parent().parent().next().val(subCatId);
        jQuery('.form-control-static').text(mainCatText +' / '+ subCatText);
    });
	jQuery('.classiera_third_level_cat').hide();
	var subThirdCatText;
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){
        event.preventDefault();
		var thirdCatId = jQuery(this).attr('id');
		subThirdCatText = jQuery(this).text();
		jQuery(this).parent().parent().next().val(thirdCatId);
		jQuery('.form-control-static').text(mainCatText +' / '+ subCatText +' / '+ subThirdCatText);
    });
	/*=====================================
		image previews
		This function will show image preview
		When select any image on Submit Ad.
	======================================*/  
    function readURL() {
        var $input = jQuery(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $input.siblings('.classiera-image-preview').show().children('.my-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	//Profile Image//
	function readProfileURL() {
        //var $input = jQuery(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
				jQuery('.uploadImage').children('.author-avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	 jQuery(".author-UP").change(readProfileURL); 
	//Profile Image//      
    jQuery(document).on('change', ".imgInp", readURL);    
    jQuery(document).on('click', ".remove-img", function () {
		jQuery(this).parents('.classiera-upload-box').find('.imgInp').val(null);
        jQuery(this).parent().hide();
        jQuery(this).prev().attr('src','#');
    });
	//Featured Image Count
	jQuery(document).on('click', '.my-image', function(){ 
		var count = jQuery(this).parent().parent().parent().index();
		jQuery('#classiera_featured_img').val(count);
	});
	//Featured Image Count
	jQuery(document).on('click', '.page-template-template-edit-post img.edit-post-image', function(){ 		
		var IMGID = jQuery(this).parent().attr('id');
		jQuery('#classiera_featured_img').val(IMGID);
	});
	jQuery(document).on('click', '.classiera-image-preview', function(){ 
		if(jQuery('.classiera-upload-box').hasClass('classiera_featured_box')){
			jQuery('.classiera-upload-box').removeClass('classiera_featured_box');
		}
		jQuery(this).parent().addClass('classiera_featured_box');
		
	});
	jQuery(document).on('click', '.edit-post-image-block img', function(){ 
		jQuery('.edit-post-image-block img').css('border','none');
		jQuery('.MultiFile-preview').css('border','none');
		jQuery(this).css('border','1px solid #e96969');
	});
	//Featured Image Count	
    //label click on submit post
	jQuery(document).on('click', '.post-type-box .radio > label', function(){    
        var bd = jQuery(this).parent().parent().parent();
        jQuery(bd).addClass('active-post-type');
        jQuery(bd).siblings().removeClass('active-post-type');
        if(jQuery(bd).hasClass()){
            jQuery(bd).removeClass('active-post-type');
            jQuery(bd).siblings().addClass('active-post-type');
        }
    });
    var outerHeightNav = jQuery(".topBar").outerHeight();
    //navbar offset
    if(jQuery(window).innerWidth() > 1025 && outerHeightNav != null){
        jQuery(".classieraNavAffix").affix({
            offset: {
                top: jQuery(".topBar").outerHeight()
            }
        });
    }
    if(jQuery(window).innerWidth() < 1025 && jQuery('section').hasClass('navbar-fixed-top')){
        jQuery('section').removeClass('navbar-fixed-top');
    }

    var navcheck = jQuery('.classiera-navbar').outerHeight() - 1;
    if(jQuery('section').hasClass('navbar-fixed-top')){
        jQuery('header').css({ 'padding-top': navcheck + 'px'});
    }
	/*=====================================
		Custom Fields At FrontEnd
	======================================*/ 	
	jQuery(document).on('click', '.classiera-post-main-cat ul li a', function(){
		var val = jQuery(this).attr('id');
  		jQuery('#primaryPostForm').find(".wrap-content").css({"display":"none"});
  		jQuery('#primaryPostForm').find("#cat-" + val).css({"display":"block"});
	});
	jQuery(document).on('click', '.classiera-post-sub-cat ul li a', function(){
		var val = jQuery(this).attr('id');
		jQuery('#primaryPostForm').find(".wrap-content").css({"display":"none"});		
  		jQuery('#primaryPostForm').find("#cat-" + val).css({"display":"block"});
	});
	/*=====================================
		Pricing Plans Function
	======================================*/ 	
	jQuery(".viewcart").hide();
	jQuery('.classiera_plan_add_to_cart').on('click', function(event){
		event.preventDefault();
		var $btn = jQuery(this);				
		var AMT = jQuery(this).parent().parent().children('input.AMT').val();		
		var wooID = jQuery(this).parent().parent().children('input.wooID').val();		
		var plan_id = jQuery(this).parent().parent().children('input.plan_id').val();		
		var CURRENCYCODE = jQuery(this).parent().parent().children('input.CURRENCYCODE').val();		
		var user_ID = jQuery(this).parent().parent().children('input.user_ID').val();		
		var plan_name = jQuery(this).parent().parent().children('input.plan_name').val();		
		var featured_ads = jQuery(this).parent().parent().children('input.plan_ads').val();		
		var regular_ads = jQuery(this).parent().parent().children('input.regular_ads').val();		
		var plan_time = jQuery(this).parent().parent().children('input.plan_time').val();
		var data = {
			'action': 'classiera_implement_woo_ajax',
			'AMT': AMT,
			'wooID': wooID,
			'plan_id': plan_id,
			'CURRENCYCODE': CURRENCYCODE,
			'user_ID': user_ID,
			'plan_name': plan_name,
			'featured_ads': featured_ads,
			'regular_ads': regular_ads,
			'plan_time': plan_time,
		};		
		jQuery.ajax({
			url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
			type: "POST",
			data:{
				action:'classiera_implement_woo_ajax', 
				AMT: AMT,
				wooID: wooID,
				plan_id: plan_id,
				CURRENCYCODE: CURRENCYCODE,
				user_ID: user_ID,
				plan_name: plan_name,
				featured_ads: featured_ads,
				regular_ads: regular_ads,
				plan_time: plan_time,
			},
			success: function(data){
				$btn.parent().hide();
				$btn.parent().parent().next('.viewcart').show();
			}
		});
    });
	//Pricing Plans Function//
	//Pay Per Post for Main categories//
	jQuery('.classieraPayPerPost').hide();
	jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
		event.preventDefault();
		jQuery('.classieraPayPerPost').hide();
		var thisCatId = jQuery(this).attr('id');		
		var data = {
			'action': 'classiera_pay_per_post_id',
			'catID': thisCatId
		};		
		jQuery.post(ajaxurl, data, function(response){			
			if(response){
				jQuery('.classieraPPP').html(response);
				jQuery('.classieraPayPerPost').show();
			}
		});
	});
	//Pay Per Post for Second level categories//
	jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){	
        event.preventDefault();
		jQuery('.classieraPayPerPost').hide();
        var subCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_pay_per_post_id',
			'catID': subCatId,
		};
		jQuery.post(ajaxurl, data, function(response){			
			if(response){
				jQuery('.classieraPPP').html(response);
				jQuery('.classieraPayPerPost').show();	
			}
		});
    });
	//Pay Per Post for Third level categories//
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){		
        event.preventDefault();
		jQuery('.classieraPayPerPost').hide();
        var subThirdCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_pay_per_post_id',
			'catID': subThirdCatId,
		};
		jQuery.post(ajaxurl, data, function(response){			
			if(response){
				jQuery('.classieraPPP').html(response);
				jQuery('.classieraPayPerPost').show();		
			}
		});
    });
	//Pay Per Post End//
	/*=====================================
		Classiera Bump Ads
	======================================*/
	jQuery('a.classiera_bump_btn').on('click', function(event){
		event.preventDefault();
		var $btn = jQuery(this);
		var product_id = $btn.next('form.classiera_bump_ad_form').children('input.product_id').val();
		var post_id = $btn.next('form.classiera_bump_ad_form').children('input.post_id').val();
		var post_title = $btn.next('form.classiera_bump_ad_form').children('input.post_title').val();
		
		jQuery.ajax({
			url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
			type: "POST",
			data:{
				action:'classiera_bump_ads', 
				product_id: product_id,
				post_id: post_id,
				post_title: post_title,
			},
			success: function(data){
				$btn.hide();				
				$btn.siblings('.classiera_bump_cart').show();
			}
		});
	});	
	/*=====================================
		Payper post with Woo Commerce
	======================================*/	
	jQuery(".classiera_ppp_cart").hide();
	jQuery('a.classiera_ppp_btn').on('click', function(event){
		event.preventDefault();
		var $btn = jQuery(this);		
		var product_id = $btn.next('form.classiera_ppp_ajax').children('input.product_id').val();
		var post_id = $btn.next('form.classiera_ppp_ajax').children('input.post_id').val();
		var post_title = $btn.next('form.classiera_ppp_ajax').children('input.post_title').val();
		var days_to_expire = $btn.next('form.classiera_ppp_ajax').children('input.days_to_expire').val();
		var data = {
			'action': 'classiera_payperpost',
			'product_id': product_id,
			'post_id': post_id,
			'post_title': post_title,
			'days_to_expire': days_to_expire,
		};
		jQuery.ajax({
			url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
			type: "POST",
			data:{
				action:'classiera_payperpost', 
				product_id: product_id,
				post_id: post_id,
				post_title: post_title,
				days_to_expire: days_to_expire,
			},
			success: function(data){
				$btn.hide();				
				$btn.siblings('.classiera_ppp_cart').show();
			}
		});		
	});
	/*Payper post with Woo Commerce*/
	//Regular Ads Plan Id//
	jQuery('.classieraGetID').on('click', function(){
		if(jQuery(this).is(':checked')){
			var dataID = jQuery(this).attr('data-regular-id');
			jQuery('.regular_plan_id').val(dataID);
		}
	});
	//Hide Quantity update from woocommerce cart page//
	jQuery('.woocommerce table .quantity input').attr('readonly', true);
	/*=====================================
		Remove Rating text Woo Commerce
	======================================*/	
	jQuery('ul.products > li.product').contents()
		.filter(function() {
		  return this.nodeType === 3;
		})
      .wrap( "<span class='hidden'></span>" )
      .end();
	/*=====================================
		Select Locations
	======================================*/
	jQuery('#post_location').on('change', function(e){
		var data = {
			'action': 'get_states_of_country',
			'CID': jQuery(this).val()
		};		
		jQuery.post(ajaxurl, data, function(response){
			if(jQuery("#post_state").length>0){
				jQuery("#post_state").html(response);
			}
		});
    });
	jQuery('#post_state').change(function(e) {
		var data = {
			'action': 'get_city_of_states',
			'ID': jQuery(this).val()
		};		
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery("#post_city").length>0){
				jQuery("#post_city").html(response);				
			}
		});
    });
	//Select Location//
	//Search Page Categories//	
	jQuery('#main_cat').on('change', function(){	
		var mainCat = jQuery(this).val();
			// call ajax
		jQuery("#sub_cat").empty();
		var data = {
			'action': 'classiera_implement_ajax',
			'mainCat': jQuery(this).val()
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				jQuery('.classiera_adv_subcat').show();
				jQuery("#sub_cat").removeAttr("disabled");
				jQuery("#sub_cat").html(response);
			}
			
		});	   
	});
	//Search Page Categories//
	jQuery("#main_cat").change(function(e){
	  jQuery(".custom-field-cat").hide();
	  jQuery(".autoHide").hide();
	  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
	  jQuery(".hide-" + jQuery(this).val()).show();
	});
	jQuery("#sub_cat").change(function(e){
	  jQuery(".custom-field-cat").hide();
	  jQuery(".autoHide").hide();
	  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
	  jQuery(".hide-" + jQuery(this).val()).show();
	});
		
	//Classiera Search Ajax//
	jQuery('.classieraSearchLoader').hide();
	jQuery('.classieraAjaxResult').hide();
	jQuery('#classieraSearchAJax').on('keyup', function(e){	
		jQuery(this).attr('autocomplete','off');
		var searchTerm = jQuery(this).val();
		if(searchTerm.length >= 1){
			jQuery('.classieraSearchLoader').show();
			var data = {
				'action': 'get_search_classiera',
				'CID': searchTerm,
			};
			jQuery.post(ajaxurl, data, function(response){					
				jQuery(".classieraAjaxResult").html(response);
				jQuery('.classieraAjaxResult').show();
				jQuery('.classieraSearchLoader').hide();
			});
		}else{
			jQuery('.classieraAjaxResult').hide();
		}	
	});	
	jQuery(document).on('click', '.classieraAjaxResult li > a.SearchLink', function(e){
		e.preventDefault();
		var myResult = jQuery(this).attr('name');		
		jQuery('#classieraSearchAJax').val(myResult);
		jQuery('.classieraAjaxResult').hide();
	});
	jQuery(document).on('click', '.classieraAjaxResult li > a.SearchCat', function(e){
		e.preventDefault();
		var optionValue = jQuery(this).attr('id');
		jQuery("#ajaxSelectCat").val(optionValue).find("option[value=" + optionValue +"]").attr('selected', true);
		jQuery('.classieraAjaxResult').hide();
	});
	jQuery(document).on('click', function(e) {
        jQuery('.classieraAjaxResult').hide();
    });
	//Classiera Search Ajax//

    //classiera other message repost
    jQuery('input[type="radio"]').on('click', function() {
       if(jQuery(this).attr('id') == 'post_other') {
            jQuery('.otherMSG').show();           
       }

       else {
            jQuery('.otherMSG').hide();   
       }
   });
   //Make Offer On Single Page//
   /*jQuery(document).on('submit', '#offerForm', function(event){
		event.preventDefault();
		jQuery(this).find('.classiera--loader').show();
		var offer_price = jQuery('#offer-text').val();
		var offer_email = jQuery('#email-offer').val();
		var classiera_current_price = jQuery('#classiera_current_price').val();
		var classiera_post_title = jQuery('#classiera_post_title').val();
		var classiera_post_url = jQuery('#classiera_post_url').val();
		var classiera_author_email = jQuery('#classiera_author_email').val();
		var data = {
			'action': 'make_offer_classiera',
			'offer_price': offer_price,
			'offer_email': offer_email,
			'classiera_current_price': classiera_current_price,
			'classiera_post_title': classiera_post_title,
			'classiera_post_url': classiera_post_url,
			'classiera_author_email': classiera_author_email,
		};		
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classieraAjaxResult").html(response);
			jQuery('.classiera--loader').hide();
			jQuery('#offerForm').find('.classieraAjaxResult').show();
		});
		
	});*/
   //remove disabled class from mobile menu
	var dis = jQuery('.offcanvas').find('ul li a.dropdown-toggle');
    if(jQuery(dis).hasClass('disabled')){
        jQuery(dis).removeClass('disabled');
    }
	
	jQuery(document).on('click', '#getLocation', function(e){
		e.preventDefault();
		jQuery.ajax({
			url: "https://geoip-db.com/jsonp",
			jsonpCallback: "callback",
			dataType: "jsonp",
			success: function(location){				
				jQuery('#getCity').val(location.city);
			}
		});
	});

    // partners-v2 border removing
    jQuery(".partners-v2-border").slice(4, 8).css('border-bottom', 'none');
    jQuery(".partners-v2-border:eq( 3 )").css('border-right', 'none');
    jQuery(".partners-v2-border:last").css('border-right', 'none');
	
	//Remove Image on Edit Post Page//
	jQuery(document).on('click', '.remImage', function(){
		jQuery(this).parent().parent().hide();
		jQuery(this).parent().find('input').attr('name', 'att_remove[]' );
		var lableNo = Math.floor((Math.random() * 10) + 1);
		//var lableNo = Math.random();
		var myHTML = '<div class="classiera-image-box"><div class="classiera-upload-box"><input class="classiera-input-file imgInp" id="imgInp'+ lableNo +'" type="file" name="upload_attachment[]"><label class="img-label" for="imgInp'+ lableNo +'"><i class="fa fa-plus-square-o"></i></label><div class="classiera-image-preview"><img class="my-image" src=""><span class="remove-img"><i class="fa fa-times-circle"></i></span></div></div></div>';
		jQuery(this).parent().parent().parent().append(myHTML);
	});
	//Get Custom Fields//
	jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var mainCatId = jQuery(this).attr('id');
		var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': mainCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();
			}			
		});

    });
    jQuery('#categorySelect').change(function(){
        var va=jQuery("#categorySelect option:selected").val();
        var vaa=jQuery("#categorySelect option:selected").html();
        jQuery('.classiera-main-cat-field').val(va);
        jQuery('.form-control-static').html(vaa);

        jQuery('.classieraExtraFields').hide();
        var mainCatId = va;
        var data = {
            'action': 'classiera_Get_Custom_Fields',
            'Classiera_Cat_ID': mainCatId,
        };
         console.log(data);
        jQuery.post(ajaxurl, data, function(response){
            jQuery('.classieraExtraFields').html(response);
            console.log(response);
            if(response){
                jQuery('.classieraExtraFields').show();
            }           
        });
    });
	jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var subCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': subCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();	
			}
		});
    });
	/*Classiera Third Cat Fields*/
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var subThirdCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': subThirdCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();	
			}
		});
    });
	/*Classiera Third Cat Fields*/
	jQuery("#cat").change(function(e){	 
	  var editCatID = jQuery(this).val();
	  var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': editCatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			jQuery('.classieraExtraFields').show();
		});
	  
	});
	//Get Custom Fields//
	//phone number hide/show
	if(jQuery('span').hasClass('phNum')){
		var ph = jQuery('.phNum').text();
		var t = ph.slice(4, 20);
		var cross = 'XXXXX';
		jQuery('.phNum').html(jQuery('.phNum').html().replace(t, cross));
		jQuery('#showNum').on('click', function(event){
			event.preventDefault();
			jQuery(this).hide();
			var older_value = jQuery('this').prev('.phNum').html();
			jQuery(this).prev('.phNum').html(jQuery('.phNum').attr('data-replace')).attr('data-replace',older_value);
		});
	}
   
	//phone number hide/show
	//Currency Tag apply//
	if(jQuery('select').hasClass('post_currency_tag')){
		jQuery(".post_currency_tag").select2();
		jQuery(document).on('change', '.post_currency_tag', function (){        
			var currencyTag = jQuery(this).val();
			var data = {
				'action': 'classiera_change_currency_tag',
				'currencyTag': currencyTag,
			};
			jQuery.post(ajaxurl, data, function(response){
				jQuery('.currency__symbol').html(response);		
			});        
		});	
	}	
	//Currency Tag apply//
	//add disable to category//	
	if(jQuery('div').hasClass('classiera__inner')){		
		jQuery('#main_cat option:selected').attr('disabled', 'disabled');		
	}
	//Classiera Locations Dropdown.
	jQuery("#classiera__loc").select2();
	//owl carousel
	setInterval(function(){ 
		jQuery('.owl-carousel').each(function(){
			var owl = jQuery(this);
			jQuery(".related-blog-post-section .navText .prev").on('click', function () {
				jQuery(this).parent().parent().parent().next().find('.owl-carousel').trigger('prev.owl.carousel');
			});
			jQuery(".related-blog-post-section .navText .next").on('click', function () {
				jQuery(this).parent().parent().parent().next().find('.owl-carousel').trigger('next.owl.carousel');
			});
			jQuery(".prev").on('click', function () {
				jQuery(this).parent().prev().children().trigger('prev.owl.carousel');
			});

			jQuery(".next").on('click', function () {
				jQuery(this).parent().prev().children().trigger('next.owl.carousel');
			});

			//number from single post page carousel
			var loopLength = owl.data('car-length');
			var divLength = jQuery(this).find("div.item").length;
			if(divLength > loopLength){
				owl.owlCarousel({
					rtl: owl.data("right"),
					nav : owl.data("nav"),
					dots : owl.data("dots"),
					items: owl.data("items"),
					slideBy : owl.data("slideby"),
					rewind: owl.data("rewind"),
					center : owl.data("center"),
					loop : owl.data("loop"),
					margin : owl.data("margin"),
					autoplay : owl.data("autoplay"),
					autoplayTimeout : owl.data("autoplay-timeout"),
					autoplayHoverPause : owl.data("autoplay-hover"),
					autoWidth:owl.data("auto-width"),
					autoHeight:owl.data("auto-Height"),
					responsiveClass: true,
					merge: owl.data("merge"),
					responsive:{
						0:{
							items:owl.data("responsive-small"),
							nav:false,
							dots : false
						},
						600:{
							items:owl.data("responsive-medium"),
							nav:false,
							dots : false
						},
						1000:{
							items:owl.data("responsive-large"),
							nav:false
						},
						1900:{
							items:owl.data("responsive-xlarge"),
							nav:false
						}
					}
				});

			}else{
				owl.owlCarousel({
					rtl: owl.data("right"),
					nav : owl.data("nav"),
					dots : owl.data("dots"),
					items: owl.data("items"),
					loop: false,
					margin: owl.data("margin"),
					autoplay:false,
					autoplayHoverPause:true,				
					responsiveClass:true,
					autoWidth:owl.data("auto-width"),
					autoHeight:owl.data("auto-Height"),
					responsive:{
						0:{
							items:owl.data("responsive-small"),
							nav:false
						},
						600:{
							items:owl.data("responsive-medium"),
							nav:false
						},
						1000:{
							items:owl.data("responsive-large"),
							nav:false
						},
						1900:{
							items:owl.data("responsive-xlarge"),
							nav:false
						}
					}
				});
			}
		});
	},1500);
	// map search
	jQuery('.classiera_map_search .classiera_map_search_btn').on('click', function() {
		jQuery(this).children().toggleClass('fa-caret-right fa-caret-left');
		jQuery(this).next().toggleClass('map_search_width');
	});
	//Classiera Verify email//
	jQuery(document).on('click', '.verify_get_code', function (event){
		event.preventDefault();
		jQuery('form.classiera_get_code_form > .classiera--loader').show();
		var verify_code = jQuery('.verify_code').val();
		var verify_user_ID = jQuery('.verify_user_id').val();
		var verify_user_email = jQuery('.verify_email').val();
		var data = {
			'action': 'classiera_send_verify_code',
			'verify_code': verify_code,
			'verify_user_ID': verify_user_ID,
			'verify_user_email': verify_user_email,
		};		
		jQuery.post(ajaxurl, data, function(response){
			jQuery('form.classiera_get_code_form > .classiera--loader').hide();
			jQuery('.classiera_verify_form').show();
		});
	});
	jQuery(document).on('click', '.verify_code_btn', function (event){
		event.preventDefault();
		jQuery('form.classiera_verify_form > .classiera--loader').show();
		var verify_user_ID = jQuery('.verify_user_id').val();
		var verify_user_email = jQuery('.verify_email').val();
		var verification_code = jQuery('.verification_code').val();
		var data = {
			'action': 'classiera_send_verify_code',
			'verification_code': verification_code,
			'verify_user_ID': verify_user_ID,
			'verify_user_email': verify_user_email,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('form.classiera_verify_form > .classiera--loader').hide();
			jQuery(".classiera_verify_congrats").html(response);
			jQuery('.classiera_verify_congrats').show();
			jQuery('.classiera_verify_btn').hide();
			
		});
	});
	//Classiera Verify email//
	//Classiera Send Offer aJax Function//
	jQuery(".submit_bid").on('click', function (event){
        event.preventDefault();
		jQuery(this).find('.classiera--loader').show();
		var offer_price = jQuery('.offer_price').val();
		var offer_comment = jQuery('.offer_comment').val();
		var offer_post_id = jQuery('.offer_post_id').val();
		var post_author_id = jQuery('.post_author_id').val();
		var offer_author_id = jQuery('.offer_author_id').val();
		var offer_post_price = jQuery('.offer_post_price').val();
		var data = {
			'action': 'make_offer_classiera',
			'offer_price': offer_price,
			'offer_comment': offer_comment,
			'offer_post_id': offer_post_id,
			'post_author_id': post_author_id,
			'offer_author_id': offer_author_id,
			'offer_post_price': offer_post_price,
		};
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classieraOfferResult").html(response);
			jQuery(".classieraOfferResult").show();
			document.getElementById("classiera_offer_form").reset();
			jQuery('.classiera--loader').hide();
			jQuery('#classiera_offer_form').find('.classieraAjaxResult').show();
		});	

    });
	/*=====================================
		Get current opened modal comment Id
		Get main Comment function
	======================================*/
	
	jQuery(document).on('show.bs.modal', '#classieraChatModal', function (event) {			
		var btn = jQuery(event.relatedTarget);
		jQuery('.classiera--loader').show();
		var commentID = btn.attr('id');
		var data = {
			'action': 'classiera_get_comment_ajax',
			'commentID': commentID,
		};
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classiera_comment_ajax_rec").html(response);
			jQuery('.classiera--loader').hide();
			jQuery("a.bid_notification").hide();
		});	
	});
	/*=====================================
		Comment Reply function
		When a user reply to any message
		then this function will call AJAX.
	======================================*/	
	jQuery(document).on('click', '.classiera_user_message__form_btn', function (event){
		event.preventDefault();
		var box = jQuery(this);
		jQuery('.classiera--loader').show();
		//var main_comment_ID = jQuery('.main_comment_ID').val();
		//var commentData = jQuery('.classiera_comment_reply').val();
		var main_comment_ID = jQuery(this).siblings('.main_comment_ID').val();
		var commentData = jQuery(this).siblings('.classiera_comment_reply').val();
		var data = {
			'action': 'classiera_get_comment_ajax',
			'main_comment_ID': main_comment_ID,
			'commentData': commentData,
		};
		jQuery.post(ajaxurl, data, function(response){					
			//jQuery(".classiera_show_reply").append(response);
			box.parent().siblings('.classiera_show_reply').append(response);
			document.getElementById("resetReply").reset();
			jQuery('.classiera--loader').hide();			
		});	
	});	
	/*=====================================
		Comment received function.
		This function will show all comments
		List via AJAX.
	======================================*/
	jQuery(".comment_rec").on('click', function (event){	
		event.preventDefault();
		jQuery('.classiera--loader').show();
		var btn = jQuery(this);			
		var offer_post_id = btn.attr('id');
		btn.parent().siblings().removeClass('active');
		btn.parent().addClass('active');
		var data = {
			'action': 'classiera_get_comment_list',
			'offer_post_id': offer_post_id,
		};
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classiera_replace_comment").html(response);
			jQuery('.classiera--loader').hide();
		});
	});
	/*=====================================
		Comment Sent function.
		This function will show all comments
		List via AJAX.
	======================================*/	
	jQuery(".comment_sent").on('click', function (event){	
		event.preventDefault();
		jQuery('.classiera--loader').show();
		var btn = jQuery(this);			
		var commentID = btn.attr('id');
		btn.parent().siblings().removeClass('active');
		btn.parent().addClass('active');
		var data = {
			'action': 'classiera_get_comment_list',
			'commentID': commentID,
		};
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classiera_sent_comment").html(response);
			jQuery('.classiera--loader').hide();
		});
	});
	/*=====================================
		Refresh User Data after 3 Min
		This function will run after every 3
		min and will show comments notification
		if there will be any new message
		in database.
	======================================*/	
	function classiera_get_user_message_status(){
		var recipient_id = classieraCurrentUserID;
		if(recipient_id != 0){
			var data = {
				'action': 'classiera_get_user_message_status',
				'recipient_id': recipient_id,
			};
			jQuery.post(ajaxurl, data, function(response){
				if(response){
					jQuery(".footer-bottom").after(response);
				}			
			});
		};
		
	};
	setInterval(function(){classiera_get_user_message_status();}, 300000);
	/*=====================================
	Classiera 3.0.5: Hide Price Section
	For specific categories.
	======================================*/
	jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
		event.preventDefault();
		var thiscatID = jQuery(this).attr('id');
		var data = {
			'action': 'classiera_hide_submitad_section',
			'checkcatid': thiscatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				if(response == thiscatID){
					jQuery('.classiera_hide_price').hide();
				}else{
					jQuery('.classiera_hide_price').show();
				}
			}			
		});
	});
	jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){
        event.preventDefault();		
        var thiscatID = jQuery(this).attr('id');
		var data = {
			'action': 'classiera_hide_submitad_section',
			'checkcatid': thiscatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				if(response == thiscatID){
					jQuery('.classiera_hide_price').hide();
				}else{
					jQuery('.classiera_hide_price').show();
				}
			}			
		});        
    });
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){
        event.preventDefault();
		var thiscatID = jQuery(this).attr('id');
		var data = {
			'action': 'classiera_hide_submitad_section',
			'checkcatid': thiscatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				if(response == thiscatID){
					jQuery('.classiera_hide_price').hide();
				}else{
					jQuery('.classiera_hide_price').show();
				}
			}			
		});		
    });
	jQuery("#cat").change(function(e){	 
		var thiscatID = jQuery(this).val();
		var data = {
			'action': 'classiera_hide_submitad_section',
			'checkcatid': thiscatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				if(response == thiscatID){
					jQuery('.classiera_hide_price').hide();
				}else{
					jQuery('.classiera_hide_price').show();
				}
			}
		});
	  
	});
	/*=====================================
	End Hide Price Section
	For specific categories.
	======================================*/
	/*=====================================
	Show Loader on Submit Ad Form
	======================================*/
	jQuery('#primaryPostForm').validator().on('submit', function (e){
		if (e.isDefaultPrevented()) {			
		}else{
			jQuery('.loader_submit_form').addClass('active');
		}		
	});
});
jQuery(window).on('load', function () {	
    var mqxs = window.matchMedia( "(max-width: 1024px)" );
    if (mqxs.matches) {
        jQuery("ul li > a.dropdown-toggle").removeAttr('data-hover');
    }
	//tooltip
    jQuery("#getLocation").tooltip();
    //user sidebar affix
	var userConetntHeight = jQuery(".user-content-height").height();
	var userAside = jQuery("#sideBarAffix").height();
		
	if(jQuery(window).innerWidth() >= 1025 && userConetntHeight > userAside) {
	//sidebar fixed
		var headerHeight = jQuery('.topBar').outerHeight(true); // true value, adds margins to the total height        
		var footerHeight = jQuery('footer').outerHeight(true) + 80;
		var partnerHeight = jQuery('.partners').outerHeight(true);	
		var bottomFooter = jQuery('.footer-bottom').outerHeight(true);		
		var bottomHeight = footerHeight + partnerHeight + bottomFooter;

		jQuery('#sideBarAffix').affix({
			offset: {
				top: headerHeight,
				bottom: bottomHeight
			}
		}).on('affix.bs.affix', function () { // before affix

			jQuery(this).css({
				/*'top': ,*/    // for fixed height
				'width': jQuery(this).outerWidth()  // variable widths
			});
		});
	}else{
		jQuery("#sideBarAffix").removeClass('affix-top');
	}
    
	if(jQuery('ul').hasClass('page-numbers')){
		jQuery(".page-numbers").addClass('pagination');
	}
	//masonary
	var $container = jQuery('.masonry-content');
    $container.masonry({
        columnWidth: '.item-masonry',
        itemSelector: '.item-masonry'
    });
	jQuery('.tab-button a[data-toggle=tab]').each(function () {
        var $this = jQuery(this);		
        $this.on('shown.bs.tab', function () {
        
            if(jQuery('div').hasClass('masonry-content')){
                $container.masonry({
                    columnWidth: '.item-masonry',
                    itemSelector: '.item-masonry'
                });
            }
            

        }); //end shown
    });  //end each
	
});
// $('.grid').masonry({
//     percentPosition: true,
//     columnWidth: '.grid-sizer',
//     itemSelector: '.grid-item',
// });