<?php
	# if there is no content, try to redirect to the first child
	if(!$post->post_content){
		$children = get_pages(array(
			'child_of' => $post->ID
		));
		if(count($children)){
			wp_redirect(get_post_permalink($children[0]));
			exit;
		}
	}
?>
<?php get_header(); ?>
