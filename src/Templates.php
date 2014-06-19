<?php

namespace AgriLife\Extension;

class Templates {

    public function __construct() {

        add_filter( 'single_template', array( $this, 'get_single_template' ) );

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


}