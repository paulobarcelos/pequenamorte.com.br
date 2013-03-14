<?php get_header(); the_post(); ?>
<?php 
	$stages = get_terms('stage', array(
		'hide_empty' => false,
		'orderby' => 'slug',
		'order' => 'asc'
	));

	$qualified_stages = wp_get_post_terms(
		$post->ID, 
		'stage',
		array(
			'orderby' => 'slug',
			'order' => 'desc'
		)
	);
	$qualified_stages_ids = array();

	foreach ($qualified_stages as $qualified_stage) {
		$qualified_stages_ids[] = $qualified_stage->term_id;
	}

	$score = owc_get_submission_vote_score();

?>

<section class="contestant-profile row">
	<div class="col-12">
		<h1><?php the_title(); ?></h1>
		<hr>
	</div>

	<aside class="col-4">
		<div class="application-details">
			<dl>
				<dt><i class="icon-qualify"></i> <?php _e('Qualified to stage', 'owc');?></dt>
				<dd class="stage-markers">
					<?php foreach ($stages as $stage):?>
						<span class="<?php echo (in_array($stage->term_id, $qualified_stages_ids)) ? 'marked' : '';?>"><?php owc_stage_index($stage);?></span>
					<?php endforeach;?>
				</dd>

				<dt><i class="icon-votes"></i> <?php _e('Votes', 'owc');?></dt>
				<dd class="vote-number"><?php echo $score->votes;?></dd>

				<dt><i class="icon-ranking"></i> <?php _e('Ranking', 'owc');?></dt>
				<dd class="ranking-number"><?php echo $score->ranking;?></dd>

				<dt><i class="icon-comments"></i> <?php _e('Comments', 'owc');?></dt>
				<dd class="comment-number"><?php comments_number( '0', '1', '% ' ); ?></dd>
			</dl>


			<?php if( owc_can_vote_submission() ):?> 

				<div class="vote-info">
					<i class="icon-submission-exclamation"></i>
					<strong><?php _e('Make sure this project qualifies for the next stage. Vote!', 'owc');?></strong>
				</div>
				<button class="profile-vote" data-submission="<?php echo $post->ID;?>" data-thanks="<?php _e('Thanks!', 'owc');?>"><?php _e('Press to vote!', 'owc');?></button>

			<?php else:?>

				<button class="profile-vote"><?php _e('Thanks!', 'owc');?></button>

			<?php endif;?>
			
			
		</div>

		<div class="vote-thanks <?php echo (owc_can_vote_submission()) ? 'hide':''?>">
			<?php _e('Support my work and like me on Facebook as well!', 'owc');?>
			<div class="fb-like" data-href="<?php the_permalink();?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="lucida grande"></div>
		</div>

		<?php $user_data = get_userdata($post->post_author ); ?>
		<div class="contestant-details ribbon-wrapper" data-ribbon="<?php _e('The creator','owc');?>">
			<?php $photo = get_user_meta( $post->post_author, 'photo', true ) ?>
			<img alt="<?php echo esc_attr ( $user_data->data->display_name ); ?>" src="<?php echo esc_attr( $photo['src'] ); ?>">
			
			<h2 class="title"><?php echo esc_attr ( $user_data->data->display_name ); ?></h2>

			<?php $education = get_user_meta( $post->post_author, 'education', true ); ?>
			<?php $university = get_user_meta( $post->post_author, 'university', true ); ?>
			<?php $university_country = owc_country( esc_attr ( get_user_meta( $post->post_author, 'university_country', true ) ) ); ?>
			<span class="details"><?php echo (($education) ? sprintf('%s, ', esc_attr($education)) : '') . sprintf('%s, %s', $university, $university_country); ?></span>
			
			<?php echo wpautop( esc_attr( get_user_meta( $post->post_author, 'presentation', true ) ) ); ?>

			<a href="#main-content" class="blog-anchor"><?php _e('Read my development blog', 'owc');?></a>
		</div>

		<?php owc_share_module(array('title' => __('Share my profile', 'owc')),true);?>

	</aside>

	<section class="application-content col-8">
		<?php foreach ($qualified_stages as $stage):?>

			<article class="standard-article">

				<?php $index = owc_get_stage_index($stage);?>
				<h3><span class="application-stage"><?php echo $index;?></span> <?php owc_stage_name($stage);?></h3>

				<?php
					$description = get_post_meta( $post->ID, 'stage' . $index . '_description', true );
					echo apply_filters('owc_submission_content', $description);
				?>

				<div class="wp-caption">
					<div class="slideshow">
						<ul class="slides">	
							<?php $images = get_post_meta( $post->ID, 'stage' . $index . '_images', true ); $images = $images ? $images : array(); ?>
							<?php foreach ( $images as $image_id ) : ?>
								<?php 
									$image_src = wp_get_attachment_image_src( $image_id, 'idea-940x530' );
									$image_full_src = wp_get_attachment_image_src( $image_id, 'full' );
								?>
								<li><img alt="<?php echo get_the_title() . ' - ' . $stage->name; ?>" src="<?php echo esc_attr( $image_src[0] ); ?>" data-hires="<?php echo esc_attr( $image_full_src[0] ); ?>" /></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

			</article>

			<?php
				# hack in a "stage" hidden field to use as the comment type
				comment_form(array(
					'comment_notes_after' => '<input type="hidden" name="stage" value="' . $index  . '">'
				));
			?>
			<section class="application-comments">
				<?php 
					$comments = get_comments(array(
						'post_type' => 'submission',
						'type' => 'stage'. $index,
						'count' => false
					));
				?> 

				<h4 class="title"><?php echo sprintf(__('Comments on this stage (%s)', 'owc'), count($comments));?></h4>
				<a href="#" class="write-comment" data-toggle="Cancel"><?php _e('Write a comment', 'owc');?></a>
				

				<ol class="commentlist">
					<?php 
						wp_list_comments(array(
							'callback' => 'owc_comment'
						), $comments);?>
					
					<li class="comment expert">
						<article>
							<header class="comment-meta comment-author vcard">
								<img alt="" src="http://0.gravatar.com/avatar/?d=http://designlabs.dev/en/wp-content/themes/electrolux-dev/img/mysteryhen.png&amp;s=50" class="avatar avatar-50 photo avatar-default" height="50" width="50"><cite class="fn"><a href="http://designlabs.dev/" rel="external nofollow" class="url">Mr WordPress</a> wrote:</cite>
								<a href="http://designlabs.dev/en/2013/02/11/hello-world/#comment-1" class="date"><time datetime="2013-02-11T11:23:12+00:00">3 hours ago</time></a>
							</header>
							<section class="comment-content">
								<p>Hi, this is a comment.<br>
								To delete a comment, just log in and view the post's comments. There you will have the option to edit or delete them.</p>
							</section>
						</article>
					</li>

					<li class="comment">
						<article>
							<header class="comment-meta comment-author vcard">
								<img alt="" src="http://0.gravatar.com/avatar/?d=http://designlabs.dev/en/wp-content/themes/electrolux-dev/img/mysteryhen.png&amp;s=50" class="avatar avatar-50 photo avatar-default" height="50" width="50"><cite class="fn"><a href="http://designlabs.dev/" rel="external nofollow" class="url">Mr WordPress</a> wrote:</cite>
								<a href="http://designlabs.dev/en/2013/02/11/hello-world/#comment-1" class="date"><time datetime="2013-02-11T11:23:12+00:00">11:42 yesterday</time></a>
							</header>
							<section class="comment-content">
								<p>Hi, this is a comment.<br>
								To delete a comment, just log in and view the post's comments. There you will have the option to edit or delete them.</p>
							</section>
						</article>
					</li>
				</ol>
				<a href="#" class="load-comments" data-start="5">Load more comments (12)</a>
			</section>

		<?php endforeach;?>
		
	</section>
	<hr class="col-12 ruler">
</section>

<?php get_footer(); ?>