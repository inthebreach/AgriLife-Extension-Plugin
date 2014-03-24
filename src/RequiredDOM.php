<?php
namespace AgriLife\Extension;

class RequiredDOM {

	public function __construct() {

		// Alter header title
		add_filter( 'genesis_seo_title', array( $this, 'seo_title' ), 10, 3 );

		// Remove Site Description
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

		// Render the social icons in header
		add_action( 'genesis_site_description', array($this, 'render_social_header') ) ;

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
	 * Render the social icons in header
	 * @since 1.0
	 * @return string
	 */
	public function render_social_header() {

		$output = '<div class="social-icons">Social</div>';

		echo $output;

	}


}