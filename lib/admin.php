<?php

class WalkMeAdmin extends WalkMe {

	private $url;

	public static function get_instance()
    {
        static $instance = null;

        if ( null === $instance ) {
            $instance = new static();
        }

        return $instance;
    }

    private function __clone(){
    }

    
    private function __wakeup(){
    }

	protected function __construct() {

		parent::get_instance();

		$this->url = plugins_url() . '/walkme/';

		// Add the options page to the Tools menu
		add_action('admin_menu', array( &$this, 'add_options_page') );

		// Create the form on the options page
		add_action( 'admin_init', array( &$this, 'register_walkme_settings' ) );
	}

	/*
	 * Adds the metabox to post and page edit screens 
	 *
	 * @since 1.0
	 **/
	public function add_options_page() {

		add_management_page( 'WalkMe', 
							 'WalkMe', 
							 'manage_options', 
							 'walkme', 
							 array( &$this, 'do_walkme_page' ) );

	}

	/*
	 * Registers the settings using the Settings API
	 *
	 * @since 1.0
	 **/
	public static function register_walkme_settings(  ) {

		register_setting( 'walkme-group', 'walkme-code' );

	}


	/**
	 * Saves the metabox data with the walkme code
	 *
	 * @param WP_Post $post The object for the current post/page.
	 * @since 1.0
	 */
	public function do_walkme_page( $post ) {

		$value   = get_option('walkme-code');

		$output  = '';

		$output .= '<div class="wrap">';

		$output .= '<h1>' . __( 'WalkMe Options', 'walkme' ) . '</h1>';

		$output .= '<a href="http://www.walkme.com/" target="_blank" >';

		$output .= '<img src="' . $this->url . 'img/logo.png" title="WalkMe Logo">';

		$output .= '</a>';

		$output .= '<p>WalkMe™ is an interactive online guidance and engagement platform.</p>';

		$output .= '<p>WalkMe™ provides a cloud-based service designed to help professionals – customer service managers, user experience managers, training professionals, SaaS providers and sales managers – to guide and engage prospects, customers, employees and partners through any online experience.</p>';

		$output .= '<form action="options.php" method="POST" >';

		echo $output;

		settings_fields( 'walkme-group' );

		do_settings_sections( 'walkme-group' );

		$output  = '';

		$output .= '<div>';

		$output .= '<label for="walkme_code">';
		
		$output .= __( 'Insert your WalkMe Code', 'walkme' );
		
		$output .= '</label> ';

		$output .= '</div>';

		$output .= '<div>';
		
		$output .= '<input type="text" id="walkme-code" name="walkme-code" value="' . esc_attr( $value ) . '" size="50" />';

		$output .= '</div>';

		$output .= '<p class="description">';

		$output .= __( 'Your WalkMe code is the piece of JavaScript code that WalkMe says should go in your document &lt;head&gt; section. It looks something like', 'walkme' );

		$output .= '<xmp>';

		$output .= '
<script type="text/javascript">(function() {var walkme = document.createElement("script"); 
walkme.type = "text/javascript"; walkme.async = true; walkme.src = 
"http://cdn.walkme.com/users/9tK6MJmqLebvdGLoxXd7WBKPV/test/walkme_9tK6MJmqLebvdGLoxXd7WBKPV.js"; 
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(walkme, s);})();
</script>';

		$output .= '</xmp>';

		$output .= '</p>';

		echo $output;

		submit_button( 'Save WalkMe Code' );

		$output  = '';

		$output .= '</form>';

		$output .= '</div>';

		echo $output;
	
	}
	
}
