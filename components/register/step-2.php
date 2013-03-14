<?php get_header();

// Get the registration page
$post = get_post( get_option( 'owc_registration_page' ) );
setup_postdata( $post );

wp_enqueue_script( 'plupload-all', array( 'jquery-ui-sortable', 'wp-ajax-response' ), true );

$message = '';

if ( isset( $_GET['message'] ) ) {
	switch ( (int)$_GET['message'] ) {
		case 1 :
			$message = __( 'Settings updated', 'owc' );
			break;
		case 2 :
			#$message = __( 'Please fill in all the required fields', 'owc' );
			break;
		case 3 :
			$message = __( 'An error occured, please try again', 'owc' );
			break;
		case 'existing_user_email' :
			$message = __( 'The e-mail you supplied is already in use', 'owc' );
			break;
	}
}

$error_messages = array(
	'title'				=> __( 'Please fill in the idea title.', 'owc' ),
	'theme'				=> __( 'Please choose the idea theme.', 'owc' ),
	'categories'		=> __( 'You need to choose at least one category.', 'owc' ),
	'brief_description'	=> __( 'Please fill in the idea brief description. Maximum 150 characters!', 'owc' ),
	'description' 		=> __( 'Please fill in the idea full description. Maximum 650 characters!', 'owc' ),
	'images'			=> __( 'Please upload images for your idea', 'owc' )
);	
?>
<div class="row">
	<div class="col-8">
		<h2><?php _e( 'Registration', 'owc' ); ?></h2>

		<?php if ( $message ) : ?>
			<div class="message"><p><?php echo $message; ?></p></div>
		<?php endif; ?>

		<div class="registration-progress">
			<ol class="steps">
				<li>
					<h3><?php _e( 'Personal info', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Personal details', 'owc' ); ?></li>
						<li><?php _e( 'Profile picture', 'owc' ); ?></li>
						<li><?php _e( 'Education', 'owc' ); ?></li>
						<li><?php _e( 'Contact information ', 'owc' ); ?></li>
						<li><?php _e( 'Create a password', 'owc' ); ?></li>
					</ul>
				</li>
				<li class="current">
					<h3><?php _e( 'Idea submission', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Title', 'owc' ); ?></li>
						<li><?php _e( 'Description', 'owc' ); ?></li>
						<li><?php _e( 'Sketches / pictures', 'owc' ); ?></li>
					</ul>
				</li>
			</ol>
			<?php owc_form_display_error_messages('step-2', $error_messages);?>
		</div>
	</div>
</div>

<form action="<?php owc_component_url( 'register', 'step-2/save' ); ?>" method="post" class="row submission-form">
	<div class="col-8">
		<?php wp_nonce_field( 'step-2' ); ?>
		
		<?php $submission_id = get_user_meta( owc_user_id(), 'submission_id', true ); ?>

		<div>
			<label>
				<span class="input-title"><?php _e( 'Project Title', 'owc' ); ?>*</span>
				<input type="text" name="idea_title" value="<?php owc_form_value( 'step-2', 'title' ); ?>" required>
				<?php owc_form_display_error_message( 'step-2', 'title', $error_messages );?> 
			</label>

			<span class="input-title"><?php _e( 'Categories', 'owc' ); ?>* <small><?php _e( '(You can choose several categories)', 'owc' ); ?></small></span>	
			<div class="checkboxes">		
				<?php 
					$categories = get_terms('submission_category', array('hide_empty' => false));
					$session_categories = owc_get_form_value( 'step-2', 'categories' );
					$session_categories = ($session_categories) ? $session_categories : array()
				?>
				<?php foreach( $categories as $category ) : ?>
					<label>	
						<input type="checkbox" name="idea_categories[]" value="<?php echo esc_attr( $category->term_id ); ?>" <?php if (in_array($category->term_id, $session_categories)):?>checked="checked"<?php endif;?> />
						<span><?php echo esc_attr( $category->name ); ?></span>
					</label>
				<?php endforeach; ?>
				<?php owc_form_display_error_message( 'step-2', 'categories', $error_messages );?> 
			</div>

			<label>
				<span class="input-title"><?php _e( 'Theme', 'owc' ); ?>*</span>
				<select id="idea_theme" name="idea_theme" required>
					<option value=""><?php _e( 'Choose Theme', 'owc' ); ?></option>
					<?php $themes = get_terms('theme', array('hide_empty' => false));?>
					<?php foreach( $themes as $theme ) : ?>
						<option value="<?php echo esc_attr( $theme->term_id ); ?>" <?php selected( owc_get_form_value( 'step-2', 'theme' ), esc_attr( $theme->term_id ) ); ?>><?php echo esc_attr( $theme->name ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'step-2', 'theme', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Brief description', 'owc' ); ?>* <small><?php _e( '(Maximum of 150 characters)', 'owc' ); ?></small></span>
				<textarea name="idea_brief_description" cols="40" maxlength="150" rows="2" required><?php owc_form_value( 'step-2', 'brief_description' ); ?></textarea>
				<?php owc_form_display_error_message( 'step-2', 'brief_description', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Full description', 'owc' ); ?>* <small><?php _e( '(Maximum of 1500 characters)', 'owc' ); ?></small></span>
				<textarea name="idea_description" cols="40" rows="4" maxlength="1500" required><?php owc_form_value( 'step-2', 'description' ); ?></textarea>
				<?php owc_form_display_error_message( 'step-2', 'description', $error_messages );?> 
			</label>

			<div id="upload-area" data-plupload-options='{
				"max_file_size":"5mb",
				"max_nof_files":"2",
				"max_nof_previews" : "2",
				"resize":"{width : 940, height : 530, quality : 90}",
				"url":"<?php echo wp_nonce_url( add_query_arg( array( 'submission_id' => $submission_id ), owc_get_component_url( 'register', 'submission-pic' ) ), 'upload-' . $submission_id ); ?>",
				"append": "true"
			}'>
				<span class="input-title"><?php _e( 'Project pictures', 'owc' ); ?> <small><?php _e( '(You can add 2 pictures to your project)', 'owc' ); ?> <!--<a href="#"><?php _e( 'View example', 'owc' ); ?></a>--></small></span>
				<div class="file-upload project-pictures">
					<div class="image-preview" id="upload-preview">
						<?php $images = get_post_meta( $submission_id, 'stage1_images', true ); $images = $images ? $images : array(); ?>
						<?php $image_index = 0; ?>
						<?php foreach ( $images as $image_id ) : ?>
							<?php $image_src = wp_get_attachment_image_src( $image_id, 'idea-940x530' ); ?>
							<div class="image-wrapper">
								<img src="<?php echo esc_attr( $image_src[0] ); ?>">
								<input type="hidden" name="idea_images[]" value="<?php echo esc_attr( $image_id ); ?>">
								<a class="button delete-button" href="#"><?php _e( 'Delete picture', 'owc' ); ?></a>
							</div>
							<?php $image_index++; if($image_index >= 2) break; ?>
						<?php endforeach; ?>
					</div>
					<a class="button" style="<?php echo (count($images) >= 2)? 'display: none;' : ''?>" id="upload-button" href="#"><?php _e( 'Upload pictures', 'owc' ); ?></a>
					<small><?php _e( 'The pictures have to be in the format <b>.jpg</b> with the maximum file-size<br> of <b>5 Mb</b>. They will be cropped to the size of <b>940 x 530 px</b> if bigger.', 'owc' ); ?></small>
				</div>
				<?php owc_form_display_error_message( 'step-2', 'images', $error_messages );?> 
			</div>

		</div>

		<div class="registration-progress">
			<ol class="steps">
				<li>
					<h3><?php _e( 'Personal info', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Personal details', 'owc' ); ?></li>
						<li><?php _e( 'Profile picture', 'owc' ); ?></li>
						<li><?php _e( 'Education', 'owc' ); ?></li>
						<li><?php _e( 'Contact information ', 'owc' ); ?></li>
						<li><?php _e( 'Create a password', 'owc' ); ?></li>
					</ul>
				</li>
				<li class="current">
					<h3><?php _e( 'Idea submission', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Title', 'owc' ); ?></li>
						<li><?php _e( 'Description', 'owc' ); ?></li>
						<li><?php _e( 'Sketches / pictures', 'owc' ); ?></li>
					</ul>
				</li>
			</ol>

			<?php owc_form_display_error_messages('step-2', $error_messages);?>

			<div class="submit">
				<span>Once you enter your work, you can not update the submission.</span>
				<input type="submit" value="<?php _e( 'Submit', 'owc' ); ?>" data-confirm="<?php _e( 'Are you sure you want to submit?', 'owc' ); ?>">				
			</div>
		</div>
	</div>

	<aside class="col-4">
		<div class="standard-module submission-sidebar-info">
			<?php $icon = get_post_meta( get_the_ID(), 'help-icon', true ); ?>
			<h3 class="title"><i class="<?php echo esc_attr( $icon ); ?>"></i> <?php echo esc_html( get_post_meta( get_the_ID(), 'help-title-2', true ) ); ?></h3>
			<p><?php echo esc_html( get_post_meta( get_the_ID(), 'help-text-2', true ) ); ?></p>
		</div>

		<?php
		/*
		<div class="standard-module submission-sidebar-info">
			<h3 class="title"><i class="icon-submission-exclamation"></i> <?php echo esc_html( get_post_meta( get_the_ID(), 'help-title', true ) ); ?></h3>
			<p><?php echo esc_html( get_post_meta( get_the_ID(), 'help-text', true ) ); ?></p>
		</div>

		<div class="standard-module submission-sidebar-info">
			<h3 class="title"><i class="icon-submission-question"></i> <?php echo esc_html( get_post_meta( get_the_ID(), 'help-title', true ) ); ?></h3>
			<p><?php echo esc_html( get_post_meta( get_the_ID(), 'help-text', true ) ); ?></p>
		</div>
		*/
		?>
	</aside>
</form>

<?php get_footer(); ?>