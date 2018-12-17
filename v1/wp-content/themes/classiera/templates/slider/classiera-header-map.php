<?php 
	global $redux_demo;
	$classieraMAPStyle = $redux_demo['map-style'];	
	$classieraMAPPostType = $redux_demo['classiera_map_post_type'];	
	$classieraMAPPostCount = $redux_demo['classiera_map_post_count'];	
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$$iconPath = "";
?>
<section id="classiera_map">
	<div id="log" style="display:none;"></div>
	<input id="latitude" type="hidden" value="">
	<input id="longitude" type="hidden" value="">
	<!--Search on MAP-->
	<div class="classiera_map_search">
        <div class="classiera_map_search_btn"><i class="fa fa-caret-right"></i></div>
        <form method="get">
            <div class="classiera_map_input-group">
                <input id="classiera_map_address" type="text" placeholder="<?php esc_html_e('Search ads by your Location', 'classiera'); ?>">
            </div>    
        </form>
    </div>	
	<!--Search on MAP-->
	<div id="classiera_main_map" style="width:100%; height:600px;">
		<script type="text/javascript">			
			jQuery(document).ready(function(){
				var addressPoints = [
					<?php 
					$wp_query= null;
					if($classieraMAPPostType == 'featured'){
						$arags = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => $classieraMAPPostCount,
							'meta_query' => array(
							array(
								'key' => 'featured_post',
								'value' => '1',
								'compare' => '=='
								)
							),
						);
					}else{
						$arags = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => $classieraMAPPostCount,
						);
					}
					$wp_query = new WP_Query($arags);
					while ($wp_query->have_posts()) : $wp_query->the_post();
						$category = get_the_category();
						$catID = $category[0]->cat_ID;
						if ($category[0]->category_parent == 0){
							$tag = $category[0]->cat_ID;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
							$tag = $category[0]->category_parent;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}else{
							$tag = $category[0]->category_parent;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}
						if(!empty($category_icon_code)){
							$category_icon = stripslashes($category_icon_code);
						}						
						$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
						$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
						$post_price = get_post_meta($post->ID, 'post_price', true);
						$post_phone = get_post_meta($post->ID, 'post_phone', true);
						$theTitle = get_the_title();
						$postCatgory = get_the_category( $post->ID );
						$postCurCat = $postCatgory[0]->name;
						$categoryLink = get_category_link($catID);
						$classieraPostAuthor = $post->post_author;
						$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
						$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
						$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
						if(is_numeric($post_price)){
							$classieraPostPrice =  classiera_post_price_display($post_currency_tag, $post_price);
						}else{ 
							$classieraPostPrice =  $post_price; 
						}
						if( has_post_thumbnail()){
							$classieraIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
							$classieraIMGURL = $classieraIMG[0];
						}else{
							$classieraIMGURL = get_template_directory_uri() . '/images/nothumb.png';
						}
						if(empty($classieraCatIcoIMG)){
							$iconPath = get_template_directory_uri() .'/images/icon-services.png';
						}else{
							$iconPath = $classieraCatIcoIMG;
						}						
						
					if(!empty($post_latitude)){	
					$content = '<a class="classiera_map_div" href="'.get_the_permalink().'"><img class="classiera_map_div__img" src="'.$classieraIMGURL.'" alt="images"><div class="classiera_map_div__body"><p class="classiera_map_div__price">'.__( "Price", 'classiera').' : <span>'.$classieraPostPrice.'</span></p><h5 class="classiera_map_div__heading">'.get_the_title().'</h5><p class="classiera_map_div__cat">'.__( "Category", 'classiera').' : '.$postCurCat.'</p></div></a>';
					?>
					
					[<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>, '<?php echo sprintf($content); ?>', "<?php echo esc_url($iconPath); ?>"],
					
					<?php 
					}
					endwhile;
					wp_reset_query();
					?>
				];
				var mapopts;
				if(window.matchMedia("(max-width: 1024px)").matches){
					var mapopts =  {
						dragging:false,
						tap:false,
					};					
				};
				var map = L.map('classiera_main_map', mapopts).setView([0,0],1);
				map.dragging.disable;
				map.scrollWheelZoom.disable();
				var roadMutant = L.gridLayer.googleMutant({
				<?php if($classieraMAPStyle){?>styles: <?php echo wp_kses_post($classieraMAPStyle); ?>,<?php }?>
					maxZoom: 13,
					type:'roadmap'
				}).addTo(map);
				var markers = L.markerClusterGroup({
					spiderfyOnMaxZoom: true,
					showCoverageOnHover: true,
					zoomToBoundsOnClick: true,
					maxClusterRadius: 10
				});
				markers.on('clusterclick', function(e) {
					map.setView(e.latlng, 13);				
				});			
				var markerArray = [];
				for (var i = 0; i < addressPoints.length; i++){
					var a = addressPoints[i];
					var newicon = new L.Icon({iconUrl: a[3],
						iconSize: [36, 51], // size of the icon
						iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
						popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
					});
					var title = a[2];
					var marker = L.marker(new L.LatLng(a[0], a[1]));
					marker.setIcon(newicon);
					marker.bindPopup(title, {minWidth:"400"});
					marker.title = title;
					//marker.on('click', function(e) {
						//map.setView(e.latlng, 13);
						
					//});				
					markers.addLayer(marker);
					markerArray.push(marker);
					if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
						var group = L.featureGroup(markerArray); //add markers array to featureGroup
						map.fitBounds(group.getBounds());   
					}
				}
				var circle;
				map.addLayer(markers);
				function getLocation(){
					if(navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPosition);
					}else{
						x.innerHTML = "Geolocation is not supported by this browser.";
					}
				}
				function showPosition(position){					
					jQuery('#latitude').val(position.coords.latitude);
					jQuery('#longitude').val(position.coords.longitude);
					var latitude = jQuery('#latitude').val();
					var longitude = jQuery('#longitude').val();
					map.setView([latitude,longitude],13);
					circle = new L.circle([latitude, longitude], {radius: 2500}).addTo(map);
				}
				jQuery('#getLocation').on('click', function(e){
					e.preventDefault();
					getLocation();
				});
				//Search on MAP//
				var geocoder;
				function initialize(){
					geocoder = new google.maps.Geocoder();     
				}				
				jQuery("#classiera_map_address").autocomplete({
					  //This bit uses the geocoder to fetch address values					  
					source: function(request, response){
						geocoder = new google.maps.Geocoder();
						geocoder.geocode( {'address': request.term }, function(results, status) {
							response(jQuery.map(results, function(item) {
								return {
								  label:  item.formatted_address,
								  value: item.formatted_address,
								  latitude: item.geometry.location.lat(),
								  longitude: item.geometry.location.lng()
								}
							}));
						})
					},
					  //This bit is executed upon selection of an address
					select: function(event, ui) {
						jQuery("#latitude").val(ui.item.latitude);
						jQuery("#longitude").val(ui.item.longitude);
						var latitude = jQuery('#latitude').val();
						var longitude = jQuery('#longitude').val();
						map.setView([latitude,longitude],10);						
					}
				});
				//Search on MAP//		
				
			});
		</script>
	</div>
</section>