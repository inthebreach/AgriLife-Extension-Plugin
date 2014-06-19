<?php

namespace AgriLife\Extension\PostType;

class Program {

	public function __construct() {

		if ( get_field( 'agrilife-main-site', 'option' ) )
			add_action( 'init', array( $this, 'register_post_type' ) );

	}

	public function register_post_type() {

		$labels = array(
			'name' => __( 'Programs', 'agrilife' ),
			'singular_name' => __( 'Programs', 'agrilife' ),
			'add_new' => __( 'Add New', 'agrilife' ),
			'add_new_item' => __( 'Add New Program', 'agrilife' ),
			'edit_item' => __( 'Edit Program', 'agrilife' ),
			'new_item' => __( 'New Program', 'agrilife' ),
			'view_item' => __( 'View Program', 'agrilife' ),
			'search_items' => __( 'Search Programs', 'agrilife' ),
			'not_found' => __( 'No Programs Found', 'agrilife' ),
			'not_found_in_trash' => __( 'No Programs found in trash', 'agrilife' ),
			'parent_item_colon' => '',
			'menu_name' => __( 'Programs', 'agrilife' ),
		);

		// Post type arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'rewrite' => array( 'with_front' => false, 'slug' => 'programs' ),
			'supports' => array( 'title', 'revisions' ),
			'has_archive' => true,
			'menu_icon' => 'dashicons-welcome-widgets-menus',
		);

		// Register the Programs post type
		register_post_type( 'extension-programs', $args );

	}

}