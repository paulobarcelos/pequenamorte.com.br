<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* Action Variables */

function owc_get_action_variable( $index ) {
	global $owc;

	if ( isset( $owc->action_variables[$index] ) )
		return $owc->action_variables[$index];

	return false;
}

function owc_get_current_action() {
	global $owc;

	if ( ! isset( $owc->current_action ) )
		return '';

	return $owc->current_action;
}

/* Components */

function owc_is_component( $component_name ) {
	global $owc;

	if ( ! $owc->component )
		return false;
	
	return  $owc->component->name === $component_name;
}

function owc_component_url( $component_name, $path = false ) {
	echo owc_get_component_url( $component_name, $path );
}

function owc_get_component_url( $component_name, $path = false ) {
	global $owc;

	$component = owc_get_component_by_name( $component_name );

	if ( ! $component )
		return home_url();
	
	return $component->get_url( $path );
}

function owc_get_component_by_name( $component_name ) {
	global $owc;

	foreach( $owc->components as $component ) {
		if ( $component->name == $component_name )
			return $component;
	}

	return false;
}

function owc_get_component_by_slug( $component_slug ) {
	global $owc;

	foreach( $owc->components as $component ) {
		if ( $component->slug == $component_slug )
			return $component;
	}

	return false;
}

function owc_get_components_slugs() {
	global $owc;

	$components = array();

	foreach( $owc->components as $component ) {
		$components[] = $component->slug;
	}

	return $components;
}

/* Single */
function owc_get_the_excerpt($id=false) {
	global $post;

	$old_post = $post;
	if ($id != $post->ID) {
		$post = get_page($id);
	}

	if (!$excerpt = trim($post->post_excerpt)) {
		$excerpt = $post->post_content;
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');

		$words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$excerpt = implode(' ', $words);
			$excerpt = $excerpt . $excerpt_more;
		} else {
			$excerpt = implode(' ', $words);
		}
	}

	$post = $old_post;

	return $excerpt;
}
?>