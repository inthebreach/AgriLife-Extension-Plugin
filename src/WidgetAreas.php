<?php

namespace AgriLife\Extension;

class WidgetAreas {

    public function __construct() {

        add_filter( 'genesis_setup', array( $this, 'register_widget_areas' ), 11 );

    }


    /**
     * Register Extension Widget Areas
     *
     * @since 1.0
     *
     * @uses genesis_register_widget_area() Register widget areas.
     */
    public function register_widget_areas() {

        genesis_register_widget_area(
            array(
                'id'               => 'footer-center',
                'name'             => __( 'Footer Center', 'agrilife_extension' ),
                'description'      => __( 'This is the footer widget area. It appears above the required links. This widget area is not equipped to display any widget, and works best with the Simple Social widget', 'agrilife_extension' ),
                '_genesis_builtin' => false,
            )
        );

        genesis_register_widget_area(
            array(
                'id'               => 'solutions-menu-column',
                'name'             => __( 'Solutions Menu', 'agrilife_extension' ),
                'description'      => __( 'This is the Solutions menu widget area. It appears in the left column. This widget area is not equipped to display any widget, and works best with menus', 'agrilife_extension' ),
                '_genesis_builtin' => false,
            )
        );

    }


}