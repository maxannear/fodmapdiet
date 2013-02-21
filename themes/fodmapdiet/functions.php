<?php
/**
 * Required by WordPress.
 *
 * Keep this file clean and only use it for requires.
 */

require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/rewrites.php');        // URL rewriting for assets
require_once locate_template('/lib/htaccess.php');        // HTML5 Boilerplate .htaccess
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/custom.php');          // Custom functions


function getFoods() {
	header("Content-type: application/json");
	$mypost = array( 'post_type' => 'food_items', );
    $loop = new WP_Query( $mypost );
	
	$foods = array();
	
	while ( $loop->have_posts() ) : $loop->the_post();
			//$foodID = get_the_ID(); 
			$foodName = get_the_title();
			$edible = get_post_meta( get_the_ID(), 'edible', true ); 			
			$foods[$foodName] = $edible;			
    endwhile;
	
	echo json_encode($foods);
    exit();
}

add_action('wp_ajax_get_foods', 'getFoods');
add_action('wp_ajax_nopriv_get_foods', 'getFoods');


