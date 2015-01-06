<?php

/*
Plugin Name: Walk Me
Plugin URI: http://drunkencoding.us
Description: Provides easy integration between the Walk Me service and WordPress
Version: 0.1
Author: Ryan Hoover
Author URI: http://ryan.hoover.ws
*/

class WalkMe {

	public static function get_instance()
    {
        static $instance = null;

        if ( null === $instance ) {
            $instance = new static();
        }

        return $instance;
    }

	protected function __construct() {

		//Add the script call to loading of all WordPress JS scripts
		add_action('wp_enqueue_scripts', array( &$this, 'walkme_script') );

		//Add the metabox to post and page edit screens
		add_action('do_meta_boxes', array( &$this, 'add_metabox') );

		//Save the metabox code with the post
		add_action( 'save_post', array( &$this, 'save_walkme_code' ) );
	}

	private function __clone(){
    }

    
    private function __wakeup(){
    }

    /*
	 * Enqueue the WalkMe javascript
	 *
	 * @since 1.0
	 **/
	public function walkme_script() {
		global $post;

		wp_enqueue_script('walkme', plugin_dir_url( __FILE__ ) . '/js/walkme.js', null, null , true );

		// Pass walkme code to javascript
		$walkme_code = get_post_meta( $post->ID, 'walkme_code');
		wp_localize_script( 'walkme', 'walkme_code', $walkme_code );
	}

	/*
	 * Adds the metabox to post and page edit screens 
	 *
	 * @since 1.0
	 **/
	public function add_metabox() {

		$post_types = array('post', 'page');
		$post_types = apply_filters('walkme_post_types', $post_types );

		add_meta_box('walkme_code', __('Walk Me Code', 'walkme'), array( &$this, 'insert_walkme_form'), array() );
	}

	/**
	 * Saves the metabox data with the walkme code
	 *
	 * @param WP_Post $post The object for the current post/page.
	 * @since 1.0
	 */
	public function insert_walkme_form( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'walkme_metabox', 'walkme_metabox_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, 'walkme_code', true );

		echo '<label for="walkme_code">';
		_e( 'Insert your WalkMe Code', 'walkme' );
		echo '</label> ';
		echo '<input type="text" id="walkme_code" name="walkme_code" value="' . esc_attr( $value ) . '" size="25" />';
	
	}

	/**
	 * When the post is saved, saves the walkme code.
	 *
	 * @param int $post_id The ID of the post being saved.
	 * @since 1.0
	 */
	function save_walkme_code( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['walkme_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['walkme_metabox_nonce'], 'walkme_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['walkme_code'] ) ) {
			return;
		}

		// Sanitize user input.
		$walkme_code = sanitize_text_field( $_POST['walkme_code'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, 'walkme_code', $walkme_code );
	}
	
}

$walkme = WalkMe::get_instance();