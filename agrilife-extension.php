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
$activate = new \AgriLife\Core\Plugin\Activate;
register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
$deactivate = new \AgriLife\Core\Plugin\Deactivate;
register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

// Initialize the main plugin file
add_action( 'plugins_loaded', 'AgriLife\Extension\Init::get_instance' );


new \AgriFlex_Extension_RequiredDOM();

class AgriFlex_Extension_RequiredDOM
{
    public function __construct()
    {
        // Remove Site Description
        $this->remove_genesis_description();

        // Render the social icons in header
        //$this->render_header_social();

        // Alter header title
        // $this->ext_header_title();

        //* Reposition the breadcrumbs
        //$this->move_genesis_breadcrumbs();

        // Bring in typekit
        //$this->add_ext_typekit();

        // Remove old and use Extension Stylesheet
        // $this->add_ext_styles();
    }


    /**
     * Remove default Genesis description from header
     * @since 1.0
     * @return void
     */
    private function replace_stylesheet_ext()
    {
        global $af_assets;
        //wp_dequeue_style( 'default-styles' );

        wp_enqueue_style( 'ext-styles' );
        wp_enqueue_style( array( $af_assets, 'ext-styles' ) );
    }
    private function add_ext_styles() {
        global $af_assets;
        remove_action( 'wp_footer', array( $af_assets, 'enqueue_global_styles' ), 12);
        add_action( 'wp_footer', array( $af_assets, 'replace_stylesheet_ext' ), 12 );
    }

    /**
     * Remove default Genesis description from header
     * @since 1.0
     * @return void
     */
    private function remove_genesis_description()
    {

        remove_action( 'genesis_site_description', 'genesis_seo_site_description', 100 );

    }

    /**
     * Modify the header title
     * @since 1.0
     * @return string
     */
    private function ext_header_title()
    {
        add_filter('genesis_seo_title', 'sp_seo_title', 10, 3);
        function sp_seo_title($title, $inside, $wrap)
        {
            $inside = sprintf('<a href="%s" title="%s"><span>%s</span></a>', esc_attr(get_bloginfo('url')), esc_attr(get_bloginfo('name')), get_bloginfo('name'));
            $title = sprintf('<%s class="site-title" itemprop="headline">%s</%s>', $wrap, $inside, $wrap);
            return $title;
        }
    }

    /**
     * Render social icons in header
     * @since 1.0
     * @return void
     */
    private function render_header_social()
    {

        add_action( 'genesis_site_description', array($this, 'render_social_header')) ;

    }

    /**
     * Render the social icons in header
     * @since 1.0
     * @return string
     */
    public function render_social_header()
    {

        $output = '
          <div class="social-icons">
            Social
		  </div>
		  ';

        echo $output;

    }

    private function add_ext_typekit() {
        // Bring in typekit
        add_action( 'wp_head', array( $this, 'add_typekit' ),0,'xox0blb');
    }


    /**
     * Add the correct Typekit
     * @since 1.0
     * @todo Replace with async js and deal with FOUC
     * @todo Move this up to core
     * @return string
     */
    public function add_typekit($key) {

        if( !is_admin() ) :
            ?>
            <script type="text/javascript" src="//use.typekit.net/<?php echo $key; ?>.js"></script>
            <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        <?php
        endif;

    }


}