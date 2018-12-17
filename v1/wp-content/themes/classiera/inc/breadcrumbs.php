<?php 
/**
 * Dimox Breadcrumbs
 * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 * Since ver 1.0
 * Add this to any template file by calling classiera_breadcrumbs()
 * Changes: MC added taxonomy support
 */
function classiera_breadcrumbs(){
  /* === OPTIONS === */	
	$text['home']     = ''; // text for the 'Home' link	
	$text['category'] = '%s'; // text for a category page	
	$text['tax'] 	  = esc_html__('Archive for','classiera').' "%s"'; // text for a taxonomy page	
	$text['search']   = esc_html__('Search Results for','classiera').' "%s"'; // text for a search results page	
	$text['tag']      = esc_html__('Posts Tagged','classiera').' "%s"'; // text for a tag page
	$text['author']   = esc_html__('Posted By','classiera').' "%s"'; // text for an author page	
	$text['404']      = esc_html__('Page Not Found','classiera');// text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = '&nbsp;'; // delimiter between crumbs
	$before      = '<li class="active">'; // tag before the current crumb
	$after       = '</li>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$homeLink = home_url() . '/';
	$linkBefore = '<li>';
	$linkAfter = '</li>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s<i class="fa fa-home"></i></a>' . $linkAfter;

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="row"><div class="col-lg-12"><ul class="breadcrumb">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		
		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo wp_kses($cats, $allowed_html);
			}
			echo wp_kses_post($before) . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if(!empty($thisCat)){
				if(isset($thisCat->parent)){
					if ($thisCat->parent != 0) {
						$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
						$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
						$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
						echo wp_kses_post($cats);
					}
				}				
			}			
			echo wp_kses_post($before) . sprintf($text['tax'], single_cat_title('', false)) . $after;
		
		}elseif ( is_search() ) {
			echo wp_kses_post($before) . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {			
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo wp_kses_post($before) . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			//echo "Ye Wala";
			$linkPage = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
			echo sprintf($linkPage, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo wp_kses_post($before) . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo wp_kses_post($before) . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {			
			$catLink = '<li class="cAt">';				
			if ( get_post_type() == 'blog' ) {
				global $wpdb;
				$blog = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-blog.php' ", ARRAY_A);
				$bloglink ="";
				if(!empty($blog)){
					$bloglink = get_permalink($blog[0]['post_id']);
				}
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$linkPage = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
				printf($linkPage, $bloglink, $post_type->labels->singular_name);
				if ($showCurrent == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;
				
			}elseif ( get_post_type() != 'post' ) {				
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$linkPage = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
				printf($linkPage, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;
			} else {				
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $catLink . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo wp_kses_post($cats);
				if ($showCurrent == 1) echo wp_kses_post($before) . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo wp_kses_post($before) . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo wp_kses_post($cats);
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			
			if ($showCurrent == 1) echo wp_kses_post($before) . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {			
			$linkPage = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($linkPage, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo wp_kses_post($breadcrumbs[$i]);
				if ($i != count($breadcrumbs)-1) echo wp_kses_post($delimiter);
			}
			if ($showCurrent == 1) echo wp_kses_post($delimiter) . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {			
			echo the_archive_title();

		} elseif ( is_author() ) {
	 		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$author_ID = $author->ID;			
			$userdata = get_userdata($author_ID);			
			echo wp_kses_post($before) . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo wp_kses_post($before) . $text['404'] . $after;
		}		

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo the_archive_title();
			echo wp_kses_post($before).esc_html__('Page', 'classiera') . ' ' . get_query_var('paged').$after;
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
				echo wp_kses_post($before).the_archive_title().$after;
		}

		echo '</ul></div></div>';

	}
}