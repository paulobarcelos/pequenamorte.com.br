<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class OWC_Component {
	var $name = '';
	var $slug = '';
	var $title = '';
	var $template_file = '';
	
	function __construct() {
		if ( empty ( $this->template_file ) )
			$this->template_file = 'components/' . $this->name . '/index';
		
		if ( empty ( $this->title ) )
			$this->title = __( ucwords( $this->name ), 'owc' );
		
		add_action( 'owc_init', array( $this, 'register_component' ) );

		add_action( 'owc_template_redirect', array( $this, '_template_redirect' ) );

		add_filter( 'body_class', array( $this, 'body_class' ) );
	}
	
	function register_component() {
		global $owc;
		
		$owc->register_component( $this );
	}
	
	function _template_redirect() {
		global $owc;

		if ( $owc->component && method_exists( $this, 'template_redirect' ) && $owc->component->name == $this->name )
			call_user_method( 'template_redirect', $this );
	}

	function body_class( $class ) {
		global $owc;
		
		if ( owc_is_component( $this->name ) )
			$class[] = $this->name;
		
		$action = owc_get_current_action();

		if ( owc_is_component( $this->name ) && ! empty( $action ) )
			$class[] = $this->name . '-' . $action;

		return $class;
	}
	
	function url( $path = false ) {
		echo $this->get_url($path);
	}
	
	function get_url( $path = false ) {
		return home_url( trailingslashit( $this->slug . ( $path ? '/' . $path : '' ) ) );
	}
}
?>