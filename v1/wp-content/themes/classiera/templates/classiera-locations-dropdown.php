<?php 
global $redux_demo;
$locShownBy = $redux_demo['location-shown-by'];
$classieraLocationName = 'post_location';
if($locShownBy == 'post_location'){
	$classieraLocationName = 'post_location';
}elseif($locShownBy == 'post_state'){
	$classieraLocationName = 'post_state';
}elseif($locShownBy == 'post_city'){
	$classieraLocationName = 'post_city';
}
if($locShownBy == 'post_location'){
	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'countries',
		'orderby'        => 'title',
		'order'        => 'ASC',
		'suppress_filters' => false,
		'post_status'      => 'publish',
	);
	$classieraAllCountries =  get_posts( $args );
	if(!empty($classieraAllCountries)){
		?>
		<select id="classiera__loc" class="form-control form-control-sm sharp-edge" name="post_location">
			<option value="All" selected disabled><?php esc_html_e('Select Location..', 'classiera'); ?></option>
			<?php foreach ( $classieraAllCountries as $country ):?>
				<option value="<?php echo esc_attr($country->ID); ?>"><?php echo esc_html($country->post_title); ?></option>
			<?php
			endforeach;
			wp_reset_postdata();
			?>
		</select>
		<?php
	}
}else{	
	$args = array( 
		'posts_per_page' => 200, 
		'order' =>'ASC', 
		'orderby' =>'title',
	);
	$allposts = get_posts($args);
	$alllocationsinposts = array();
	foreach($allposts as $post){								
		$alllocationsinposts[] = get_post_meta( $post->ID, $locShownBy, true );
	}	
	$directors = array_unique($alllocationsinposts);
	asort($directors);
?>
	<select id="classiera__loc" class="form-control form-control-sm sharp-edge" name="<?php echo esc_attr($classieraLocationName); ?>">
		<option value="All" selected disabled><?php esc_html_e('Select Location..', 'classiera'); ?></option>
		<?php foreach ($directors as $director):?>
			<option value="<?php echo esc_attr($director); ?>"><?php echo esc_attr($director); ?></option>
		<?php endforeach;?>
		<?php wp_reset_query(); ?>
	</select>
<?php }?>	