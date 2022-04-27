<?php
namespace AgriLife\Extension;

class RequiredDOM {

	public function __construct() {

		// Alter header title
		add_filter( 'genesis_seo_title', array( $this, 'seo_title' ), 10, 3 );

		// Remove Site Description
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

        // Add Extension Body Class
        add_filter( 'body_class', array( $this, 'ext_body_class') );

        // Add Page Slug to Body Class
        add_filter( 'body_class', array( $this, 'slug_body_class') );

        // Render the footer
        add_action( 'genesis_header', array($this, 'add_extension_footer_content') ) ;

        // Remove search from navigation
        //add_action( 'genesis_header', array($this, 'remove_search') ) ;

        // Move tagline below navigation
        add_action('genesis_header',array($this, 'move_tagline') );

        add_filter( 'genesis_seo_description', array($this, 'add_tagline_link'), 11, 3);

	}

	/**
	 * Modifies the header title
	 *
	 * @param $title The title text
	 * @param $inside
	 * @param $wrap
	 *
	 * @return string
	 */
	public function seo_title( $title, $inside, $wrap ) {
		$inside = sprintf( '<a href="%s" title="%s"><span>%s</span></a>',
			esc_attr( get_bloginfo('url') ),
			esc_attr( get_bloginfo('name') ),
			get_bloginfo( 'name' ) );

		$title = sprintf( '<%s class="site-title" itemprop="headline">%s</%s>',
			$wrap,
			$inside,
			$wrap
		);

		return $title;
	}


    /**
     * Moves the tagline
     *
     * @return void
     */
    public function move_tagline() {

        remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
        add_action('genesis_after_header','genesis_seo_site_description');

    }

    /**
     * Adds a hyperlink
     *
     * @return void
     */
    public function add_tagline_link( $desc, $inside, $wrap ){

        $new_inside = $inside . ' <a href="/about/economic-impact-briefs/">View Economic Impacts</a> <span class="aquo">&raquo;</span>';

        $desc = str_replace($inside, $new_inside, $desc);

        return $desc;

    }

    /**
     * Add and Extension body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function ext_body_class( $classes ) {

        $classes[] = 'extenion-site';
        return $classes;

    }

    /**
     * Add page slug and category to body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function slug_body_class( $classes ) {

        global $post;

        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;

            $parent = get_page($post->post_parent);
            $classes[] = $parent->post_type . '-parent-' . $parent->post_name;
        }

        return $classes;

    }

    /**
     * Add extension info to bottom of page
     * @since 1.0
     * @return void
     */
    public function add_extension_footer_content()
    {
        remove_all_actions('genesis_footer');
        add_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
        add_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

        add_action('genesis_footer', array($this, 'render_ext_logo'));
        add_action('genesis_footer', array($this, 'render_tamus_logo'));
        add_action('genesis_footer', array($this, 'render_footer_widgets'));
        add_action('genesis_footer', array($this, 'render_required_links'));
    }

    /**
     * Render Extension logo
     * @since 1.0
     * @return string
     */
    public function render_ext_logo()
    {

        $output = '
            <div class="footer-container-ext">
                <a href="http://agrilifeextension.tamu.edu/" title="Texas A&M AgriLife Extension Service"><img class="footer-ext-logo" src="'.AG_EXT_DIR_URL.'/img/logo-ext.png" title="Texas A&M AgriLife Extension Service" alt="Texas A&M AgriLife Extension Service" /></a>
            </div>';

        echo $output;

    }

	/**
	 * Render the widgets in the footer
	 * @since 1.0
	 * @return void
	 */
	public function render_footer_widgets() {

        if ( is_active_sidebar( 'footer-center' ) ) : ?>
            <div id="footer-center-widgets" class="footer-center widget-area" role="complementary">
                <?php dynamic_sidebar( 'footer-center' ); ?>
            </div><!-- #footer-center-widgets -->
        <?php endif;

	}

    /**
     * Remove search from navigation
     * @return void
     */
    public function remove_search() {

        global $wp_filter;
        remove_all_filters( 'agriflex_nav_elements', 11);

    }

    /**
     * Render search field
     * @since 1.0
     * @return string
     */
    public function display_search() {

        $output = sprintf( '<div class="search">%s</div>',
            get_search_form( false )
        );
        return $output;

    }


    /**
     * Render TAMUS logo
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_tamus_logo()
    {

        $output = '
            <div class="footer-container-tamus">
                <a href="http://tamus.edu/" title="Texas A&amp;M University System"><img class="footer-tamus" src="'.AG_EXT_DIR_URL.'/img/logo-tamus.png" title="Texas A&amp;M University System Member" alt="Texas A&amp;M University System Member" /></a>
            </div>';

        echo $output;

    }

    /**
     * Render required links
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_required_links()
    {

        $output = '
            <div class="footer-container-required">
                <ul class="req-links">
			        <li><a href="https://agrilifeextension.tamu.edu/about/legal-information/compact-texans/">Compact with Texans</a></li>
			        <li><a href="https://agrilifeextension.tamu.edu/about/legal-information/privacy-policy/">Privacy and Security</a></li>
			        <li><a href="http://itaccessibility.tamu.edu/" target="_blank">Accessibility Policy</a></li>
			        <li><a href="https://dir.texas.gov/resource-library-item/state-website-linking-privacy-policy" target="_blank">State Link Policy</a></li>
			        <li><a href="http://www.tsl.state.tx.us/trail" target="_blank">Statewide Search</a></li>
			        <li><a href="http://www.tamus.edu/veterans/" target="_blank">Veterans Benefits</a></li>
			        <li><a href="https://fch.tamu.edu/programs/military-programs/" target="_blank">Military Families</a></li>
			        <li><a href="https://secure.ethicspoint.com/domain/en/report_custom.asp?clientid=19681" target="_blank">Risk, Fraud &amp; Misconduct Hotline</a></li>
			        <li><a href="https://gov.texas.gov/organization/hsgd" target="_blank">Texas Homeland Security</a></li>
			        <li><a href="http://veterans.portal.texas.gov/">Texas Veterans Portal</a></li>
			        <li><a href="http://agrilifeas.tamu.edu/hr/diversity/equal-opportunity-educational-programs/" target="_blank">Equal Opportunity</a></li>
			        <li class="last"><a href="https://agrilife.tamu.edu/required-links/orpi/">Open Records/Public Information</a></li>
		        </ul>
            </div>';


        echo $output;

    }

}
