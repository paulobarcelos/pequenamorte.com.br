<?php get_header();?>
<section class="intro-module">
	<div class="row">
		<article class="standard-article col-8">
			<?php
			// Get the registration page
			$post = get_post( get_option( 'owc_registration_thanks_page' ) );
			setup_postdata( $post );

			$deadline = get_option( 'owc_publish_date' );

			?>
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>

		</article>
		<div class="next-deadline col-4">
			<div><?php _e('Announcement', 'owc');?></div>
			<div class="date"><?php echo mysql2date( 'd', $deadline ); ?></div>
			<div><?php echo mysql2date( 'F', $deadline ); ?></div>
		</div>

	</div>
</section>
<?php get_footer(); ?>