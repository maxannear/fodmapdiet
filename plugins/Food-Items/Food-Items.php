<?php
/*
Plugin Name: Food Item
Description: Declares a plugin that will create a custom post type displaying food items.
Version: 1.0
Author: Max Annear
Author URI: maxannear.github.com
License: GPLv2
*/

add_action( 'init', 'create_food_item' );
add_action( 'admin_init', 'my_admin' );
add_action( 'save_post', 'add_food_item_fields', 10, 3);

function create_food_item() {
    register_post_type( 'food_items',
        array(
            'labels' => array(
                'name' => 'Food Items',
                'singular_name' => 'Food Item',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Food Item',
                'edit' => 'Edit',
                'edit_item' => 'Edit Food Item',
                'new_item' => 'New Food Item',
                'view' => 'View',
                'view_item' => 'View Food Item',
                'search_items' => 'Search Food Items',
                'not_found' => 'No Food Items found',
                'not_found_in_trash' => 'No Food Items found in Trash',
                'parent' => 'Parent Food Item'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'icon.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

function my_admin() {
    add_meta_box( 'food_item_meta_box',
        'Food Item Details',
        'display_food_item_meta_box',
        'food_items', 'normal', 'high'
    );
}


function display_food_item_meta_box( $food_item ) {
    // Retrieve current attributes and populate the boxes with that
    $edible =  get_post_meta( $food_item->ID, 'edible', true );
	$fodmap_source =  get_post_meta( $food_item->ID, 'fodmap_source', true );
	$food_group =  get_post_meta( $food_item->ID, 'food_group', true );
    ?>
    <table>
        <tr>
            <td style="width: 250px">Edible on FODMAP diet</td>
            <td>
                <select style="width: 150px" name="food_item_edible">
					<option value="yes" <?php echo selected( "yes", $edible ); ?> >Yes</option>
					<option value="no" <?php echo selected( "no", $edible ); ?> >No</option>
					<option value="maybe" <?php echo selected( "maybe", $edible ); ?> >Maybe</option>
                </select>
            </td>
        </tr>
		
		
        <tr>
            <td style="width: 250px">FODMAP Source</td>
            <td>
                <select style="width: 150px" name="food_item_fodmap_source">
					<option value="none" <?php echo selected( "none", $fodmap_source ); ?> >None</option>
					<option value="fructans" <?php echo selected( "fructans", $fodmap_source ); ?> >Fructans</option>
					<option value="galactans" <?php echo selected( "galactans", $fodmap_source ); ?>>Galactans</option>
					<option value="polyols" <?php echo selected( "polyols", $fodmap_source ); ?>>Polyols</option>
					<option value="fructose" <?php echo selected( "fructose", $fodmap_source ); ?>>Fructose</option>
					<option value="polyols" <?php echo selected( "polyols", $fodmap_source ); ?>>Lactose</option>
                </select>
            </td>
        </tr>
		
		<tr>
            <td style="width: 250px">Food Group</td>
            <td>
                <select style="width: 150px" name="food_item_food_group">
					<option value="other" <?php echo selected( "other", $food_group ); ?>>Other</option>
					<option value="dairy" <?php echo selected( "dairy", $food_group ); ?> >Dairy</option>
					<option value="fatsandoils" <?php echo selected( "fatsandoils", $food_group ); ?> >Fats and Oils</option>
					<option value="fruit" <?php echo selected( "fruit", $food_group ); ?>>Fruit</option>
					<option value="grains" <?php echo selected( "grains", $food_group ); ?>>Grains</option>
					<option value="meat" <?php echo selected( "meat", $food_group ); ?>>Meat</option>
					<option value="sweets" <?php echo selected( "sweets", $food_group ); ?>>Sweets</option>
					<option value="vegetables" <?php echo selected( "vegetables", $food_group ); ?>>Vegetables</option>
					<option value="drink" <?php echo selected( "drink", $food_group ); ?>>Drink</option>
					<option value="alcohol" <?php echo selected( "alcohol", $food_group ); ?>>Alcohol</option>					
                </select>
            </td>
        </tr>
    </table>
    <?php
}

function add_food_item_fields( $food_item_id, $food_item ) {
    // Check post type for food items
    if ( $food_item->post_type == 'food_items' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['food_item_edible'] ) && $_POST['food_item_edible'] != '' ) {
            update_post_meta( $food_item_id, 'edible', $_POST['food_item_edible'] );
        }
        
		if ( isset( $_POST['food_item_fodmap_source'] ) && $_POST['food_item_fodmap_source'] != '' ) {
            update_post_meta( $food_item_id, 'fodmap_source', $_POST['food_item_fodmap_source'] );
        }
		
		if ( isset( $_POST['food_item_food_group'] ) && $_POST['food_item_food_group'] != '' ) {
            update_post_meta( $food_item_id, 'food_group', $_POST['food_item_food_group'] );
        }
    }
}

?>