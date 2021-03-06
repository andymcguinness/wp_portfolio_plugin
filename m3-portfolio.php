<?php
/*
Plugin Name: m3 Portfolio
Plugin URI: http://andymcguinness.com/
Description: Creates a custom post type, portfolio_item, that will contain my portfolio items; will also eventaully create a shortcode that will display my portfolio items.
Version: 0.2
Author: Andy McGuinness
Author URI: http://andymcguinness.com
License: GPLv2
*/

// Creating the post type/generating the general admin interface

function m3_portfolio_item_post_type() {
    register_post_type( 'portfolio_item',
        array(
            'labels' => array(
                'name' => 'Portfolio Items',
                'singular_name' => 'Portfolio Item',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Portfolio Item',
                'edit' => 'Edit',
                'edit_item' => 'Edit Portfolio Item',
                'new_item' => 'New Portfolio Item',
                'view' => 'View',
                'view_item' => 'View Portfolio Item',
                'search_items' => 'Search Portfolio Items',
                'not_found' => 'No Portfolio Items found',
                'not_found_in_trash' => 'No Portfolio Items found in Trash',
                'parent' => 'Parent Portfolio Item'
            ),
 
            'public' => true,
            'menu_position' => 25,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/portfolio.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

add_action( 'init', 'm3_portfolio_item_post_type' );


// Creating the shortcode

function m3_portfolio_item_shortcode() {
	$args = array(
		'post_type'        	=> 'portfolio_item',
		'posts_per_page'	=> -1
	);
	
	$items = get_posts( $args );
	
	$output .= '<ul class="portfolio large-block-grid-3 medium-block-grid-2 small-block-grid-1">';
	
	foreach ($items as $item) {
		$thumbnail =  get_the_post_thumbnail($item->ID, 'large');
		preg_match( '/http:\/\/[^"]*/', $thumbnail, $matches );
		
		$src = $matches[0];
		
		$item_output = '<li>';
		$item_output .= '<a href="http://andymcguinness.com/portfolio_item/'. $item->post_name . '">';
		$item_output .= '<div class="post-circle" style="background-image:url(' . $src . ');"></div>';
		$item_output .= '</a>';
		$item_output .= '<br />';
		$item_output .= '<p>' . $item->post_title . '</p>';
		$item_output .= '</li>';
		
		$output .= $item_output;
	}
	
	$output .= '</ul>';
	
	return $output;
}
add_shortcode( 'portfolio_items', 'm3_portfolio_item_shortcode' );

?>
