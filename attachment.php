<?php get_header(); ?>

<?php while( have_posts() ): the_post(); ?>


	<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
		<img  class='featured' src="<?php echo $att_image[0];?>" />
	<?php else : ?>
		<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
	<?php endif; ?>


<?php endwhile;?>

<?php get_footer(); ?>