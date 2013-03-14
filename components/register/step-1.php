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
	'first_name' => __( 'Please fill in your first name.', 'owc' ),
	'last_name' => __( 'Please fill in your last name', 'owc' ),
	'nationality' => __( 'Please fill in your nationality.', 'owc' ),
	'university' => __( 'Please fill in your university.', 'owc' ),
	'university_country' => __( 'Please fill in your university country.', 'owc' ),
	'email' => __( 'Please fill in your email.', 'owc' ),
	'email_repeat' => __( 'The email you\'ve entered doesn\'t match.', 'owc' ),
	'phone' => __( 'Please fill in your phone number.', 'owc' ),
	'street' => __( 'Please fill in your street address.', 'owc' ),
	'zip_code' => __( 'Please fill in your zip  code.', 'owc' ),
	'city' => __( 'Please fill in your city.', 'owc' ),
	'country' => __( 'Please fill in your country.', 'owc' ),
	'password' => __( 'Please fill in your password.', 'owc' ),
	'password_repeat' => __( 'The password you\'ve entered doesn\'t match.', 'owc' ),
	'terms' => __( 'You haven\'t read and agreed to Terms and Conditions.', 'owc' )
);	
?>
<section class="intro-module">
	<div class="row">
		<article class="standard-article col-8">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
		</article>
		<?php
			$deadline = get_option( 'owc_deadline_s1_end' );
 		?>
		<div class="next-deadline col-4">
			<div><?php _e('Deadline', 'owc');?></div>
			<div class="date"><?php echo mysql2date( 'd', $deadline ); ?></div>
			<div><?php echo mysql2date( 'F', $deadline ); ?></div>
		</div>

	</div>
</section>

<form action="<?php owc_component_url( 'register', 'step-1/save' ); ?>" method="post" class="row profile-form">
	<div class="col-8">
		<h2><?php _e( 'Registration', 'owc' ); ?></h2>

		<?php if ( $message ) : ?>
			<div class="input-error system-error"><p><?php echo $message; ?></p></div>
		<?php endif; ?>

		<div class="registration-progress">
			<ol class="steps">
				<li class="current">
					<h3><?php _e( 'Personal info', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Personal details', 'owc' ); ?></li>
						<li><?php _e( 'Profile picture', 'owc' ); ?></li>
						<li><?php _e( 'Education', 'owc' ); ?></li>
						<li><?php _e( 'Contact information ', 'owc' ); ?></li>
						<li><?php _e( 'Create a password', 'owc' ); ?></li>
					</ul>
				</li>
				<li>
					<h3><?php _e( 'Idea submission', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Title', 'owc' ); ?></li>
						<li><?php _e( 'Description', 'owc' ); ?></li>
						<li><?php _e( 'Sketches / pictures', 'owc' ); ?></li>
					</ul>
				</li>
			</ol>
			<?php owc_form_display_error_messages('step-1', $error_messages);?>
		</div>
	</div>

	<div class="col-8">
		<?php wp_nonce_field( 'step-1' ); ?>

		<fieldset class="public">
			<div class="public-info standard-module">
				<i class="icon-eye-blue"></i>
				This information will be visible if you are qualified!
			</div>
			<label>
				<span class="input-title"><?php _e( 'First name', 'owc' ); ?>*</span>
				<input id="reg_first_name" type="text" name="reg_first_name" value="<?php owc_form_value( 'step-1', 'first_name' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'first_name', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Last name', 'owc' ); ?>*</span>
				<input id="reg_last_name" type="text" name="reg_last_name" value="<?php owc_form_value( 'step-1', 'last_name' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'last_name', $error_messages );?> 
			</label>

			<fieldset id="upload-area" data-plupload-options='{
				"max_file_size":"5mb",
				"max_nof_files":"1",
				"resize":"{width : 250, height : 250, quality : 90}",
				"url":"<?php owc_component_url( 'register', 'profile-pic' ); ?>"
			}'>
				<span class="input-title"><?php _e('Profile picture', 'owc');?></span>
				<div class="file-upload profile-picture">
					<div class="image-preview" id="upload-preview">
						<?php if ( owc_get_form_value( 'step-1', 'photo' ) != '' ) : ?>
							<?php
							$photo_val = stripslashes( owc_get_form_value( 'step-1', 'photo' ) );
							$photo = (array)json_decode( $photo_val );
							?>

							<img src="<?php echo esc_attr( $photo['src_thumb'] ); ?>">
							<input type="hidden" name="reg_photo" value="<?php echo esc_attr( $photo_val ); ?>">
						<?php else : ?>
							<img src="<?php bloginfo( 'template_directory' ); ?>/img/mysteryhen.png">
						<?php endif; ?>
					</div>
					<p class="lead"><?php _e( 'Make your profile more interesting and help us remember you when selecting finalists!', 'owc' ); ?></p>
					<a class="button" id="upload-button" href="#"><?php _e( 'Upload picture', 'owc' ); ?></a>
					<small><?php _e( 'Requirements: a <b>.jpg</b> file with a maximum file-size of <b>5 Mb</b>.<br>The picture must be at least <b>250 x 250</b>. The picture will be cropped if bigger.', 'owc' ); ?></small>
				</div>
			</fieldset>

			<label>
				<span class="input-title"><?php _e( 'Country of citizenship', 'owc' ); ?>*</span>
				<select id="reg_nationality" name="reg_nationality" required>
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_get_form_value( 'step-1', 'nationality' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'step-1', 'nationality', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Type of Education', 'owc' ); ?></span>
				<input id="reg_education" type="text" name="reg_education" placholder="<?php _e('Eg. Industrial design', 'owc');?>" value="<?php owc_form_value( 'step-1', 'education' ); ?>">
				<?php owc_form_display_error_message( 'step-1', 'education', $error_messages );?> 
			</label>


			<label>
				<span class="input-title"><?php _e( 'University', 'owc' ); ?>*</span>
				<input id="reg_university" type="text" name="reg_university" placholder="<?php _e('Type in the name of your University', 'owc');?>" value="<?php owc_form_value( 'step-1', 'university' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'university', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Country of University', 'owc' ); ?>*</span>
				<select id="reg_university_country" name="reg_university_country" required>
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_get_form_value( 'step-1', 'university_country' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'step-1', 'university_country', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Short Presentation', 'owc' ); ?><small><?php _e( '(maximum 250 characters)', 'owc' ); ?></small></span>
				<textarea id="reg_presentation" type="text" name="reg_presentation" placholder="<?php _e('A short presentation of you, for your public profile', 'owc');?>" maxlength="250"><?php owc_form_value( 'step-1', 'presentation' ); ?></textarea>
				<?php owc_form_display_error_message( 'step-1', 'presentation', $error_messages );?> 
			</label>
		</fieldset>

		<fieldset class="private">
			<label>
				<span class="input-title"><?php _e( 'Email', 'owc' ); ?>*</span>
				<input id="reg_email" type="email" name="reg_email" value="<?php owc_form_value( 'step-1', 'email' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'email', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Repeat Email', 'owc' ); ?>*</span>
				<input id="reg_email_repeat" type="email" name="reg_email_repeat" value="<?php owc_form_value( 'step-1', 'email_repeat' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'email_repeat', $error_messages );?> 
			</label>


			<label>
				<span class="input-title"><?php _e( 'Phone Number', 'owc' ); ?>* <small><?php _e( '(full number including country and area code)', 'owc' ); ?></small></span>
				<input id="reg_phone" type="text" name="reg_phone" value="<?php owc_form_value( 'step-1', 'phone' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'phone', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Street Address', 'owc' ); ?>*</span>
				<input id="reg_street" type="text" name="reg_street" value="<?php owc_form_value( 'step-1', 'street' ); ?>" required>
				<?php owc_form_display_error_message( 'step-1', 'street', $error_messages );?> 
			</label>
			<div class="row">
				<div class="col-3">
					<label>
						<span class="input-title"><?php _e( 'Zip Code', 'owc' ); ?>*</span>
						<input id="reg_zip_code" type="text" name="reg_zip_code" value="<?php owc_form_value( 'step-1', 'zip_code' ); ?>" required>
						<?php owc_form_display_error_message( 'step-1', 'zip_code', $error_messages );?> 
					</label>
				</div>
				<div class="col-5">
					<label>
						<span class="input-title"><?php _e( 'City', 'owc' ); ?>*</span>
						<input id="reg_city" type="text" name="reg_city" value="<?php owc_form_value( 'step-1', 'city' ); ?>" required>
						<?php owc_form_display_error_message( 'step-1', 'city', $error_messages );?> 
					</label>
				</div>
			</div>

			<label>
				<span class="input-title"><?php _e( 'State / Province', 'owc' ); ?></span>
				<input id="reg_state" type="text" name="reg_state" value="<?php owc_form_value( 'step-1', 'state' ); ?>">
				<?php owc_form_display_error_message( 'step-1', 'state', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Country', 'owc' ); ?>*</span>
				<select id="reg_country" name="reg_country" required>
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_get_form_value( 'step-1', 'country' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'step-1', 'country', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Choose a password', 'owc' ); ?>* <small><?php _e( '(you will need a password if your work is selected)', 'owc' ); ?></small></span>
				<input id="reg_password" type="password" name="reg_password" required>
				<?php owc_form_display_error_message( 'step-1', 'password', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Repeat password', 'owc' ); ?>*</span>
				<input id="reg_password_repeat" type="password" name="reg_password_repeat" required>
				<?php owc_form_display_error_message( 'step-1', 'password_repeat', $error_messages );?> 
			</label>
		</fieldset>
		<div class="registration-progress">
			<ol class="steps">
				<li class="current">
					<h3><?php _e( 'Personal info', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Personal details', 'owc' ); ?></li>
						<li><?php _e( 'Profile picture', 'owc' ); ?></li>
						<li><?php _e( 'Education', 'owc' ); ?></li>
						<li><?php _e( 'Contact information ', 'owc' ); ?></li>
						<li><?php _e( 'Create a password', 'owc' ); ?></li>
					</ul>
				</li>
				<li>
					<h3><?php _e( 'Idea submission', 'owc' ); ?></h3>
					<ul>
						<li><?php _e( 'Title', 'owc' ); ?></li>
						<li><?php _e( 'Description', 'owc' ); ?></li>
						<li><?php _e( 'Sketches / pictures', 'owc' ); ?></li>
					</ul>
				</li>
			</ol>

			<?php owc_form_display_error_messages('step-1', $error_messages);?>

			<div class="submit">
				<label class="terms<?php echo owc_form_has_error( 'step-1', 'terms' ) ? ' error' : ''; ?>">
					<input type="checkbox" value="1" name="reg_terms" <?php checked( owc_get_form_value( 'step-1', 'terms' ), 1 ); ?> required> <span><?php printf( __( 'I have read and agreed to <a href="%s" target="_blank" data-lightbox="%s #main-content">Terms and Conditions</a>', 'owc' ), get_permalink( get_option('owc_terms_page') ), get_permalink( get_option('owc_terms_page') ) ); ?></span>
					<?php owc_form_display_error_message( 'step-1', 'terms', $error_messages );?> 
				</label>
				<input type="submit" value="<?php _e( 'Next step', 'owc' ); ?>">				
			</div>
		</div>
	</div>
<?php /*
	<aside class="col-4">
		<div class="standard-module profile-public-info">
			<h3 class="title"><i class="icon-public-info"></i> <?php echo esc_html( get_post_meta( get_the_ID(), 'help-title', true ) ); ?></h3>
			<p><?php echo esc_html( get_post_meta( get_the_ID(), 'help-text', true ) ); ?></p>
		</div>
	</aside>
*/ ?>
</form>
<?php get_footer(); ?>