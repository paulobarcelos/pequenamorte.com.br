<?php get_template_part( 'page', 'header' ); ?>

<?php while( have_posts() ): the_post(); ?>

	<?php 
		$embed = get_post_meta(get_the_ID(), 'embed');
		
		foreach ($embed as $code): if($code):
	?>
		<div class="embed">
			<?php 
				$oembed = wp_oembed_get($code);
				if($oembed) echo $oembed;
				else echo $code;
			?>
		</div>
	<?php endif; endforeach; ?>

	<?php the_post_thumbnail( 'large', array('class' => 'featured') ); ?>

	<h1><?php the_title(); ?></h1>
	<div class="content">
		<?php the_content(); ?>
	</div>

<?php endwhile;?>

<?php get_template_part( 'page', 'footer' ); ?>