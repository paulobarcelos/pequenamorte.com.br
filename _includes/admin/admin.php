<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class OWC_Admin {
	function __construct() {
		require_once( 'screen-general.php');

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );		
		add_action( 'admin_init', array( $this, 'add_meta_boxes' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		add_action( 'admin_init', array( $this, 'prevent_admin' ) );
	}

	function prevent_admin() {
		if ( is_admin() && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}
	function admin_menu() {
		add_menu_page( __( 'Admin', 'owc' ), __( 'Admin', 'owc' ), 'manage_options', 'owc', 'owc_admin_screen_general', false, 100 );
		add_submenu_page( 'owc', __( 'General', 'owc' ), __( 'General', 'owc' ), 'manage_options', 'owc', 'owc_admin_screen_general' );
	}

	function add_meta_boxes() {
		if ( ! class_exists( 'RW_Meta_Box' ) )
			return;


		// General Pages
		/*$meta_box = array(
			'id'		=> 'general_meta',
			'title'		=> __( 'Additional text', 'owc' ),
			'pages'		=> array( 'page' ),
			'context'	=> 'normal',
			'priority'	=> 'high',
			'fields'	=> array(
				array(
					'name'	=> __( 'Help Title', 'owc' ),
					'id'	=> 'help-title',
					'type'	=> 'text'
				),
				array(
					'name'	=> __( 'Help Text', 'owc' ),
					'id'	=> 'help-text',
					'type'	=> 'textarea',
					'rows'	=> 6
				),
				array(
					'name'	=> __( 'Icon', 'owc' ),
					'id'	=> 'help-icon',
					'type'	=> 'select',
					'options'	=> array(
						''								=> __( 'None', 'owc' ),
						'icon-submission-public'		=> __( 'Triangle', 'owc' ),
						'icon-submission-exclamation'	=> __( 'Exclamation', 'owc' ),
						'icon-submission-question'		=> __( 'Question', 'owc' )
					)
				)
			)
		);
		new RW_Meta_Box( $meta_box );*/


	}




	function enqueue_scripts( $hook ) {
		wp_enqueue_script( 'owc-admin', get_bloginfo( 'template_url' ) . '/_includes/admin/admin.js', false, false, true );
	}

	function enqueue_styles() {
		wp_enqueue_style( 'owc-admin', get_bloginfo( 'template_url' ) . '/_includes/admin/admin.css' );
	}

}
$owc_admin = new OWC_Admin();
?>