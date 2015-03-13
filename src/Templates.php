<?php

namespace AgriLife\Extension;

class Templates {

    public function __construct() {

        add_filter( 'single_template', array( $this, 'get_single_template' ) );

        add_filter( 'genesis_single_crumb' , array( $this, 'ext_add_cpt_crumb' ), 10, 2);
        add_filter( 'genesis_archive_crumb' , array( $this, 'ext_add_cpt_crumb' ), 10, 2);

        // Remove some fields from posts
        add_filter( 'genesis_post_info', array( $this, 'ext_post_info_filter'), 10, 2);
        add_filter( 'genesis_post_meta', array( $this, 'ext_remove_post_entry_footer'), 10, 2);

    }


    /**
     * Shows the programs or solutions template when needed
     * @param  string $single_template The default single template
     * @return string                  The correct single template
     */
    public function get_single_template( $single_template ) {

        global $post;

        if ( get_query_var( 'post_type' ) == 'extension-programs' ) {
            $single_template = AG_EXT_DIR_PATH . '/view/extension-programs.php';
        }

        if ( get_query_var( 'post_type' ) == 'extension-solutions' ) {
            $single_template = AG_EXT_DIR_PATH . '/view/extension-solutions.php';
        }

        return $single_template;

    }

    /**
     * Shows the programs or solutions template when needed
     * @param  string $crumb         The default breadcrumb info
     * @param  string $args          The default breadcrumb args
     * @return string                The correct single template
     */
    function ext_add_cpt_crumb( $crumb, $args ) {
        if( is_singular( 'extension-solutions' ) ||  is_singular( 'extension-programs' ) ||  is_singular( 'post' ) )
            $crumb = get_the_title();
        if ( is_singular( 'extension-solutions' ) ) {
            $crumb = '<a href="' . get_permalink( get_page_by_title( 'Browse' ) ) . '">Browse</a> ' . $args['sep'] .
                '<a href="' . get_permalink( get_page_by_title( 'Featured Solutions' ) ) . '">Featured Solutions</a> ' . $args['sep'] .
                ' ' . $crumb;
        }
        if ( is_singular( 'extension-programs' ) ) {
            $crumb = '<a href="' . get_permalink( get_page_by_title( 'Browse' ) ) . '">Browse</a> ' . $args['sep'] .
                '<a href="' . get_permalink( get_page_by_title( 'Program Areas' ) ) . '">Program Areas</a> ' . $args['sep'] .
                ' ' . $crumb;
        }
        if ( is_singular( 'post' ) ) {
            $categories = get_the_category();
            $categorylist = '';
            if($categories){
                foreach($categories as $category) {
                    $categorylist .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$args['sep'];
                }
            }
            $crumb = $categorylist . $crumb;
        }
        if (  is_category()  ) {
            $crumb = '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) .'</a> ' . $args['sep'] . $crumb;
        }

        return $crumb;
    }

    function ext_post_info_filter($post_info) {
        $post_info = '[post_date]';
        return $post_info;
    }

    function ext_remove_post_entry_footer() {
        remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
        remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
    }

}