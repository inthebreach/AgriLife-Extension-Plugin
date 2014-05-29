<?php

namespace AgriLife\Extension;

class Ajax {

	public function __construct() {

		add_action( 'wp_ajax_get_units', array( $this, 'get_units' ) );
		add_action( 'wp_ajax_nopriv_get_units', array( $this, 'get_units' ) );

	}

	public function get_units() {

        $agrilife_units = get_transient( 'agrilife_units' );

		if ( false === $agrilife_units ) {
			// Get from PeopleAPI
			$soap = new \SoapClient( 'https://agrilifepeople.tamu.edu/api/v4.cfc?wsdl' );
			$api = new \AgriLife\Core\PeopleAPI( $soap );
			$agrilife_units = $api->get_units( 'MR1ac6DLFjce4q9zl6M9Kw==', 2 );
			set_transient( 'agrilife_units', $agrilife_units, WEEK_IN_SECONDS );
		}

//		$agrilife_units = array(
//			'test' => 'This is a test'
//		);

		die( json_encode( $agrilife_units ) );

	}

}