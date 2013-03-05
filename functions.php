<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Content width
define( 'OWC_PATH', dirname(__FILE__) );
define( 'OWC_INCLUDES', OWC_PATH . '/_includes' );
define( 'OWC_CONTENT_PATH', dirname( dirname( OWC_PATH ) ) );

// Meta Box definitions
define( 'RWMB_URL', get_bloginfo( 'template_url' ) . '/_includes/libs/meta-box/' );


// Load Classes
require_once( '_includes/classes/OWC.php' );
require_once( '_includes/classes/OWC_Component.php' );

// Load Libraries
require_once( '_includes/libs/meta-box/meta-box.php' );

// Load Components
// Load Functions
require_once( '_includes/core.php' );
require_once( '_includes/filters.php' );
require_once( '_includes/utils.php' );

// Load Admin
if ( in_array( $GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php') ) || is_admin() ) {
	require_once( '_includes/admin/admin.php' );
}

// Everything is loaded, boot it up!
$owc = new OWC();