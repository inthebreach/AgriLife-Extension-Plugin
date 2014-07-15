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

		// Render the social icons in header
		add_action( 'genesis_site_description', array($this, 'render_social_icons') ) ;

        // Render the footer
        add_action( 'genesis_header', array($this, 'add_extension_footer_content') ) ;

        // Remove search from navigation
        add_action( 'genesis_header', array($this, 'remove_search') ) ;

        // Add the search to header
        add_action( 'genesis_site_description', array( $this, 'display_search') );


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
        add_action('genesis_footer', array($this, 'render_social_icons'));
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
                <a href="http://agrilifeextension.tamu.edu/" title="Texas A&M AgriLife Extension Service"><img class="footer-ext-logo" src="'.AG_EXT_DIR_URL.'/img/logo-ext.png" title="Texas A&M AgriLife Extension Service" alt="Texas A&M AgriLife Extension Service" /><noscript><img src="//agrilifecdn.tamu.edu/wp-content/themes/AgriLife-Beta/images/footer-tamus.png" title="Texas A&M University System Member" alt="Texas A&M University System Member" /></noscript></a>
            </div>';

        echo $output;

    }

	/**
	 * Render the social icons in header
	 * @since 1.0
	 * @return string
	 */
	public function render_social_icons() {

		$output = '<div id="simple-social-icons-1" class="widget simple-social-icons social-icons">
		    <div class="widget-wrap"><ul class="alignleft"><li class="social-facebook"><a href="http://twitter.com/travis"></a></li><li class="social-flickr"><a href="http://twitter.com/travis"></a></li><li class="social-twitter"><a href="http://twitter.com/travis"></a></li><li class="social-vimeo"><a href="http://twitter.com/travis"></a></li></ul></div>



		</div>';

		echo $output;

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
                <a href="http://tamus.edu/" title="Texas A&M University System"><img class="footer-tamus" src="'.AG_EXT_DIR_URL.'/img/logo-tamus.png" title="Texas A&M University System Member" alt="Texas A&M University System Member" /><noscript><img src="//agrilifecdn.tamu.edu/wp-content/themes/AgriLife-Beta/images/footer-tamus.png" title="Texas A&M University System Member" alt="Texas A&M University System Member" /></noscript></a>
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
            <div class="footer-container">
                <ul class="req-links">
			        <li><a href="http://agrilife.org/required-links/compact/">Compact with Texans</a></li>
			        <li><a href="http://agrilife.org/required-links/privacy/">Privacy and Security</a></li>
			        <li><a href="http://itaccessibility.tamu.edu/" target="_blank">Accessibility Policy</a></li>
			        <li><a href="http://www2.dir.state.tx.us/pubs/Pages/weblink-privacy.aspx" target="_blank">State Link Policy</a></li>
			        <li><a href="http://www.tsl.state.tx.us/trail" target="_blank">Statewide Search</a></li>
			        <li><a href="http://www.tamus.edu/veterans/" target="_blank">Veterans Benefits</a></li>
			        <li><a href="http://fcs.tamu.edu/families/military_families/" target="_blank">Military Families</a></li>
			        <li><a href="https://secure.ethicspoint.com/domain/en/report_custom.asp?clientid=19681" target="_blank">Risk, Fraud &amp; Misconduct Hotline</a></li>
			        <li><a href="http://www.texashomelandsecurity.com/" target="_blank">Texas Homeland Security</a></li>
			        <li><a href="http://veterans.portal.texas.gov/">Texas Veteran&apos;s Portal</a></li>
			        <li><a href="http://aghr.tamu.edu/education-civil-rights.htm" target="_blank">Equal Opportunity for Educational Programs Statement</a></li>
			        <li class="last"><a href="http://agrilife.org/required-links/orpi/">Open Records/Public Information</a></li>
		        </ul>
            </div>';

        echo $output;

    }

}