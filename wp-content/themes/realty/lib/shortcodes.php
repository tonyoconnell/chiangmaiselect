<?php
/*-----------------------------------------------------------------------------------*/
/* Section Title
/*-----------------------------------------------------------------------------------*/

function tt_section_title( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'heading'			=> 'h2',
		'style'				=> '1',
		'text_align'	=> ''
	), $atts ) );
	
	if ( $text_align == 'center' ) {
		$text_align = ' text-center';
	} else if ( $text_align == 'right' ) {
		$text_align = ' text-right';		
	} else {
		$text_align = null;
	}
	
	if ( $heading ) {
		return '<' . $heading . ' class="section-title style' . $style . $text_align . '"><span>' . do_shortcode($content) . '</span></' . $heading . '>';
	}
	else {
		return '<h2 class="section-title"><span>' . do_shortcode($content) . '</span></h2>';
	}
		
}
add_shortcode('section_title', 'tt_section_title');


/*-----------------------------------------------------------------------------------*/
/* Testimonials
/*-----------------------------------------------------------------------------------*/

function tt_testimonials( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-carousel-' . $columns . ' testimonial">';
	}
	else {
		echo '<div class="owl-carousel-2 testimonial">';
	}

	get_template_part( 'lib/inc/template/testimonials' );
	return ob_get_clean();
	
}
add_shortcode('testimonials', 'tt_testimonials');


/*-----------------------------------------------------------------------------------*/
/* Agents
/*-----------------------------------------------------------------------------------*/

function tt_agents( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'columns'		=> '2',
		'order'			=> 'DESC'
	), $atts ) );
	global $realty_theme_option;
	ob_start();
	if ( $order ) {
		$all_agents = get_users(array( 'role' => 'agent', 'fields' => 'ID', 'orderby'=> 'registered', 'order' => $order));
	} else {
		$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
	}
	if ( $columns ) {
		echo '<div class="tt-agent-shortcode owl-carousel-' . $columns . '">';
	}
	else {
		echo '<div class="owl-carousel-2">';
	}

	foreach( $all_agents as $agent ) {
		
		$company_name = get_user_meta( $agent, 'company_name', true );
		$first_name = get_user_meta( $agent, 'first_name', true );
		$last_name = get_user_meta( $agent, 'last_name', true );
		$email = get_userdata( $agent );
		$email = $email->user_email;
		$office = get_user_meta( $agent, 'office_phone_number', true );
		$mobile = get_user_meta( $agent, 'mobile_phone_number', true );
		$fax = get_user_meta( $agent, 'fax_number', true );
		$website = get_userdata( $agent );
		$website = $website->user_url;
		$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
		$bio = get_user_meta( $agent, 'description', true );
		$profile_image = get_user_meta( $agent, 'user_image', true );
		$author_profile_url = get_author_posts_url( $agent );
		$facebook = get_user_meta( $agent, 'custom_facebook', true );
		$twitter = get_user_meta( $agent, 'custom_twitter', true );
		$google = get_user_meta( $agent, 'custom_google', true );
		$linkedin = get_user_meta( $agent, 'custom_linkedin', true );
		if ( $facebook || $twitter || $google || $linkedin ) {
			$no_socials = false;
		}
		else {
			$no_socials = true;
		}
		?>
		<div>
			<div class="owl-thumbnail">
				<a href="<?php echo $author_profile_url; ?>">
					<?php 
					if ( $profile_image ) {
						$profile_image_id = tt_get_image_id( $profile_image );
						$profile_image_array = wp_get_attachment_image_src( $profile_image_id, 'square-400' );
						echo '<img src="' . $profile_image_array[0] . '" alt="" />';
					}
					else {
						echo '<img src="//placehold.it/400x400/eee/ccc/&text=.." alt="" />';
					} 
					?>
				</a>
			</div>
			<div class="widget-text">
				<div class="agent-details<?php if ( $no_socials ) { echo " no-details"; } ?>">
					<?php 
					if ( $first_name && $last_name ) {
						echo '<h4 class="title">' . $first_name . ' ' . $last_name . '</h4>';	
					}
					?>
					<?php if ( $email && $realty_theme_option['show-agent-email']  ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo antispambot( $email ); ?>"><?php echo antispambot( $email ); ?></a></div><?php } ?>
					<?php if ( $office && $realty_theme_option['show-agent-office'] ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
					<?php if ( $mobile && $realty_theme_option['show-agent-mobile'] ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>			
					<?php 
					/*
					if ( $realty_theme_option['show-agent-social-networks'] && ! $no_socials ) { ?>
					<div class="social-transparent">
						<?php
						if ( $facebook ) { ?>
						<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
						<?php }
						if ( $twitter ) { ?>
						<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
						<?php }
						if ( $google ) { ?>
						<a href="<?php echo $google; ?>"><i class="fa fa-google-plus"></i></a>
						<?php }
						if ( $linkedin ) { ?>
						<a href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin"></i></a>
						<?php }	?>
					</div>
				<?php }	
				*/
				?>
				</div>
			</div>
		</div>
		<?php } ?>
		</div><!-- .owl-carousel -->
	<?php
	return ob_get_clean();
	
}
add_shortcode('agents', 'tt_agents');


/*-----------------------------------------------------------------------------------*/
/* Featured Properties
/*-----------------------------------------------------------------------------------*/

function tt_featured_properties( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-fearured-properties owl-carousel-' . $columns . '">';
	}
	else {
		echo '<div class="owl-fearured-properties owl-carousel-2">';
	}
	get_template_part( 'lib/inc/template/property-featured' );
	return ob_get_clean();
	
}
add_shortcode('featured_properties', 'tt_featured_properties');


/*-----------------------------------------------------------------------------------*/
/*  Single Property
/*-----------------------------------------------------------------------------------*/

function tt_single_property( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'id'		=> '1'
	), $atts ) );

	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> 1,
		//'orderby'					=> 'rand',
		'page_id' 				=> $id
	);
	
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) : while ( $query_properties->have_posts() ) : $query_properties->the_post();
		ob_start();
		get_template_part( 'lib/inc/template/property-item' );
		return ob_get_clean();
	endwhile;
	wp_reset_query();
	endif;
	
}
add_shortcode('single_property', 'tt_single_property');


/*-----------------------------------------------------------------------------------*/
/*  Property Search Form
/*-----------------------------------------------------------------------------------*/

function tt_property_search_form( $atts, $content = null ) {

	ob_start();
	get_template_part( 'lib/inc/template/search-form' );
	return ob_get_clean();
	
}
add_shortcode('property_search_form', 'tt_property_search_form');


/*-----------------------------------------------------------------------------------*/
/*  Property Listing
/*-----------------------------------------------------------------------------------*/

function tt_property_listing( $atts, $content = null ) {
	global $realty_theme_option;
  $listing_view = $realty_theme_option['property-listing-default-view'];
	extract( shortcode_atts( array(
		'per_page'									=> '10',
		'columns'										=> '',
		'location'									=> '',
		'status'										=> '',
		'type'											=> '',
		'features'									=> '',
		'max_price'									=> '',
		'min_rooms'									=> '',
		'available_from'						=> '',
		'view'											=> '',
		'show_sorting_toggle_view' 	=> 'hide',
		'sort_by'         					=> 'date-new',
	), $atts ) );
	
	ob_start();
  
  // Property Sorting & View
	if ( $show_sorting_toggle_view == 'show' ) {
		echo tt_property_listing_sorting_and_view();
	}
	
  ?>
  
  <div id="property-items" class="show-compare<?php echo ' ' . $view; ?>"  data-view="<?php if ( isset( $listing_view ) && $view=='' ) { echo $listing_view; }?>">
	
	<?php
	get_template_part( 'lib/inc/template/property', 'comparison' );
	
	if ( ! $per_page ) {
		$per_page = 10;
	}
	
	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	}
	else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}
	
	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> $per_page,
		'paged' 					=> $paged
	);
	
	
	/* TAX QUERIES: 
	============================== */
	$tax_query = array();
	
	if ( $location ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-location',
			'field' 		=> 'slug',
			'terms'			=> $location
		);
	}
	
	if ( $status ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-status',
			'field' 		=> 'slug',
			'terms'			=> $status
		);
	}
	
	if ( $type ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-type',
			'field' 		=> 'slug',
			'terms'			=> $type
		);
	}
	
	if ( $features ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-features',
			'field' 		=> 'slug',
			'terms'			=> $features
		);
	}
	
	// Count Taxonomy Queries + set their relation for search query
	$tax_count = count( $tax_query );
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	
	$query_properties_args['tax_query'] = $tax_query;
	
	/* META QUERIES: 
	============================== */
	$meta_query = array();
	
	if( $max_price ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_price',
			'value' 		=> $max_price,
			'compare'		=> '<=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	if( $min_rooms ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_rooms',
			'value' 		=> $min_rooms,
			'compare'		=> '>=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	if( $available_from ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_available_from',
			'value' 		=> $available_from,
			'compare'		=> '<=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	// Count Meta Queries + set their relation for search query
	$meta_count = count( $meta_query );
	if ( $meta_count > 1 ) {
	  $meta_query['relation'] = 'AND';
	}
	
	if ( $meta_count > 0 ) {
		$query_properties_args['meta_query'] = $meta_query;
	}
	
	if ( ! empty( $_GET[ 'order-by' ] ) ) {
		$orderby = $_GET[ 'order-by' ];
	}
	else {
		$orderby = $sort_by;
	}

	// By Date (Newest First)
	if ( $orderby == 'date-new' ) {
		$query_properties_args['orderby'] = 'date';
		$query_properties_args['order'] = 'DESC';
	}
	
	// By Date (Oldest First)
	if ( $orderby == 'date-old' ) {
		$query_properties_args['orderby'] = 'date';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Price (Highest First)
	if ( $orderby == 'price-high' ) {
		$query_properties_args['meta_key'] = 'estate_property_price';
		$query_properties_args['orderby'] = 'meta_value_num';
		$query_properties_args['order'] = 'DESC';
	}
	
	// By Price (Lowest First)
	if ( $orderby == 'price-low' ) {
		$query_properties_args['meta_key'] = 'estate_property_price';
		$query_properties_args['orderby'] = 'meta_value_num';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Name (Ascending)
	if ( $orderby == 'name-asc' ) {
		$query_properties_args['orderby'] = 'title';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Name (Ascending)
	if ( $orderby == 'name-desc' ) {
		$query_properties_args['orderby'] = 'title';
		$query_properties_args['order'] = 'DESC';
	}
	
	if ( $orderby == 'random' ) {
		$query_properties_args['orderby'] = 'rand';
		$query_properties_args['order'] = '';
	}

	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) :
	?> 
	<ul class="row list-unstyled">
		<?php 
		while ( $query_properties->have_posts() ) : $query_properties->the_post();
		
		// Shortcode Columns Setting
		if ( isset($columns) && $columns == "2" ) {
			echo '<li class="col-md-6">';
		}
		else if ( isset($columns) && $columns == "3" ) {
			echo '<li class="col-lg-4 col-md-6">';
		}
		else if ( isset($columns) && $columns == "4" ) {
			echo '<li class="col-lg-3 col-md-6">';
		}
		// Theme Options Columns Settings
		else {
			global $realty_theme_option;
			$columns_theme_option = $realty_theme_option['property-listing-columns'];
			if ( empty($columns_theme_option) ) {
				echo '<li class="col-md-6">';
			}
			else {
				echo '<li class="' . $columns_theme_option . '">';
			}
		}
		
		get_template_part( 'lib/inc/template/property', 'item' );
		
		echo '</li>';
		
		endwhile; 
		?>
	</ul>
	<?php wp_reset_query(); ?>
	
	<div id="pagination">
	<?php
	// Built Property Pagination
	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
		'format' 			=> '?page=%#%',
		'total' 			=> $query_properties->max_num_pages,
		//'show_all'		=> true,
		'end_size'           => 4,
		'mid_size'           => 2,
		'type'				=> 'list',
		'current'     => $paged,
		'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
		'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
	) );
	?>
	</div>
	
	<?php
	else:
	?>
	<div>
		<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
	</div>
	<?php
	endif;
	?>
	
	</div><!-- #property-items -->
	<?php
	return ob_get_clean();	
}
add_shortcode('property_listing', 'tt_property_listing');


/*-----------------------------------------------------------------------------------*/
/*  Map
/*-----------------------------------------------------------------------------------*/

function tt_map( $atts, $content = null ) {

extract( shortcode_atts( array(
	'address'		=> '',
	'zoomlevel'	=> '14',
	'height'		=> '500px',
	'width'			=> '100%'
	
), $atts ) );

ob_start();
// Property Query
if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
}
else {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}
	
$query_properties_args = array(
	'post_type' 			=> 'property',
	'posts_per_page' 	=> -1,
	'paged' 					=> $paged
);

$query_properties = new WP_Query( $query_properties_args );

if ( $query_properties->have_posts() ) :

$property_string = '';
$random = rand();

while ( $query_properties->have_posts() ) : $query_properties->the_post();

global $post;

//$google_maps = get_post_meta( $post->ID, 'estate_property_location', true );
//$coordinate = explode( ',', $google_maps );
$google_maps = get_post_meta( $post->ID, 'estate_property_google_maps', true );
if ( !empty( $google_maps ) ) {
	$address = $google_maps['address'];
	if($google_maps['lat']){
		$address_latitude=$google_maps['lat'];
    }
	else {
		$address_latitude='51.5286416';
	}
	if($google_maps['lng']){
		$address_longitude=$google_maps['lng'];
	}
	else {
		$address_longitude = '-0.1015987';
	}
}

// Check If We Have LatLng Coordinates From Google Maps
if ( $google_maps ) {

	$property_string .= "{ ";
	$property_string .= "permalink:'" . get_the_permalink() . "', ";
	$property_string .= "title:'" . get_the_title() . "', ";
	$property_string .= "price:'" . tt_property_price() . "', ";
	$property_string .= "latLng: new google.maps.LatLng(" . $address_latitude . ", " . $address_longitude . "), ";
	if ( has_post_thumbnail() ) { 
		$property_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		$property_string .= "thumbnail: '" . $property_thumbnail[0] . "'";
	}	
	else { 
		$property_string .= "thumbnail: '//placehold.it/300x100/eee/ccc/&text=..'";
	}
	$property_string .= " }," . "\n";

}

endwhile;

?>
<script>
var map = null, markers = [], newMarkers_<?php echo $random; ?> = [], markerCluster = null, infobox = [];

function initMap() {
  
	<?php echo tt_mapMarkers(); ?>

	var	mapOptions = {
		center: new google.maps.LatLng(0, 0),
		zoom: <?php echo $zoomlevel; ?>,
		scrollwheel: false,
		streetViewControl: true,
		disableDefaultUI: true
	};
	
	map = new google.maps.Map(document.getElementById("google-map-<?php echo $random; ?>"), mapOptions);
	<?php 
	global $realty_theme_option;
	if ($realty_theme_option['style-your-map']==true){ ?>
		if (map_options.map_style!=='') {
			var styles = JSON.parse(map_options.map_style);
			map.setOptions( { styles: styles } );
		}
	<?php } ?> 
	markers = initMarkers(map, [ <?php echo $property_string; ?> ]);
	
	function initMarkers(map, markerData) {
		    
		for( var i = 0; i < markerData.length; i++ ) {
			
			marker = new google.maps.Marker({
		    map: map,
		    position: markerData[i].latLng,
		    icon: customIcon,
		    animation: google.maps.Animation.DROP
			}),
					  	  
			infoboxOptions = {
			    content: 	'<div class="map-marker-wrapper">'+
			    						'<div class="map-marker-container">'+
				    						'<div class="arrow-down"></div>'+
												'<img src="'+markerData[i].thumbnail+'" />'+
												'<div class="content">'+
												'<a href="'+markerData[i].permalink+'">'+
												'<h5 class="title">'+markerData[i].title+'</h5>'+
												'</a>'+
												markerData[i].price+
												'</div>'+
											'</div>'+
								    '</div>',
			    disableAutoPan: false,
				  pixelOffset: new google.maps.Size(-33, -90),
				  zIndex: null,
				  isHidden: true,
				  alignBottom: true,
				  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
				  infoBoxClearance: new google.maps.Size(25, 25)
			};
			
			newMarkers_<?php echo $random; ?>.push(marker);
		
			newMarkers_<?php echo $random; ?>[i].infobox = new InfoBox(infoboxOptions);
			//newMarkers_<?php //echo $random; ?>[i].infobox.open(map, marker);
		
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
		    return function() {
		    	
		    	if ( newMarkers_<?php echo $random; ?>[i].infobox.getVisible() ) {
			    	newMarkers_<?php echo $random; ?>[i].infobox.hide();
		    	}
		    	else {
			    	jQuery('.infoBox').hide();
			    	newMarkers_<?php echo $random; ?>[i].infobox.show();
		    	}
		    	
		    	newMarkers_<?php echo $random; ?>[i].infobox.open(map, this);
		      map.panTo(markerData[i].latLng);
		      
		    }
			})( marker, i ) ); 
			
			google.maps.event.addListener(map, 'click', function() {
		    jQuery('.infoBox').hide();
		  });
			
		}
		
		var markerCluster_<?php echo $random; ?> = new MarkerClusterer(map, newMarkers_<?php echo $random; ?>, markerClusterOptions);
		
		return newMarkers_<?php echo $random; ?>;
		
	}
	
	// Spiderfier
	var oms = new OverlappingMarkerSpiderfier(map, { markersWontMove: true, markersWontHide: true, keepSpiderfied: true, legWeight: 5 });
	
	function omsMarkers( markers ) {
	  for ( var i = 0; i < markers.length; i++ ) {
	  	oms.addMarker( markers[i] );
	  }   
	}
	
	omsMarkers(markers);
	
	<?php if ( $address ) { ?>
	var address = '<?php echo $address; ?>';

	// Get latLng from property address and grab it with callback, as geocode calls asynchonous
  function getLatLng(callback) {
	  var geocoder = new google.maps.Geocoder();  	  
	  if ( geocoder ) {	  
		  geocoder.geocode( { 'address': address}, function(results, status ) { 
		    if (status == google.maps.GeocoderStatus.OK) {   	
		    	latLng = results[0].geometry.location;
		    	callback(latLng);
		    }
		    else {
			    alert("Geocoder failed due to: " + status);
		    }  		     
		  });	  
	  }   
  }
  
  getLatLng(function(latLng) {
	  map.setCenter(latLng);  	
  });
  <?php } ?>
  
}

google.maps.event.addDomListener(window, 'load', initMap);
google.maps.event.addDomListener(window, 'resize', initMap);

</script>

<div id="map-wrapper">
		
	<div id="map-controls">
		<a href="#" class="control" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
		<a href="#" class="control" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
		<a href="#" class="control" id="map-type" data-toggle="tooltip" title="<?php _e( 'Map Type', 'tt' ); ?>">
			<i class="fa fa-image"></i>
			<ul class="list-unstyled">
				<li id="map-type-roadmap"><?php _e( 'Roadmap', 'tt' ); ?></li>
				<li id="map-type-satellite"><?php _e( 'Satellite', 'tt' ); ?></li>
				<li id="map-type-hybrid"><?php _e( 'Hybrid', 'tt' ); ?></li>
				<li id="map-type-terrain"><?php _e( 'Terrain', 'tt' ); ?></li>
			</ul>
		</a>
		<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i><?php _e( 'Current Location', 'tt' ); ?></a>
	</div>
		
	<div id="google-map-<?php echo $random; ?>" style="height: <?php echo $height; ?>">
		<div class="spinner">
		  <div class="bounce1"></div>
		  <div class="bounce2"></div>
		  <div class="bounce3"></div>
		</div>	
	</div>
	
</div>

<?php

wp_reset_query();
	
else:
?>	
<div id="map-no-properties-found">
	<p class="lead text-center"><?php _e( 'No Properties Found.', 'tt' ) ?></p>
</div>
<?php
endif;
return ob_get_clean();
	
}
add_shortcode('map', 'tt_map');


/*-----------------------------------------------------------------------------------*/
/* Latest Posts
/*-----------------------------------------------------------------------------------*/

function tt_shortcode_latest_posts( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'posts'		=> '3',
		'columns'	=> '2'
	), $atts ) );
	
	ob_start();
	// Query Featured Properties
	$args_latest_posts = array(
		'post_type' 				=> 'post',
		'posts_per_page' 		=> $posts
	);
	
	$query_latest_posts = new WP_Query( $args_latest_posts );
	
	if ( $query_latest_posts->have_posts() ) :
	?>
	<div class="owl-latest-properties owl-carousel-<?php echo $columns; ?>">
		<?php
		while ( $query_latest_posts->have_posts() ) : $query_latest_posts->the_post();
		?>
		<article>
			<?php 
			if ( get_post_format( get_the_ID() ) == "video" ) {
				$video_url = get_post_meta( get_the_ID(), "estate_post_video_url", true );
				echo wp_oembed_get( $video_url );
			}
			elseif ( ( get_post_format( get_the_ID() ) == "gallery" ) ) {
				$gallery = get_post_meta( get_the_ID(), "estate_post_gallery", false );
				?>
				<div class="flexslider-nav-off">
					<ul class="slides">
					<?php
					
					$args = array(
						'post_type' => 'attachment',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__in' => $gallery,
						'posts_per_page' => count($gallery) // If no gallery image selected, it will add all attachments
					);
					
					$gallery_array = get_posts( $args );
					
					foreach ($gallery_array as $slide) {
						$attachment = wp_get_attachment_image_src( $slide->ID, 'thumbnail-400-300' );
						$attachment_url = $attachment[0];
					?>
						<li><img src="<?php echo $attachment_url; ?>" alt="" /></li>
					<?php 
					}
					?>
					</ul>
				</div>
				<?php
			}
			else {
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail-400-300', array( 'alt' => '' ) );
				}
			}
			?>
		
			<div class="content">
				<a href="<?php the_permalink(); ?>"><?php the_title( '<h4 class="title" style="margin-top: 1em">', '</h4>' ); ?></a>
				<?php	echo the_excerpt(); ?>
			</div>
			
		</article>
		<?php
		endwhile;
		?>
	</div>
	<?php
	wp_reset_query();
	endif;
	return ob_get_clean();
	
}
add_shortcode('latest_posts', 'tt_shortcode_latest_posts');