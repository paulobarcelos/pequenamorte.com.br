<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/style.css">
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php bloginfo( 'template_directory' ); ?>/img/favicon.ico">
	<script src="<?php bloginfo( 'template_directory' ); ?>/js/libs/modernizr-2.6.2.min.js"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<article class="main">
		<div class="outer">
			<div class="inner">