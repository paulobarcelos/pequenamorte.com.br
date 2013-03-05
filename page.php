<?php get_header(); ?>

<?php the_post_thumbnail( 'large', array('class' => 'featured') ); ?>

<h1><?php the_title(); ?></h1>
<div class="content">
	<?php echo wpautop($post->post_content); ?>
</div>

<?php get_footer(); ?>