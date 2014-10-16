<?php
/**
 * Plugin Name: AgriLife Extension
 * Plugin URI: https://github.com/AgriLife/AgriLife-Extension
 * Description: Functionality for AgriLife Extension sites
 * Version: 1.0
 * Author: J. Aaron Eaton
 * Author URI: http://channeleaton.com
 * Author Email: aaron@channeleaton.com
 * License: GPL2+
 */

require 'vendor/autoload.php';

define( 'AG_EXT_DIRNAME', 'agrilife-extension' );
define( 'AG_EXT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AG_EXT_DIR_FILE', __FILE__ );
define( 'AG_EXT_DIR_URL', plugin_dir_url( __FILE__ ) );

// Register plugin activation functions
$activate = new \AgriLife\Core\Activate;
register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
$deactivate = new \AgriLife\Core\Deactivate;
register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

$ext_required_dom = new \AgriLife\Extension\RequiredDOM();

$ext_asset = new \AgriLife\Extension\Asset();

$ext_ajax = new \AgriLife\Extension\Ajax();

$ext_templates = new \AgriLife\Extension\Templates();

$ext_widget_areas = new \AgriLife\Extension\WidgetAreas();

add_action( 'widgets_init', function() {
	register_widget( '\AgriLife\Extension\Widget\CountyOfficeLocator' );
});


// Load ACF Custom Post Types
add_action( 'agrilife_core_init', function() {
	$ext_posttype_program = new \AgriLife\Extension\PostType\Program();
});

add_action( 'agrilife_core_init', function() {
	$ext_posttype_solution = new \AgriLife\Extension\PostType\Solution();
});

// Add new ACF json load point
add_filter('acf/settings/load_json', 'agrilife_ext_acf_json_load_point');

function agrilife_ext_acf_json_load_point( $paths ) {
    $paths[] =  AG_EXT_DIR_PATH . 'fields' ;
    return $paths;
}
