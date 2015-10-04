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
		add_action( 'admin_menu', array( &$this, 'add_options_page' ) );

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

		$value   = get_option( 'walkme-code' );

		$output = <<<HTML
	<div class="wrap">
		<h1>%s</h1>
		<a href="http://www.walkme.com/" target="_blank" >
			<img src="{$this->url}img/logo.png" title="WalkMe Logo">
		</a>
		<p>WalkMe&trade; is an interactive online guidance and engagement platform.</p>
		<p>WalkMe&trade; provides a cloud-based service designed to help professionals – customer service managers, user experience managers, training professionals, SaaS providers and sales managers – to guide and engage prospects, customers, employees and partners through any online experience.</p>
		<form action="options.php" method="POST" >
HTML;
		printf( $output, __( 'WalkMe Options', 'walkme' ) );

		settings_fields( 'walkme-group' );

		do_settings_sections( 'walkme-group' );

		$output  = <<<HTML
		<div>
			<label for="walkme_code">%s</label>
		</div>
		<div>
			<textarea id="walkme-code" name="walkme-code" cols="80" rows="5">%s</textarea>
		</div>
		<p class="description">%s
			<xmp>
<script type="text/javascript">(function() {var walkme = document.createElement("script");
walkme.type = "text/javascript"; walkme.async = true; walkme.src =
"http://cdn.walkme.com/users/HDeZFfidurmy6F/walkme_HDeZFfidurmy6F.js";
var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(walkme, s);})();
</script>
			</xmp>
		</p>
HTML;
		printf( $output, __( 'Insert your WalkMe Code', 'walkme' ), esc_attr( $value ), __( 'Your WalkMe code is the piece of JavaScript code that WalkMe says should go in your document &lt;head&gt; section. It looks something like', 'walkme' ) );

		submit_button( 'Save WalkMe Code' );

		echo "</form></div>";
	}

}
