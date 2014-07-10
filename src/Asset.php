<?php

namespace AgriLife\Extension;

class Asset {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'register_js' ) );

        $this->add_image_sizes();

        // Register global styles used in the theme
        add_action( 'wp_enqueue_scripts', array( $this, 'register_ext_styles' ) );

        // Enqueue extension styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_ext_styles' ) );

        // Dequeue global styles
        add_action( 'wp_print_styles', array( $this, 'dequeue_global_styles'), 5 );

	}

	public function register_js() {

		wp_register_script(
			'jquery-cookie',
			AG_EXT_DIR_URL . 'bower_modules/jquery-cookie/jquery.cookie.js',
			array( 'jquery' ),
			false,
			true
		);

		wp_register_script(
			'county-office-locator',
			AG_EXT_DIR_URL . '/js/county-office-locator.js',
			array( 'jquery', 'jquery-cookie' ),
			false,
			true
		);

	}

    /**
     * Add the required image sizes
     * @return void
     */
    public function add_image_sizes() {

        add_image_size( 'program-solution_single', 558, 287, true );

    }

    /**
     * Registers all styles used within the plugin
     * @since 1.0
     * @return void
     */
    public function register_ext_styles() {

        wp_register_style(
            'extension-styles',
            AF_THEME_DIRURL . '/css/ext.css',
            array(),
            '',
            'screen'
        );

    }

    /**
     * Enqueues extension styles
     * @since 1.0
     * @global $wp_styles
     * @return void
     */
    public function enqueue_ext_styles() {

        wp_enqueue_style( 'extension-styles' );

    }

    /**
     * Dequeues global styles
     * @since 1.0
     * @global $wp_styles
     * @return void
     */
    public function dequeue_global_styles() {

        wp_dequeue_style( 'default-styles' );

    }

}