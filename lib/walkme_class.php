<?php

class WalkMe {

	public static function get_instance() {

        static $instance = null;

        if ( null === $instance )
			$instance = new static();

        return $instance;
    }

	private function __clone(){
    }

    
    private function __wakeup(){
    }

	protected function __construct() {

		// Add the saved JS to the document head
		add_action( 'wp_head', array( &$this, 'add_walkme_to_head' ) );

	}

	/*
	 * Add saved code into the document head
	 *
	 * @since 1.0
	 **/
	public static function add_walkme_to_head(  ) {

		$walkme_code = get_option( 'walkme-code' );

		if( !empty( $walkme_code ) )
			echo $walkme_code;

	}

	
}