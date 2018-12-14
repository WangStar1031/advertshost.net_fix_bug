<?php 

function classiera_wpcss_loaded() {

	// Return the lowest priority number from all the functions that hook into wp_head
	global $wp_filter;
	$lowest_priority = max(array_keys($wp_filter['wp_head']));
	add_action('wp_head', 'classiera_wpcss_head', $lowest_priority + 1);
 
	$arr = $wp_filter['wp_head'];

}
add_action('wp_head', "classiera_wpcss_head");

function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }
 
// wp_head callback functions
function classiera_wpcss_head() {

	global $redux_demo; 
	$classieraPrimaryColor = $redux_demo['color-primary'];
	$classieraSecondaryColor = $redux_demo['color-secondary'];
	$classieraTopbarColor = $redux_demo['classiera_topbar_bg'];
	$classieraNavbarColor = $redux_demo['classiera_navbar_color'];
	$classieraNavbarTxtColor = $redux_demo['classiera_navbar_text_color'];
	$classieraStickyNav = $redux_demo['classiera_sticky_nav'];
	$body_color = $redux_demo['body-font']['color'];
	
	$heading1color = $redux_demo['heading1-font']['color'];
	$heading2color = $redux_demo['heading2-font']['color'];
	$heading3color = $redux_demo['heading3-font']['color'];
	$heading4color = $redux_demo['heading4-font']['color'];
	$heading5color = $redux_demo['heading5-font']['color'];
	$heading6color = $redux_demo['heading6-font']['color'];
	//Footer Tags//
	$classieraFooterTagsBG = $redux_demo['classiera_footer_tags_bg'];
	$classieraFooterTagsTxt = $redux_demo['classiera_footer_tags_txt'];
	$classieraFooterTagsHover = $redux_demo['classiera_footer_tags_txt_hover'];
	//Footer Bottom//
	$footerbottombg = $redux_demo['classiera_footer_bottom_bg'];	
	$footerbottomcolor = $redux_demo['classiera_footer_bottom_txt'];
	$footertxtcolor = $redux_demo['classiera_footer_txt'];
	
	//Search settiong//
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraPriceRange = $redux_demo['classiera_pricerange_on_off'];
	
	//Callout text color//
	$classieraTitleColor = $redux_demo['classiera_title_color'];
	$classieraSecondTitleColor = $redux_demo['classiera_second_title_color'];
	$classieraDescColor = $redux_demo['classiera_desc_color'];

	echo "<style type=\"text/css\">";
	
	// Main Color
	if(!empty($classieraPrimaryColor)) {
		echo ".topBar .login-info a.register, .search-section .search-form.search-form-v1 .form-group button:hover, .search-section.search-section-v3, section.search-section-v2, .search-section.search-section-v5 .form-group button:hover, .search-section.search-section-v6 .form-v6-bg .form-group button, .category-slider-small-box ul li a:hover, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption .price span:first-of-type, .classiera-box-div-v3 figure figcaption .price span:first-of-type, .classiera-box-div-v5 figure .premium-img .price, .classiera-box-div-v6 figure .premium-img .price.btn-primary.active, .classiera-box-div-v7 figure figcaption .caption-tags .price, .classiera-box-div-v7 figure:hover figcaption, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v4 figure .detail .box-icon a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v5 figure .detail .price, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .price.btn-primary.active, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .price.btn-primary.active, .advertisement-v1 .tab-divs .view-as a:hover, .advertisement-v2 .view-as .btn-group a.active, .advertisement-v2 .nav-tabs > li:active > a, .advertisement-v2 .nav-tabs > li.active > a, .advertisement-v2 .nav-tabs > li.active > a:hover, .advertisement-v2 .nav-tabs > li > a:hover, .advertisement-v2 .nav-tabs > li > a:focus, .advertisement-v2 .nav-tabs > li > a:active, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v4 .view-head .tab-button .nav-tabs > li:hover:before, .advertisement-v4 .view-head .tab-button .nav-tabs > li.active:before, .advertisement-v4 .view-head .tab-button .nav-tabs > li.active > a, .members .members-text h3, .members-v2 .members-text h4, .members-v4.members-v5 .member-content a.btn:hover, .locations .location-content .location .location-icon, .locations .location-content .location .location-icon .tip:after, .locations .location-content-v6 figure.location figcaption .location-caption span, .pricing-plan .pricing-plan-content .pricing-plan-box .pricing-plan-price, .pricing-plan-v2 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-price, .pricing-plan-v3 .pricing-plan-content .pricing-plan-box .pricing-plan-heading h4 span, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box.popular, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-heading, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:focus, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular, .pricing-plan-v6.pricing-plan-v7, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn:hover, footer .widget-box .widget-content .footer-pr-widget-v1:hover .media-body .price, footer .widget-box .widget-content .grid-view-pr li span .hover-posts span, footer .widget-box .tagcloud a:hover, .footer-bottom ul.footer-bottom-social-icon li a:hover, #back-to-top:hover, .sidebar .widget-box .widget-content .grid-view-pr li span .hover-posts span, .sidebar .widget-box .tagcloud a:hover, .sidebar .widget-box .user-make-offer-message .nav > li > a:hover, .sidebar .widget-box .user-make-offer-message .nav > li.btnWatch button:hover, .sidebar .widget-box .user-make-offer-message .nav > li.active > a, .sidebar .widget-box .user-make-offer-message .nav > li.active > button, .inner-page-content .classiera-advertisement .item.item-list .classiera-box-div figure figcaption .price.visible-xs, .author-box .author-social .author-social-icons li > a:hover, .user-pages aside .user-page-list li a:hover, .user-pages aside .user-page-list li.active a, .user-pages aside .user-submit-ad .btn-user-submit-ad:hover, .user-pages .user-detail-section .user-social-profile-links ul li a:hover, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit']:hover, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit']:focus, .submit-post form .classiera-post-main-cat ul li a:hover, .submit-post form .classiera-post-main-cat ul li a:focus, .submit-post form .classiera-post-main-cat ul li.active a, .classiera_follow_user > input[type='submit']:hover, .classiera_follow_user > input[type='submit']:focus, .mobile-app-button li a:hover, .mobile-app-button li a:focus, .related-blog-post-section .navText a:hover, .pagination > li > a:hover, .pagination > li span:hover, .pagination > li:first-child > a:hover, .pagination > li:first-child span:hover, .pagination > li:last-child > a:hover, .pagination > li:last-child span:hover, .inputfile-1:focus + label, .inputfile-1.has-focus + label, .inputfile-1 + label:hover, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .category-menu-btn span, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown.open .category-menu-btn, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > .dropdown-menu > li > a:hover, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav .dropdown-menu li > a:hover, .classiera-navbar.classiera-navbar-v6 .navbar-default .navbar-nav > li > a:hover:after, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:last-of-type:hover, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu, .offcanvas-light .log-reg-btn .offcanvas-log-reg-btn:hover, .offcanvas-light.offcanvas-dark .log-reg-btn .offcanvas-log-reg-btn:hover, .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary, .btn-primary.active:hover, .btn-primary:active:hover, .btn-primary:active, .btn-primary.active, .btn-primary.outline:hover, .btn-primary.outline:focus, .btn-primary.outline:active, .btn-primary.outline.active, .open > .dropdown-toggle.btn-primary, .btn-primary.outline:active, .btn-primary.outline.active, .btn-primary.raised:active, .btn-primary.raised.active, .btn-style-four.active, .btn-style-four:hover, .btn-style-four:focus, .btn-style-four:active, .social-icon:hover, .social-icon-v2:hover, .woocommerce .button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, #ad-address span:hover i, .search-section.search-section-v3, .search-section.search-section-v4, #showNum:hover, .price.btn.btn-primary.round.btn-style-six.active, .woocommerce ul.products > li.product a > span, .woocommerce div.product .great, span.ad_type_display, #okBtn, .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus { background: ";
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
		
		echo ".topBar .contact-info span i, .search-section.search-section-v5 .form-group button, .category-slider-small-box.outline-box ul li a:hover, .section-heading-v1.section-heading-with-icon h3 i, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption h5 a:hover, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption p a:hover, .classiera-box-div-v2 figure figcaption h5 a:hover, .classiera-box-div-v2 figure figcaption p span, .classiera-box-div-v3 figure figcaption h5 a:hover, .classiera-box-div-v3 figure figcaption span.category a:hover, .classiera-box-div-v4 figure figcaption h5 a:hover, .classiera-box-div-v5 figure figcaption h5 a:hover, .classiera-box-div-v5 figure figcaption .category span a:hover, .classiera-box-div-v6 figure figcaption .content > a:hover, .classiera-box-div-v6 figure figcaption .content h5 a:hover, .classiera-box-div-v6 figure figcaption .content .category span, .classiera-box-div-v6 figure .box-div-heading .category span, .classiera-category-ads-v4 .category-box .category-box-over .category-box-content h3 a:hover, .category-v2 .category-box .category-content .view-button a:hover, .category-v3 .category-content h4 a:hover, .category-v3 .category-content .view-all:hover, .category-v3 .category-content .view-all:hover i, .category-v5 .categories li .category-content h4 a:hover, .category-v7 .category-box figure figcaption ul li a:hover, .category-v7 .category-box figure figcaption > a:hover, .category-v7 .category-box figure figcaption > a:hover i, .category-v7 .category-box figure figcaption ul li a:hover i, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v3 figure figcaption .post-tags span i, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v3 figure figcaption .post-tags a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v5 figure .detail .box-icon a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure figcaption .content h5 a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .box-icon a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure figcaption .content h5 a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .box-icon a:hover, .advertisement-v1 .tab-divs .view-as a.active, .advertisement-v1 .tab-divs .view-as a.active i, .advertisement-v3 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v3 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v3 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v3 .view-head .tab-button .nav-tabs > li.active > a, .advertisement-v3 .view-head .view-as a:hover i, .advertisement-v3 .view-head .view-as a.active i, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v6 .view-head .tab-button .nav-tabs > li.active > a, .advertisement-v6 .view-head .view-as a:hover, .advertisement-v6 .view-head .view-as a.active, .members-v4.members-v5 .member-content h3, .members-v4.members-v5 .member-content h4, .members-v4.members-v5 .member-content a.btn, .locations .location-content-v2 .location h5 a:hover, .locations .location-content-v3 .location .location-content h5 a:hover, .locations .location-content-v5 ul li .location-content h5 a:hover, .locations .location-content-v6 figure.location figcaption .location-caption > a, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box .pricing-plan-heading .price-title, .pricing-plan-v5 .pricing-plan-content .pricing-plan-box .pricing-plan-text ul li i, .pricing-plan-v5 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button h3, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn:hover, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-heading h2, footer .widget-box .widget-content .footer-pr-widget-v1 .media-body h4 a:hover, footer .widget-box .widget-content .footer-pr-widget-v1 .media-body span.category a:hover, footer .widget-box .widget-content .footer-pr-widget-v2 .media-body h5 a:hover, footer .widget-box .widget-content ul li h5 a:hover, footer .widget-box .widget-content ul li p span a:hover, footer .widget-box .widget-content .category > li > a:hover, footer .widget-box > ul > li a:hover, footer .widget-box > ul > li a:focus, footer .widgetContent .cats ul > li a:hover, footer footer .widgetContent .cats > ul > li a:focus, .blog-post-section .blog-post .blog-post-content h4 a:hover, .blog-post-section .blog-post .blog-post-content p span a:hover, .sidebar .widget-box .widget-title h4 i, .sidebar .widget-box .widget-content .footer-pr-widget-v1 .media-body h4 a:hover, .sidebar .widget-box .widget-content .footer-pr-widget-v1 .media-body .category a:hover, .sidebar .widget-box .widget-content .footer-pr-widget-v2 .media-body h5 a:hover, .sidebar .widget-box .widget-content ul li h5 a:hover, .sidebar .widget-box .widget-content ul li p span a:hover, .sidebar .widget-box .widget-content ul li > a:hover, .sidebar .widget-box .user-make-offer-message .nav > li > a, .sidebar .widget-box .user-make-offer-message .nav > li .browse-favourite a, .sidebar .widget-box .user-make-offer-message .nav > li.btnWatch button, .sidebar .widget-box .user-make-offer-message .nav > li > a i, .sidebar .widget-box .user-make-offer-message .nav > li.btnWatch button i, .sidebar .widget-box .user-make-offer-message .nav > li .browse-favourite a i, .sidebar .widget-box > ul > li > a:hover, .sidebar .widget-box > ul > li > a:focus, .sidebar .widgetBox .widgetContent .cats ul > li > a:hover, .sidebar .widget-box .widgetContent .cats ul > li > a:focus, .sidebar .widget-box .menu-all-pages-container ul li a:hover, .sidebar .widget-box .menu-all-pages-container ul li a:focus, .inner-page-content .breadcrumb > li a:hover, .inner-page-content .breadcrumb > li a:hover i, .inner-page-content .breadcrumb > li.active, .inner-page-content article.article-content.blog h3 a:hover, .inner-page-content article.article-content.blog p span a:hover, .inner-page-content article.article-content.blog .tags a:hover, .inner-page-content article.article-content blockquote:before, .inner-page-content article.article-content ul li:before, .inner-page-content article.article-content ol li a, .inner-page-content .login-register.login-register-v1 form .form-group p a:hover, .author-box .author-contact-details .contact-detail-row .contact-detail-col span a:hover, .author-info .media-heading a:hover, .author-info span i, .user-pages .user-detail-section .user-contact-details ul li a:hover, .user-pages .user-detail-section .user-ads .media .media-body .media-heading a:hover, .user-pages .user-detail-section .user-ads .media .media-body p span a:hover, .user-pages .user-detail-section .user-ads .media .media-body p span.published i, .user-pages .user-detail-section .user-packages .table tr td.text-success, form .search-form .search-form-main-heading a i, form .search-form #innerSearch .inner-search-box .inner-search-heading i, .submit-post form .form-main-section .classiera-dropzone-heading i, .submit-post form .form-main-section .iframe .iframe-heading i, .single-post-page .single-post .single-post-title .post-category span a:hover, .single-post-page .single-post .description p a, .single-post-page .single-post > .author-info a:hover, .single-post-page .single-post > .author-info .contact-details .fa-ul li a:hover, .classiera_follow_user > input[type='submit'], .single-post .description ul li:before, .single-post .description ol li a, .mobile-app-button li a i, #wp-calendar td#today, td#prev a:hover, td#next a:hover, td#prev a:focus, td#next a:focus, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .category-menu-btn:hover span i, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown.open .category-menu-btn span i, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .dropdown-menu li a:hover, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > a:hover, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > .active > a, .classiera-navbar.classiera-navbar-v4 .dropdown-menu > li > a:hover, .classiera-navbar.classiera-navbar-v4 .dropdown-menu > li > a:hover i, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .menu-btn i, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav li.active > a, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav li > a:hover, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .login-reg .lr-with-icon:hover, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type i, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type:hover, .offcanvas-light .navmenu-brand .offcanvas-button i, .offcanvas-light .nav > li > a:hover, .offcanvas-light .nav > li > a:focus, .offcanvas-light .navmenu-nav > .open > a, .offcanvas-light .navmenu-nav .open .dropdown-menu > li > a:hover, .offcanvas-light .navmenu-nav .open .dropdown-menu > li > a:focus, .offcanvas-light .navmenu-nav .open .dropdown-menu > li > a:active, .btn-primary.btn-style-six:hover, .btn-primary.btn-style-six.active, input[type=radio]:checked + label:before, input[type='checkbox']:checked + label:before, .woocommerce-info::before, .woocommerce .woocommerce-info a:hover, .woocommerce .woocommerce-info a:focus, #ad-address span a:hover, #ad-address span a:focus, #getLocation:hover i, #getLocation:focus i, .offcanvas-light .nav > li.active > a, .classiera-box-div-v4 figure figcaption h5 a:hover, .classiera-box-div-v4 figure figcaption h5 a:focus, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular h1, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn.round:hover, .color, .classiera-box-div.classiera-box-div-v7 .buy-sale-tag, .offcanvas-light .nav > li.dropdown ul.dropdown-menu li.active > a, .classiera-navbar.classiera-navbar-v4 ul.nav li.dropdown ul.dropdown-menu > li.active > a, .classiera-navbar-v6 .offcanvas-light ul.nav li.dropdown ul.dropdown-menu > li.active > a, .sidebar .widget-box .author-info a:hover, .submit-post form .classiera-post-sub-cat ul li a:focus, .submit-post form .classiera_third_level_cat ul li a:focus, .woocommerce div.product p.price ins, p.classiera_map_div__price span, .author-info .media-heading i, span.woocommerce-Price-amount.amount, span.woocommerce-Price-currencySymbol { color: ";
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
		
		echo ".pricing-plan-v2 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-heading{ background:rgba( ";
		echo hex2rgb($classieraPrimaryColor);
		echo ",.75 )} ";
		
		echo ".pricing-plan-v2 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-heading::after{ border-top-color:rgba( ";
		echo hex2rgb($classieraPrimaryColor);
		echo ",.75 )} ";
		
		echo "footer .widget-box .widget-content .grid-view-pr li span .hover-posts{ background:rgba( ";
		echo hex2rgb($classieraPrimaryColor);
		echo ",.5 )} ";
		
		echo ".advertisement-v1 .tab-button .nav-tabs > li.active > a, .advertisement-v1 .tab-button .nav-tabs > li.active > a:hover, .advertisement-v1 .tab-button .nav-tabs > li.active > a:focus, .advertisement-v1 .tab-button .nav > li > a:hover, .advertisement-v1 .tab-button .nav > li > a:focus, .members-v4, form .search-form #innerSearch .inner-search-box .slider-handle, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type:hover i{ background-color: ";		
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
		
		echo ".search-section .search-form.search-form-v1 .form-group button:hover, .search-section.search-section-v5 .form-group button, .search-section.search-section-v5 .form-group button:hover, .search-section.search-section-v6 .form-v6-bg .form-group button, .advertisement-v1 .tab-button .nav-tabs > li.active > a, .advertisement-v1 .tab-button .nav-tabs > li.active > a:hover, .advertisement-v1 .tab-button .nav-tabs > li.active > a:focus, .advertisement-v1 .tab-button .nav > li > a:hover, .advertisement-v1 .tab-button .nav > li > a:focus, .advertisement-v1 .tab-divs .view-as a:hover, .advertisement-v1 .tab-divs .view-as a.active, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v4 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v4 .view-head .tab-button .nav-tabs > li.active > a, .members-v3 .members-text .btn.outline:hover, .members-v4.members-v5 .member-content ul li span, .members-v4.members-v5 .member-content a.btn, .members-v4.members-v5 .member-content a.btn:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:focus, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-heading, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-text, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn:hover, .sidebar .widget-box .user-make-offer-message .nav > li > a, .sidebar .widget-box .user-make-offer-message .nav > li .browse-favourite a, .sidebar .widget-box .user-make-offer-message .nav > li.btnWatch button, .user-pages aside .user-submit-ad .btn-user-submit-ad:hover, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit']:hover, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit']:focus, .submit-post form .form-main-section .active-post-type .post-type-box, .submit-post form .classiera-post-main-cat ul li a:hover, .submit-post form .classiera-post-main-cat ul li a:focus, .submit-post form .classiera-post-main-cat ul li.active a, .classiera-upload-box.classiera_featured_box, .classiera_follow_user > input[type='submit'], .related-blog-post-section .navText a:hover, .pagination > li > a:hover, .pagination > li span:hover, .pagination > li:first-child > a:hover, .pagination > li:first-child span:hover, .pagination > li:last-child > a:hover, .pagination > li:last-child span:hover, .classiera-navbar.classiera-navbar-v1 .betube-search .btn.outline:hover, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type i, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type:hover i, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:last-of-type, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:last-of-type:hover, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu, .offcanvas-light .navmenu-brand .offcanvas-button, .offcanvas-light .log-reg-btn .offcanvas-log-reg-btn:hover, .btn-primary.outline:hover, .btn-primary.outline:focus, .btn-primary.outline:active, .btn-primary.outline.active, .open > .dropdown-toggle.btn-primary, .btn-primary.outline:active, .btn-primary.outline.active, .btn-style-four.active, .btn-style-four.active:hover, .btn-style-four.active:focus, .btn-style-four.active:active, .btn-style-four:hover, .btn-style-four:focus, .btn-style-four:active, #showNum:hover, .user_inbox_content > .tab-content .tab-pane .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{ border-color:";
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
		
		echo ".advertisement-v4 .view-head .tab-button .nav-tabs > li > a span.arrow-down, .advertisement-v4 .view-head .tab-button .nav-tabs > li:hover:after, .advertisement-v4 .view-head .tab-button .nav-tabs > li.active:after, .locations .location-content .location .location-icon .tip, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .dropdown-menu, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > .dropdown-menu, .classiera-navbar.classiera-navbar-v4 .dropdown-menu, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav .dropdown-menu, .woocommerce-error, .woocommerce-info, .woocommerce-message{ border-top-color:";
		echo esc_attr($classieraPrimaryColor);
		echo "; } ";
		
		echo ".locations .location-content-v2 .location:hover, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .dropdown-menu:before, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > a:hover, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > .dropdown-menu:before, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > .active > a{ border-bottom-color:";
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
		
		echo "{ box-shadow:0 3px 0 0 ";
		echo esc_attr($classieraPrimaryColor);
		echo " !important; } ";
	
	}
	
	//Secondary Color Options//
	if(!empty($classieraSecondaryColor)) {
		echo ".pagination > li.active a, .pagination > li.disabled a, .pagination > li.active a:focus, .pagination > li.active a:hover, .pagination > li.disabled a:focus, .pagination > li.disabled a:hover, .pagination > li:first-child > a, .pagination > li:first-child span, .pagination > li:last-child > a, .pagination > li:last-child span, .classiera-navbar.classiera-navbar-v3.affix, .classiera-navbar.classiera-navbar-v3 .navbar-nav > li > .dropdown-menu li a:hover, .classiera-navbar.classiera-navbar-v4 .dropdown-menu > li > a:hover, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu > li > a:hover, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu > li > a:focus, .btn-primary, .btn-primary.btn-style-five:hover, .btn-primary.btn-style-five.active, .btn-primary.btn-style-six:hover, .btn-primary.btn-style-six.active, .input-group-addon, .woocommerce .button, .woocommerce a.button, .woocommerce .button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #ad-address span i, .search-section .search-form .form-group .help-block, .search-section .search-form.search-form-v1 .form-group button, .search-section.search-section-v2 .form-group button, .search-section.search-section-v4 .search-form .btn:hover, .category-slider-small-box ul li a, .category-slider-small-box.outline-box ul li a:hover, .classiera-premium-ads-v3 .premium-carousel-v3 .owl-dots .owl-dot.active span, .classiera-premium-ads-v3 .premium-carousel-v3 .owl-dots .owl-dot:hover span, .classiera-box-div-v7 figure:hover:after, .category-v2 .category-box .category-content ul li a:hover i, .category-v6 .category-box figure .category-box-hover > span, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v3 figure figcaption .price span:last-of-type, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v5 figure .detail .box-icon a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .box-icon a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .box-icon a:hover, .advertisement-v1 .tab-button .nav-tabs > li > a, .advertisement-v5 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v5 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v5 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v5 .view-head .tab-button .nav-tabs > li.active > a, .advertisement-v5 .view-head .view-as a:hover, .advertisement-v5 .view-head .view-as a.active, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:hover, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:active, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a:focus, .advertisement-v6 .view-head .tab-button .nav-tabs > li.active > a, .advertisement-v6 .view-head .view-as a:hover, .advertisement-v6 .view-head .view-as a.active, .locations .location-content .location:hover, .call-to-action .call-to-action-box .action-box-heading .heading-content i, .pricing-plan-v2 .pricing-plan-content .pricing-plan-box .pricing-plan-price, .pricing-plan-v5 .pricing-plan-content .pricing-plan-box .pricing-plan-heading, .pricing-plan-v6, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn:hover, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular, .partners-v3 .partner-carousel-v3 .owl-dots .owl-dot.active span, .partners-v3 .partner-carousel-v3 .owl-dots .owl-dot:hover span, #back-to-top, .custom-wp-search .btn-wp-search, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit'], .single-post-page .single-post #single-post-carousel .single-post-carousel-controls .carousel-control span, .section-bg-black, #ad-address span i, .classiera-navbar.classiera-navbar-v4 ul.nav li.dropdown ul.dropdown-menu > li.active > a, .classiera-navbar.classiera-navbar-v6 ul.nav li.dropdown ul.dropdown-menu > li.active > a, #showNum{ background: ";
		echo esc_attr($classieraSecondaryColor);
		echo "; } ";
	}
	if(!empty($classieraSecondaryColor)){
		echo ".members-v4.members-v5, .classiera-navbar.classiera-navbar-v6{ background-color: ";
		echo esc_attr($classieraSecondaryColor);
		echo " !important; } ";
	}
	if(!empty($classieraSecondaryColor)) {
		echo "h1 > a, h2 > a, h3 > a, h4 > a, h5 > a, h6 > a,.classiera-navbar.classiera-navbar-v1 .navbar-default .navbar-nav > li > a, .classiera-navbar.classiera-navbar-v1 .navbar-default .navbar-nav > .active > a, .classiera-navbar.classiera-navbar-v1 .navbar-default .navbar-nav > .active > a:hover, .classiera-navbar.classiera-navbar-v1 .navbar-default .navbar-nav > .active > a:focus, .classiera-navbar.classiera-navbar-v1 .dropdown-menu > li > a:hover, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .category-menu-btn, .classiera-navbar.classiera-navbar-v2 .category-menu-dropdown .dropdown-menu li a, .classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > .dropdown-menu > li > a, .classiera-navbar.classiera-navbar-v4 .navbar-nav > li > a:hover, .classiera-navbar.classiera-navbar-v4 .navbar-nav > li > a:focus, .classiera-navbar.classiera-navbar-v4 .navbar-nav > li > a:link, .classiera-navbar.classiera-navbar-v4 .navbar-nav > .active > a, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav li > a, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav .dropdown-menu li > a, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .login-reg .lr-with-icon, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type:hover i, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu > li > a, .classiera-navbar.classiera-navbar-v6 .dropdown .dropdown-menu > li > a i, .btn-primary.outline, .radio label a, .checkbox label a, #getLocation, .search-section.search-section-v6 .form-v6-bg .form-group button, .category-slider-small-box ul li a:hover, .category-slider-small-box.outline-box ul li a, .classiera-static-slider-v2 .classiera-static-slider-content h1, .classiera-static-slider-v2 .classiera-static-slider-content h2, .classiera-static-slider-v2 .classiera-static-slider-content h2 span, .section-heading-v5 h1, .section-heading-v6 h3, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption .price, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption .price span:last-of-type, .classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption h5 a, .classiera-premium-ads-v3 .navText a i, .classiera-premium-ads-v3 .navText span, .classiera-box-div-v1 figure figcaption h5 a, .classiera-box-div-v1 figure figcaption p a:hover, .classiera-box-div-v2 figure figcaption h5 a, .classiera-box-div-v3 figure figcaption .price, .classiera-box-div-v3 figure figcaption .price span:last-of-type, .classiera-box-div-v3 figure figcaption h5 a, .classiera-box-div-v4 figure figcaption h5 a, .classiera-box-div-v5 figure figcaption h5 a, .classiera-box-div-v6 figure .premium-img .price.btn-primary.active, .classiera-box-div-v7 figure figcaption .caption-tags .price, .classiera-box-div-v7 figure figcaption .content h5 a, .classiera-box-div-v7 figure figcaption .content > a, .classiera-box-div-v7 figure:hover figcaption .content .category span, .classiera-box-div-v7 figure:hover figcaption .content .category span a, .category-v1 .category-box .category-content ul li a:hover, .category-v2 .category-box .category-content .view-button a, .category-v3 .category-content h4 a, .category-v3 .category-content .view-all, menu-category .navbar-header .navbar-brand, .menu-category .navbar-nav > li > a:hover, .menu-category .navbar-nav > li > a:active, .menu-category .navbar-nav > li > a:focus, .menu-category .dropdown-menu li a:hover, .category-v5 .categories li, .category-v5 .categories li .category-content h4 a, .category-v6 .category-box figure figcaption > span i, .category-v6 .category-box figure .category-box-hover h3 a, .category-v6 .category-box figure .category-box-hover p, .category-v6 .category-box figure .category-box-hover ul li a, .category-v6 .category-box figure .category-box-hover > a, .category-v7 .category-box figure .cat-img .cat-icon i, .category-v7 .category-box figure figcaption h4 a, .category-v7 .category-box figure figcaption > a, .classiera-advertisement .item.item-list .classiera-box-div figure figcaption .post-tags span, .classiera-advertisement .item.item-list .classiera-box-div figure figcaption .post-tags a:hover, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v5 figure .detail .box-icon a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure figcaption .content h5 a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .price.btn-primary.active, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .box-icon a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure figcaption .content h5 a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .price.btn-primary.active, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .box-icon a, .advertisement-v4 .view-head .tab-button .nav-tabs > li > span, .advertisement-v5 .view-head .tab-button .nav-tabs > li > a, .advertisement-v5 .view-head .view-as a, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a, .advertisement-v6 .view-head .view-as a, .members-v2 .members-text h1, .members-v4 .member-content p, .members-v4.members-v5 .member-content a.btn:hover, .locations .location-content .location a .loc-head, .locations .location-content-v2 .location h5 a, .locations .location-content-v3 .location .location-content h5 a, .locations .location-content-v5 ul li .location-content h5 a, .locations .location-content-v6 figure.location figcaption .location-caption span i, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box.popular ul li, .pricing-plan-v5 .pricing-plan-content .pricing-plan-box .pricing-plan-button h3 small, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button h4, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:focus, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn:hover, .partners-v3 .navText a i, .partners-v3 .navText span, footer .widget-box .widget-content .grid-view-pr li span .hover-posts span, .blog-post-section .blog-post .blog-post-content h4 a, .sidebar .widget-box .widget-title h4, .sidebar .widget-box .widget-content .footer-pr-widget-v1 .media-body h4 a, .sidebar .widget-box .widget-content .footer-pr-widget-v2 .media-body h5 a, .sidebar .widget-box .widget-content .grid-view-pr li span .hover-posts span, .sidebar .widget-box .widget-content ul li h5 a, .sidebar .widget-box .contact-info .contact-info-box i, .sidebar .widget-box .contact-info .contact-info-box p, .sidebar .widget-box .author-info a, .sidebar .widget-box .user-make-offer-message .tab-content form label, .sidebar .widget-box .user-make-offer-message .tab-content form .form-control-static, .inner-page-content article.article-content.blog h3 a, .inner-page-content article.article-content.blog .tags > span, .inner-page-content .login-register .social-login.social-login-or:after, .inner-page-content .login-register.login-register-v1 .single-label label, .inner-page-content .login-register.login-register-v1 form .form-group p a, .border-section .user-comments .media .media-body p + h5 a:hover, .author-box .author-desc p strong, .author-info span.offline i, .user-pages aside .user-submit-ad .btn-user-submit-ad, .user-pages .user-detail-section .about-me p strong, .user-pages .user-detail-section .user-ads .media .media-body .media-heading a, form .search-form .search-form-main-heading a, form .search-form #innerSearch .inner-search-box input[type='checkbox']:checked + label::before, form .search-form #innerSearch .inner-search-box p, .submit-post form .form-main-section .classiera-image-upload .classiera-image-box .classiera-upload-box .classiera-image-preview span i, .submit-post form .terms-use a, .submit-post.submit-post-v2 form .form-group label.control-label, .single-post-page .single-post .single-post-title > .post-price > h4, .single-post-page .single-post .single-post-title h4 a, .single-post-page .single-post .details .post-details ul li p, .single-post-page .single-post .description .tags span, .single-post-page .single-post .description .tags a:hover, .single-post-page .single-post > .author-info a, .classieraAjaxInput .classieraAjaxResult ul li a, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box.popular .price-title{ color: ";
		echo esc_attr($classieraSecondaryColor);
		echo "; } ";
	}
	if(!empty($classieraSecondaryColor)){
		echo ".pagination > li.active a, .pagination > li.disabled a, .pagination > li.active a:focus, .pagination > li.active a:hover, .pagination > li.disabled a:focus, .pagination > li.disabled a:hover, .pagination > li:first-child > a, .pagination > li:first-child span, .pagination > li:last-child > a, .pagination > li:last-child span, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .menu-btn, .btn-primary.outline, .btn-primary.btn-style-five:hover, .btn-primary.btn-style-five.active, .btn-primary.btn-style-six:hover, .btn-primary.btn-style-six.active, .input-group-addon, .search-section .search-form.search-form-v1 .form-group button, .category-slider-small-box.outline-box ul li a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v5 figure .detail .box-icon a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v6 figure .detail .box-icon a, .classiera-advertisement .item.item-list .classiera-box-div.classiera-box-div-v7 figure .detail .box-icon a, .advertisement-v5 .view-head .tab-button .nav-tabs > li > a, .advertisement-v5 .view-head .view-as a, .advertisement-v5 .view-head .view-as a:hover, .advertisement-v5 .view-head .view-as a.active, .advertisement-v6 .view-head .tab-button .nav-tabs > li > a, .advertisement-v6 .view-head .view-as a, .advertisement-v6 .view-head .view-as a:hover, .advertisement-v6 .view-head .view-as a.active, .locations .location-content .location:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-heading, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-text, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn:hover, .user-pages .user-detail-section .user-ads.follower .media .media-body > .classiera_follow_user input[type='submit'], #showNum{ border-color: ";
		echo esc_attr($classieraSecondaryColor);
		echo "; } ";
	}
	if(!empty($classieraSecondaryColor)){
		echo ".classiera-navbar.classiera-navbar-v1 .dropdown-menu{ border-top-color: ";
		echo esc_attr($classieraSecondaryColor);
		echo "; } ";
	}
	if(!empty($classieraSecondaryColor)){
		echo ".search-section .search-form .form-group .help-block ul::before{ border-bottom-color: ";
		echo esc_attr($classieraSecondaryColor);
		echo "; } ";
	}
	//Secondary Color Options//
	//Secondary Color Important Options//
	if(!empty($classieraSecondaryColor)){
		
		echo ".classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav .dropdown-menu li > a:hover, .classiera-navbar.classiera-navbar-v5 .custom-menu-v5 .navbar-nav .dropdown-menu li > a:focus, .search-section.search-section-v5 .form-group .input-group-addon i, .classiera-box-div-v6 figure .premium-img .price.btn-primary.active, .classiera-box-div-v7 figure figcaption .caption-tags .price, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn:hover, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular .pricing-plan-button .btn, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type:hover i, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn.round:hover, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-content .pricing-plan-box .pricing-plan-button .btn:hover, .pricing-plan-v4 .pricing-plan-content .pricing-plan-box.popular .price-title, .members-v4.members-v5 .member-content a.btn:hover, .classiera-box-div .btn-primary.btn-style-six.active{color: ";
		echo esc_attr($classieraSecondaryColor);
		echo " !important; } ";
		
		echo ".btn-primary.btn-style-six:hover, .btn-primary.btn-style-six.active, .pricing-plan-v6.pricing-plan-v7 .pricing-plan-box.popular, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn.round:hover, .classiera-navbar.classiera-navbar-v3 ul.navbar-nav li.dropdown ul.dropdown-menu > li.active > a, .search-section.search-section-v2 .form-group button:hover{background: ";
		echo esc_attr($classieraSecondaryColor);
		echo " !important; } ";
		
		echo ".btn-primary.btn-style-six:hover, .pricing-plan-v6 .pricing-plan-content .pricing-plan-box.popular .pricing-plan-button .btn.round:hover{border-color: ";
		echo esc_attr($classieraSecondaryColor);
		echo " !important; } ";
	}	
	//Secondary Color Important Options//
	//stickyNavbar OFF//
	if($classieraStickyNav == false){
		?>
		.home .classiera-navbar.classiera-navbar-v6{position:absolute}
		<?php
	}
	//Topbar background//
	if(!empty($classieraTopbarColor)){
		echo ".topBar, .topBar.topBar-v3{ background: ";
		echo esc_attr($classieraTopbarColor);
		echo "; } ";
	}
	//Navbar color//
	if(!empty($classieraNavbarColor)){
		echo ".classiera-navbar.classiera-navbar-v2, .classiera-navbar.classiera-navbar-v2 .navbar-default, .classiera-navbar.classiera-navbar-v3, .classiera-navbar.classiera-navbar-v3.affix, .home .classiera-navbar.classiera-navbar-v6{ background: ";
		echo esc_attr($classieraNavbarColor);
		echo " !important; } ";
	}
	if(!empty($classieraNavbarTxtColor)){
		echo ".classiera-navbar.classiera-navbar-v2 .navbar-default .navbar-nav > li > a, .classiera-navbar.classiera-navbar-v3 .nav > li > a, .classiera-navbar.classiera-navbar-v6 .navbar-default .navbar-nav > li > a, .classiera-navbar.classiera-navbar-v6 .navbar-default .login-reg a:first-of-type{ color: ";
		echo esc_attr($classieraNavbarTxtColor);
		echo " !important; } ";
	}
	//Footer Tags Options//
	if(!empty($classieraFooterTagsBG)) {
		echo "footer .widget-box .tagcloud a{ background: ";
		echo esc_attr($classieraFooterTagsBG);
		echo " !important; } ";
	}
	if(!empty($classieraFooterTagsTxt)) {
		echo "footer .widget-box .tagcloud a, footer .widget-box ul.menu li a, footer .widget-box ul.menu li{ color: ";
		echo esc_attr($classieraFooterTagsTxt);
		echo " !important; } ";
	}
	if(!empty($classieraFooterTagsHover)) {
		echo "footer .widget-box .tagcloud a:hover, footer .widget-box ul.menu li a:hover, footer .widget-box ul.menu li:hover{ color: ";
		echo esc_attr($classieraFooterTagsHover);
		echo " !important; } ";
	}
	//Footer Tags Options//
	
	//Footer Bottom Options//
	if(!empty($footerbottombg)) {
		echo ".footer-bottom{ background: ";
		echo esc_attr($footerbottombg);
		echo " !important; } ";
		
		echo ".footer-bottom p, .footer-bottom p a, .footer-bottom ul.footer-bottom-social-icon span{ color: ";
		echo esc_attr($footerbottomcolor);
		echo " !important; } ";
	}
	//Footer Bottom Options//
	//Callout color options//
	$classieraTitleColor = $redux_demo['classiera_title_color'];
	$classieraSecondTitleColor = $redux_demo['classiera_second_title_color'];
	$classieraDescColor = $redux_demo['classiera_desc_color'];
	if(!empty($classieraTitleColor)){
		echo ".members-v1 .members-text h2.callout_title, .members-v4 .member-content h3, .members-v4 .member-content ul li{ color: ";
		echo esc_attr($classieraTitleColor);
		echo " !important; } ";
		
		echo ".members-v4 .member-content ul li span{border-color: ";
		echo esc_attr($classieraTitleColor);
		echo "; } ";
	}
	if(!empty($classieraSecondTitleColor)){
		echo ".members-v1 .members-text h2.callout_title_second, .members-v4 .member-content h4{ color: ";
		echo esc_attr($classieraSecondTitleColor);
		echo " !important; } ";
	}
	if(!empty($classieraDescColor)){
		echo ".members-v1 .members-text p, .members-v4 .member-content p{ color: ";
		echo esc_attr($classieraDescColor);
		echo " !important; } ";
	}
	if(!empty($footertxtcolor)){
		echo "footer .widget-box .textwidget, footer .widget-box .contact-info .contact-info-box p{ color: ";
		echo esc_attr($footertxtcolor);
		echo " !important; } ";
	}
	//Callout color options//
	/*Search Settings*/	
	if($classieraLocationSearch != 1){
		?>
		.search-section .search-form.search-form-v1 .form-group:nth-of-type(1){
			width:58%;
		}
		.search-section .search-form.search-form-v1 .form-group:nth-of-type(3){
			width:20%;
		}
		.search-section.search-section-v2 .form-group:nth-of-type(1){
			width:84.282%;
		}
		.search-section.search-section-v3 .form-group:nth-of-type(2){
			width:75% !important;
		}
		.search-section.search-section-v4 .form-group:nth-of-type(1){
			width:42%;
		}
		.search-section.search-section-v5 .form-group:nth-of-type(1){
			width:59%;
		}
		.search-section.search-section-v6 .form-v6-bg .form-group:nth-of-type(2){
			width:60%;
		}
		<?php
	}
	if($classieraLocationSearch != 1 && $classieraPriceRange != 1){
		?>
		.search-section.search-section-v5 .form-group:nth-of-type(1){
			width:74% !important;
		}
		<?php
	}
	
	/*Search Settings*/
	/*Image Banner Settings*/
	?>
	section.classiera-static-slider, section.classiera-static-slider-v2, section.classiera-simple-bg-slider{
		<?php if($redux_demo['classiera_header_bg']){ ?>
		background-color:<?php echo esc_attr($redux_demo['classiera_header_bg']['background-color']); ?> !important;
		background-image:url("<?php echo esc_url($redux_demo['classiera_header_bg']['background-image']); ?>");
		background-repeat:<?php echo esc_attr($redux_demo['classiera_header_bg']['background-repeat']); ?>;
		background-position:<?php echo esc_attr($redux_demo['classiera_header_bg']['background-position']); ?>;
		background-size:<?php echo esc_attr($redux_demo['classiera_header_bg']['background-size']); ?>;
		background-attachment:<?php esc_attr($redux_demo['classiera_header_bg']['background-attachment']); ?>;
		<?php } ?>
	}
	section.classiera-static-slider .classiera-static-slider-content h1, section.classiera-static-slider-v2 .classiera-static-slider-content h1, section.classiera-simple-bg-slider .classiera-simple-bg-slider-content h1{
		color:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['color']); ?>;
		font-size:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['font-size']); ?>;
		font-family:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['font-family']); ?> !important;
		font-weight:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['font-weight']); ?>;
		line-height:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['line-height']); ?>;
		text-align:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['text-align']); ?>;
		letter-spacing:<?php echo esc_attr($redux_demo['classiera_banner_heading_typography']['letter-spacing']); ?>;
	}
	section.classiera-static-slider .classiera-static-slider-content h2, section.classiera-static-slider-v2 .classiera-static-slider-content h2, section.classiera-simple-bg-slider .classiera-simple-bg-slider-content h4{
		color:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['color']); ?>;
		font-size:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['font-size']); ?>;
		font-family:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['font-family']); ?> !important;
		font-weight:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['font-weight']); ?>;
		line-height:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['line-height']); ?>;
		text-align:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['text-align']); ?>;
		letter-spacing:<?php echo esc_attr($redux_demo['classiera_banner_desc_typography']['letter-spacing']); ?>;
	}
	<?php
	/*Image Banner Settings*/
	/*Search MAP Setting*/
	if(is_home() || is_front_page() || is_search()){
		?>
		.ui-autocomplete{
			width:471px !important;	
			border-top:1px solid #e1e1e1;
		}
		<?php
	}
	/*Search MAP Setting*/

	echo "</style>";

}