function add_custom_taxonomies() {
  // Add new "County" taxonomy to Posts
  register_taxonomy('county', 'post', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Counties', 'taxonomy general name' ),
      'singular_name' => _x( 'County', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Counties' ),
      'all_items' => __( 'All Counties' ),
      'parent_item' => __( 'Parent County' ),
      'parent_item_colon' => __( 'Parent County:' ),
      'edit_item' => __( 'Edit County' ),
      'update_item' => __( 'Update County' ),
      'add_new_item' => __( 'Add New County' ),
      'new_item_name' => __( 'New County Name' ),
      'menu_name' => __( 'Counties' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'county',
      'with_front' => false,
      'hierarchical' => true
    ),
  ));
}
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id); //Gets post ID
    $the_excerpt = ($the_post ? $the_post->post_content : null); //Gets post_content to be used as a basis for the excerpt
    $excerpt_length = 25; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    return str_replace('&nbsp;', '', "");
}
add_action( 'init', 'add_custom_taxonomies', 0 );

//make shortcode for showing that post map page
function webcast_map_page_shortcode() {
	$terms = get_terms('county');
	
	if ( !empty( $terms ) && !is_wp_error( $terms ) ){
		?>
<style>
	.et-waypoint:not(.et_pb_counters) {
    opacity: 1 !important;
}
</style>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
	$('.main_title').hide();
</script>

		<h1>In Your Area</h1>

		<p>We want to make sure that no child in any region goes without the vital equipment they need. Here you can tap your map region and see local news and the amount of children who need essential equipment by region, as well as local news and appeals for support.</p>


		<p>We know Equipment & Support has the power to enable disabled children to enjoy and experience life, to provide independence, stop pain, or just do everyday things..</p>


		<p>Together we can and will really change the lives of disabled children. What’s going on in your region?.</p>



		
<br>
		<div id="map_canvas" style="width: auto; height: 900px; margin-bottom: 20px;"></div>
		             <script type="text/javascript">
                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                
                var cid;
                var infowindow;
                
                function initialize() {
                
                    var mapOptions = {
                        zoom: 6,
                        styles: [{"featureType":"water","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"landscape","stylers":[{"color":"#f2f2f2"}]},{"featureType":"road","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]}],
                        overviewMapControl: false,
                        streetViewControl: false,
                        center: new google.maps.LatLng(54.64,-5.32),                      
                        minZoom: 5
                    }
                
                    var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
                
                 var strictBounds = new google.maps.LatLngBounds(
                      new google.maps.LatLng(50, -7.6), 
                      new google.maps.LatLng(60.8, 0.6)
                    );
                    
                    
   google.maps.event.addListener(map, 'dragend', function() {
      if (strictBounds.contains(map.getCenter())) return;
 
 
      var c = map.getCenter(),
          x = c.lng(),
          y = c.lat(),
          maxX = strictBounds.getNorthEast().lng(),
          maxY = strictBounds.getNorthEast().lat(),
          minX = strictBounds.getSouthWest().lng(),
          minY = strictBounds.getSouthWest().lat();
 
      if (x < minX) x = minX;
      if (x > maxX) x = maxX;
      if (y < minY) y = minY;
      if (y > maxY) y = maxY;
 
      map.setCenter(new google.maps.LatLng(y, x));
    });				   
                    
                
                    var infowindow;
                
                    map.data.loadGeoJson('https://newlifecharity.co.uk/regions.geojson');
                    
                    map.data.addListener('addfeature', function(event) {
                         $("#map_loader").hide();
                     });
					
					var html_data = "";
					
							
                   
					

                    function showInContentWindow(position, text) {
						
						var html_data = "";
						var country_text = "";
						var post_count="";
						var amount = "";
						var pop_up_url = "";
						
						if(text == 1){
							html_data = webcast_data_scotland;
							country_text = country_name_scotland;
							post_count = post_count_scotland;
							amount = amount_scotland;
							pop_up_url = url_scotland;
						}else if(text == 2){
							
							html_data = webcast_data_northern_ireland;
							country_text = country_name_northern_ireland;
							post_count = post_count_northern_ireland;
							amount = amount_northern_ireland;
							pop_up_url = url_northern_ireland;
						}else if(text == 3){
							
							html_data = webcast_data_north_east;
							country_text = country_name_north_east;
							post_count = post_count_north_east;
							amount = amount_north_east;
							pop_up_url = url_north_east;
						}else if(text == 4){
							
							html_data = webcast_data_north_west;
							country_text = country_name_north_west;
							post_count = post_count_north_west;
							amount = amount_north_west;
							pop_up_url = url_north_west;
						}else if(text == 5){
							
							html_data = webcast_data_yorkshire_and_the_humber;
							country_text = country_name_yorkshire_and_the_humber;
							post_count = post_count_yorkshire_and_the_humber;
							amount = amount_yorkshire_and_the_humber;
							pop_up_url = url_yorkshire_and_the_humber;
						}else if(text == 6){
							
							html_data = webcast_data_east_midlands;
							country_text = country_name_east_midlands;
							post_count = post_count_east_midlands;
							amount = amount_east_midlands;
							pop_up_url = url_east_midlands;
						}else if(text == 7){
							
							html_data = webcast_data_west_midlands;
							country_text = country_name_west_midlands;
							post_count = post_count_west_midlands;
							amount = amount_west_midlands;
							pop_up_url = url_west_midlands;
						}else if(text == 8){
							
							html_data = webcast_data_wales;
							country_text = country_name_wales;
							post_count = post_count_wales;
							amount = amount_wales;
							pop_up_url = url_wales;
						}else if(text == 9){
							
							html_data = webcast_data_east_of_england;
							country_text = country_name_east_of_england;
							post_count = post_count_east_of_england;
							amount = amount_east_of_england;
							pop_up_url = url_east_of_england;
						}else if(text == 10){
							
							html_data = webcast_data_london;
							country_text = country_name_london;
							post_count = post_count_london;
							amount = amount_london;
							pop_up_url = url_london;
						}else if(text == 11){
							
							html_data = webcast_data_south_east;
							country_text = country_name_south_east;
							post_count = post_count_south_east;
							amount = amount_south_east;
							pop_up_url = url_south_east;
						}else if(text == 12){
							
							html_data = webcast_data_south_west;
							country_text = country_name_south_west;
							post_count = post_count_south_west;
							amount = amount_south_west;
							pop_up_url = url_south_west;
						}
					const contentString = html_data +"<div style='padding: 10px;text-align: center;'><a class='et_pb_contact_submit et_pb_button' href='https://newlifecharity.co.uk/news/'>View All</a></div>";
											document.getElementById('webcast-postmap-sidebar').innerHTML = contentString;


                        var content = "<div style='width: 300px;'><h3 style='color:#1d7ac7;'>" + country_text +  "</h3>";
                                    content += "<h4 class='currentneed_pop'>Cost of equipment needed: " + numberWithCommas("<span style='color:#e22f87;'>£" + amount) + "</span></h4>";
                                    content += "<h4 class='children_pop'>Number of children in urgent need: <span style='color:#e22f87;'>" + numberWithCommas(post_count) + "</span></h4>";
                                  content += "<div style='padding: 10px;text-align: center;'><a class='et_pb_contact_submit et_pb_button' href='"+pop_up_url+"'>Donate</a></div>";
                                    content += '</div>';
                
                                    if(infowindow){
                                        infowindow.close();
                                    }
                
                                    infowindow = new google.maps.InfoWindow({
                                        content: content,
                                        position: position,
                                        pixelOffset: new google.maps.Size(0, 0),
                                    })
                
                                    infowindow.open(map);
								
						

                

                    }
                
                    map.data.setStyle(function(feature) {
                        var color = 'gray';
                        if (cid == feature.getProperty('Name')) {
                            map.data.overrideStyle(feature, {fillColor: 'red'});
                        }
                
                        return /** @type {google.maps.Data.StyleOptions} */({
                            fillColor: color,
                            strokeColor: color,
                            strokeWeight: 1
                        });
                    });
                
                    map.data.addListener('click', function(event) {
                        map.data.revertStyle();
                        map.data.overrideStyle(event.feature, {fillColor: 'red'});
                        event.feature.setProperty('isColorful', true);
                        cid = event.feature.getProperty('Name');
                        showInContentWindow(event.latLng, event.feature.getProperty('Name'));
                
                    });
                
                    map.data.addListener('mouseover', function(event) {
                        if(event.feature.getProperty('color') != 'red'){
                            map.data.overrideStyle(event.feature, {fillColor: 'black'});
                        }
                    });
                
                    map.data.addListener('mouseout', function(event) {
                
                        if(event.feature.getProperty('color') != 'red'){
                            map.data.overrideStyle(event.feature, {fillColor: 'grey'});
                        }
                
                    });
                
                }
						 
				<?php
		foreach ( $terms as $term ) {
			$posts = get_posts(
				array(
					'numberposts' => 8,
					'post_type' => 'post',
					'tax_query' => array(
						array(
							'taxonomy' => 'county',
							'field' => 'term_id',
							'terms' => $term->term_id,
						)
					)
				)
			);
			
			$htmldata = '<div class="et_pb_row et_pb_row_1 et_pb_gutters2 w-83 category-row webcast-col" style="width: 100% !important;"><h3>In this area: </h3>';
			foreach ( $posts as $post ) {
			if (has_post_thumbnail( $post->ID ) ) {	
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			}
			$htmldata .= '<div style="width:100%;margin-bottom:10px"><a href="'.get_permalink( $post->ID ).'" target="_blank"><div style="width: 30%;float:left;"><img src="'.$image[0].'" width="100%" height="100px" style="object-fit: cover;" class="et-waypoint et_pb_animation_top et_pb_animation_top_tablet et_pb_animation_top_phone wp-image-2050 et-animated" /></div><div style="width: 70%;float:left;padding-left:10px;"><p style="font-size:12px;line-height:1.5em">'.htmlspecialchars($post->post_title,ENT_QUOTES).'</p></div></a></div>';
			}
			$htmldata .= '</div>';
			//var_dump($term);
			
			?>
			//<![CDATA[
				var webcast_data_<?php echo $term->slug; ?> = <?php echo "'".$htmldata."'"; ?>;
			//	var post_count_<?php echo $term->slug; ?> = <?php echo "'".$term->count."'"; ?>;
				var country_name_<?php echo $term->slug; ?> = <?php echo "'".$term->name."'"; ?>;
				
			//]]>
			<?php
			$term = sanitize_term( $term, 'county' );
			$term_link = get_term_link( $term, 'county' );
		}
		
	$file_data =  file_get_contents("https://newlifecharity.co.uk/_system/bignumbersystemdata/counties.csv");
	$rows = explode("\n",$file_data);
		
		for($i=1;$i<count($rows)-1;$i++){
			
			$data = explode(",",$rows[$i]);
			
			if(trim($data[1]," ") == "\"Scotland\""){
				?>
				var post_count_scotland = <?php echo "'".$data[2]."'"; ?>;
				var amount_scotland = <?php echo "'".$data[3]."'"; ?>;
				var  url_scotland = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=Scotland";
				<?php
			} else if(trim($data[1]," ") == "\"Northern Ireland\""){
				?>
				var post_count_northern_ireland = <?php echo "'".$data[2]."'"; ?>;
					var amount_northern_ireland = <?php echo "'".$data[3]."'"; ?>;
					var  url_northern_ireland = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=NorthernIreland";

				<?php
				
			}else if(trim($data[1]," ") == "\"North East\""){
				?>
				var post_count_north_east = <?php echo "'".$data[2]."'"; ?>;
					var amount_north_east = <?php echo "'".$data[3]."'"; ?>;
					var  url_north_east = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=NorthEast";
				<?php
				
			}else if(trim($data[1]," ") == "\"North West\""){
				?>
				var post_count_north_west = <?php echo "'".$data[2]."'"; ?>;
					var amount_north_west = <?php echo "'".$data[3]."'"; ?>;
					var  url_north_west = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=NorthWest";
				<?php
				
			}else if(trim($data[1]," ") == "\"Yorkshire and the Humber\""){
				?>
				var post_count_yorkshire_and_the_humber = <?php echo "'".$data[2]."'"; ?>;
					var amount_yorkshire_and_the_humber = <?php echo "'".$data[3]."'"; ?>;
					var  url_yorkshire_and_the_humber = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=YorkshireHumber";
				<?php
				
			}else if(trim($data[1]," ") == "\"East Midlands\""){
				?>
				var post_count_east_midlands = <?php echo "'".$data[2]."'"; ?>;
					var amount_east_midlands = <?php echo "'".$data[3]."'"; ?>;
					var  url_east_midland = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=EastMidlands";
				<?php
				
			}else if(trim($data[1]," ") == "\"West Midlands\""){
				
				?>
				var post_count_west_midlands = <?php echo "'".$data[2]."'"; ?>;
					var amount_west_midlands = <?php echo "'".$data[3]."'"; ?>;
					var  url_west_midlands = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=WestMidlands";
				<?php
			}else if(trim($data[1]," ") == "\"Wales\""){
				?>
				var post_count_wales = <?php echo "'".$data[2]."'"; ?>;
					var amount_wales = <?php echo "'".$data[3]."'"; ?>;
					var  url_wales = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=Wales";
				<?php
				
			}else if(trim($data[1]," ") == "\"East of England\""){
				?>
				var post_count_east_of_england = <?php echo "'".$data[2]."'"; ?>;
					var amount_east_of_england = <?php echo "'".$data[3]."'"; ?>;
					var  url_east_of_england = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=East";
				<?php
				
			}else if(trim($data[1]," ") == "\"London\""){
				?>
				var post_count_london = <?php echo "'".$data[2]."'"; ?>;
					var amount_london = <?php echo "'".$data[3]."'"; ?>;
					var  url_london = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=London";
				<?php
				
			}else if(trim($data[1]," ") == "\"South East\""){
				?>
				var post_count_south_east = <?php echo "'".$data[2]."'"; ?>;
					var amount_south_east = <?php echo "'".$data[3]."'"; ?>;
					var  url_south_east = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=SouthEast";
				<?php
				
			}else if(trim($data[1]," ") == "\"South West\""){
				?>
				var post_count_south_west = <?php echo "'".$data[2]."'"; ?>;
					var amount_south_west = <?php echo "'".$data[3]."'"; ?>;
					var  url_south_west = "https://www.committedgiving.uk.net/newlife/Regions/index.aspx?Region=SouthWest";
				<?php
				
			}
			
			
			
			
		}
		
		?>
                
                google.maps.event.addDomListener(window, 'load', initialize);
                
  
                
             </script>
<?php
	}
	else {
		echo 'No posts';
	}
	//return $html;
} 
add_shortcode('post_map', 'webcast_map_page_shortcode'); 