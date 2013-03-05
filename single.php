
<?php get_header(); ?>
<section class="row">
	<aside class="blog-sidebar col-4">
		<h1 class="title"><?php the_title(); ?></h1>
		<?php the_content(); ?>

		<nav class="categories">
			<h3><?php _e( 'Categories', 'owc' ); ?></h3>
			<ul>
				<li><a href="<?php owc_component_url( 'design-blog' ); ?>"><?php _e( 'View all', 'owc' ); ?></a></li>
				<?php wp_list_categories( 'title_li=' ); ?>
			</ul>
		</nav>
	</aside>
	<div class="blog-main col-8" id="main-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="standard-article">
				<header class="post-details">
					<?php the_date('Y-m-d', '<span>', '</span>'); ?> |
					<a href="<?php the_permalink(); ?>#comments" class="comments"><?php comments_number(); ?></a>
					<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="lucida grande"></div>
					<!--<a href="#" class="back">&larr; <?php _e( 'Back to profile', 'owc' ); ?></a>-->
				</header>

				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
		<hr>
		<?php comments_template(); ?>
	</div>
</section>
<?php get_footer(); ?>