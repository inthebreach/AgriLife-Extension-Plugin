<?php

namespace AgriLife\Extension\PostType;

class Solution {

	public function __construct() {

		if ( get_field( 'agrilife-main-site', 'option' ) )
			add_action( 'init', array( $this, 'register_post_type' ) );

	}

	public function register_post_type() {

		$labels = array(
			'name' => __( 'Solutions', 'agrilife' ),
			'singular_name' => __( 'Solutions', 'agrilife' ),
			'add_new' => __( 'Add New', 'agrilife' ),
			'add_new_item' => __( 'Add New Solution', 'agrilife' ),
			'edit_item' => __( 'Edit Solution', 'agrilife' ),
			'new_item' => __( 'New Solution', 'agrilife' ),
			'view_item' => __( 'View Solution', 'agrilife' ),
			'search_items' => __( 'Search Solutions', 'agrilife' ),
			'not_found' => __( 'No Solutions Found', 'agrilife' ),
			'not_found_in_trash' => __( 'No Solutions found in trash', 'agrilife' ),
			'parent_item_colon' => '',
			'menu_name' => __( 'Solutions', 'agrilife' ),
		);

		// Post type arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'solutions' ),
			'supports' => array( 'title', 'revisions' ),
			'has_archive' => true,
			'menu_icon' => 'dashicons-hammer',
		);

		// Register the Solutions post type
		register_post_type( 'extension-solutions', $args );

	}

}