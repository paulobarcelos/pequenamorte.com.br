<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class OWC {
	var $components = array();
	var $component;
	var $current_action;
	var $action_variables;
	var $title;
	var $user;
	var $profile;
	var $uri;
	
	function __construct() {
		global $wpdb;

		add_action( 'init', array( $this, 'register_globals' ), 5 );
		add_action( 'init', array( $this, 'init_components' ), 9 );
		add_action( 'init', array( $this, 'init' ), 10 );
		add_action( 'init', array( $this, 'catch_uri' ), 15 );
		
		add_action( 'template_redirect', array( $this, 'template_redirect' ), 5 );
		
		add_filter( 'wp_title', array( $this, 'wp_title' ), 10, 2 );
		add_action( 'wp_head', array( $this, 'open_graph' ) );
		add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

		add_filter('body_class', array( $this, 'body_class' ) );

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp', array( $this, 'remove_header_tags' ) );

		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

		add_action( 'wp_authenticate', array( $this, 'email_login' ) );

		add_action( 'after_switch_theme', array( $this, 'add_roles' ) );
	}
	
	/* Actions */

	function after_setup_theme() {
		add_theme_support( 'post-thumbnails' );

		/*add_image_size( 'featured', 300, 200, true );
		add_image_size( 'idea-940x530', 940, 530, true );*/
	}

	function register_menus() {
		register_nav_menus( array(
			'main' => 'Main',
			'shows' => 'Shows',
			'social' => 'Social',
			'extra' => 'Extra'
		) );
	}

	function enqueue_scripts() {

	}

	function remove_header_tags() {
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	}

	function open_graph() {
		
		$extra = '';
		$image = get_bloginfo('template_directory') . '/img/fb.jpg';
		$type = 'website';
		$uri = 'http' . (isset ($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		if( is_home() ){
			$title = get_bloginfo('name');
			$description = get_bloginfo('description');
		}
		if ( is_single() || is_page() ) {
			$title = get_the_title();
			$description = owc_get_the_excerpt();
		}

		if ( ( is_single()  || is_page() )&& has_post_thumbnail() ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
			
			if ( isset($thumb[0]) && ! empty( $thumb[0] ) )
				$image = $thumb[0];
		}

		if ( ! empty ( $title ) )
			echo '<meta property="og:title" content="' . esc_attr( $title ) . '">';

		if ( ! empty ( $description ) ){
			echo '<meta property="og:description" content="' . esc_attr( $description ) . '">';
			echo '<meta name="description" content="' . esc_attr( $description ) . '">';
		}

		if ( ! empty ( $image ) )
			echo '<meta property="og:image" content="' . esc_attr( $image ) . '">';

		if ( ! empty ( $type ) )
			echo '<meta property="og:type" content="' . esc_attr( $type ) . '">';

		echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '">';

		echo '<meta property="og:url" content="' . esc_attr( $uri ) . '">';
	}

	function wp_head() {
		echo stripslashes( get_option( 'head_extras' ) );
	}
	function wp_footer() {
		echo stripslashes( get_option( 'footer_extras' ) );
	}

	function body_class($classes){

		// Add index of this page in relation to main menu
		$items = wp_get_nav_menu_items( 'main' );
		_wp_menu_item_classes_by_context($items);

		$relation = array('order' => 0, 'kind' => 'none' );
		foreach ($items as $item) {
			if( $relation['kind'] != 'current' 
				&& $relation['kind'] != 'parent' 
				&& in_array('current-page-ancestor', $item->classes)){
				
				$relation['kind'] = 'ancestor';
				$relation['order'] = $item->menu_order;
			}

			if( $relation['kind'] != 'current' 
				&& in_array('current-page-parent', $item->classes)){
				
				$relation['kind'] = 'parent';
				$relation['order'] = $item->menu_order;
			}

			if( in_array('current-menu-item', $item->classes)){
				
				$relation['kind'] = 'current';
				$relation['order'] = $item->menu_order;
			}
		}

		$classes[] = 'main-menu-order-' . $relation['order'];
		$classes[] = 'main-menu-relation-' . $relation['kind'];
		$classes[] = 'main-menu-mod-two-' . (($relation['order']) ? ($relation['order'] % 2 + 1) : 0);
		$classes[] = 'main-menu-mod-three-' . (($relation['order']) ? ($relation['order'] % 3 + 1) : 0);
		$classes[] = 'main-menu-mod-four-' . (($relation['order']) ? ($relation['order'] % 4 + 1) : 0);
		$classes[] = 'main-menu-mod-five-' . (($relation['order']) ? ($relation['order'] % 5 + 1) : 0);


		return $classes;
	}
	
	function register_globals() {
		global $current_user;
		
		if ( is_user_logged_in() )
			$this->user = $current_user;
	}

	function register_sidebars() {
	}

	function register_widgets() {
		/* Include all the widgets */
		foreach ( glob( OWC_INCLUDES . '/widgets/*.php' ) as $filename ) {
			require_once( $filename );
			
			$widget = basename( $filename, '.php' );
			
			register_widget( $widget );
		}
	}

	function add_roles() {

	}
	
	function init_components() {
		do_action( 'owc_init_components' );
	}
	
	function init() {
		do_action( 'owc_init' );
	}
	
	function catch_uri() {
		if ( is_admin() ) { return; }
		
		$uri = $_SERVER['REQUEST_URI'];
		$uri = str_replace( '?' . $_SERVER['QUERY_STRING'], '', $uri );
		$uri = split( '/', $uri );
		$uri = array_values( array_filter( $uri ) );

		if(!is_main_site()) array_shift($uri);
		
		$this->uri = $uri;
		
		if ( empty($uri) ) { return; } // No URL set? End function
		
		do_action( 'owc_catch_uri' );
		
		$component_slug = apply_filters( 'owc_component_slug', $uri[0] );
		$component_slugs = owc_get_components_slugs();
		
		$this->current_action = apply_filters( 'owc_current_action', isset( $uri[1] ) ? $uri[1] : '', $uri );
		$this->action_variables = apply_filters( 'owc_action_variables', array_slice( $uri, 2 ), $uri );
		
		if ( in_array( $component_slug, $component_slugs ) ) {
			
			$component = owc_get_component_by_slug( $component_slug );
			
			$this->component = $component;
			
			if ( method_exists( $component, 'callback' ) ) {
				call_user_method( 'callback', $component );
			}
		}
	}
	
	function template_redirect() {
		global $wp_query;
		
		do_action( 'owc_template_redirect' );
		
		if ( ! empty ( $this->component->template_file ) ) {
			
			$located_template = locate_template( array( $this->component->template_file . '.php' ), false );
			
			if ( ! empty ( $located_template ) ) {
				// Prevent WordPress from trying to find a page with similar name or show 404, and load template
				status_header( 200 );
				
				$wp_query->is_404  = false;

				remove_action( 'template_redirect', 'redirect_canonical' );
				
				$this->located_template = $located_template;
				
				add_filter( 'template_include', array( $this, 'template_include' ) );
			}
		}
	}

	function template_include( $template ) {
		return $this->located_template;
	}

	function email_login( $username ) {
		$user = get_user_by( 'email', $username );
		
		if ( ! empty( $user->user_login ) )
			$username = $user->user_login;
		
		return $username;
	}
	
	/* Filters */
	
	function wp_title( $title, $sep ) {
		if ( isset( $this->component->title ) && ! empty ( $this->component->title ) )
			$title = $this->component->title . ' ' . $sep . ' ';
		
		return $title;
	}
	
	/* Business */
	
	function register_component( $component ) {
		$this->components[ $component->name ] = $component;
	}
}
?>