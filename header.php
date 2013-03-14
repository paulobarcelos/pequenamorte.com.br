<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />	
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/style.css">
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php bloginfo( 'template_directory' ); ?>/img/favicon.ico">
	<script src="<?php bloginfo( 'template_directory' ); ?>/js/libs/modernizr-2.6.2.min.js"></script>
	<script> var websiteUrl = "<?php bloginfo('url');?>"; </script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

		<div class="outer">
			<div class="inner">