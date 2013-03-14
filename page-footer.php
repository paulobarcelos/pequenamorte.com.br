<?php
	# if there are siblings, find previous and next
	if($post->post_parent){
		$siblings = get_pages(array(
			'child_of' => $post->post_parent
		));
		if(count($siblings) > 1) {
			foreach ($siblings as $index => $sibling) {
				if($sibling->ID == $post->ID){
					$previous_index = $index - 1;
					$next_index = $index + 1;

					$previous_index = ($previous_index < 0) ? count($siblings) - 1 : $previous_index;
					$next_index = ($next_index >= count($siblings) ) ? 0 : $next_index;

					$previous = $siblings[$previous_index];
					$next = $siblings[$next_index];
				}
			}
		}
	}

?>
<?php if(isset($next) || isset($previous)) : ?>
	<nav class="siblings-nav">
	<?php if(isset($previous)) : ?>
		<a class="previous ir" href="<?php echo get_post_permalink($previous); ?>"><?php echo $previous->post_title;?></a>
	<?php endif;?>
	<?php if(isset($next)) : ?>
		<a class="next ir" href="<?php echo get_post_permalink($next); ?>"><?php echo $next->post_title;?></a>
	<?php endif;?>
	</nav>
<?php endif;?>

<?php get_footer(); ?>