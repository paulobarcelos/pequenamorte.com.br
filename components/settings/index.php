<?php get_header();

// Get the settings page
$post = get_post( get_option( 'owc_user_settings_page' ) );
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
	'phone' => __( 'Please fill in your phone number.', 'owc' ),
	'street' => __( 'Please fill in your street address.', 'owc' ),
	'zip_code' => __( 'Please fill in your zip  code.', 'owc' ),
	'city' => __( 'Please fill in your city.', 'owc' ),
	'country' => __( 'Please fill in your country.', 'owc' ),
	'current_password' => __( 'The old password doesn\'t match.', 'owc' ),
	'password' => __( 'Please fill in your new password.', 'owc' ),
	'password_repeat' => __( 'The password doesn\'t match.', 'owc' )
);	
?>

<form action="<?php owc_component_url( 'settings', 'save' ); ?>" method="post" class="row profile-form">
	<div class="col-8">
		<h2><?php _e( 'Settings', 'owc' ); ?></h2>
		
		<?php if ( $message ) : ?>
			<div class="message"><p><?php echo $message; ?></p></div>
		<?php endif; ?>

		<div class="registration-progress">
			<?php owc_form_display_error_messages('settings', $error_messages);?>
		</div>
	</div>

	<div class="col-8">
		<?php wp_nonce_field( 'settings' ); ?>		

		<fieldset class="public">
			<label>
				<span class="input-title"><?php _e( 'First name', 'owc' ); ?>*</span>
				<input id="s_first_name" type="text" name="s_first_name" value="<?php owc_user_data( 'first_name' ); ?>" required>
				<?php owc_form_display_error_message( 'settings', 'first_name', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Last name', 'owc' ); ?>*</span>
				<input id="s_last_name" type="text" name="s_last_name" value="<?php owc_user_data( 'last_name' ); ?>" required>
				<?php owc_form_display_error_message( 'settings', 'last_name', $error_messages );?> 
			</label>

			<fieldset id="upload-area" data-plupload-options='{
				"max_file_size":"5mb",
				"max_nof_files":"1",
				"resize":"{width : 250, height : 250, quality : 90}",
				"url":"<?php owc_component_url( 'settings', 'profile-pic' ); ?>"
			}'>
				<span class="input-title"><?php _e('Profile picture', 'owc');?></span>
				<div class="file-upload profile-picture">
					<div class="image-preview" id="upload-preview">
						<?php if ( owc_user_get_data( 'photo' ) != '' ) : ?>
							<?php
							$photo =  owc_user_get_data( 'photo' ) ;
							$photo_val = json_encode($photo) ;
							?>

							<img src="<?php echo esc_attr( $photo['src_thumb'] ); ?>">
							<input type="hidden" name="s_photo" value="<?php echo esc_attr( $photo_val ); ?>">
						<?php else : ?>
							<img src="<?php bloginfo( 'template_directory' ); ?>/img/mysteryhen.png">
						<?php endif; ?>
					</div>
					<p class="lead"><?php _e( 'Make your profile more interesting and help us remember you when selecting finalists!', 'owc' ); ?></p>
					<a class="button" id="upload-button" href="#"><?php _e( 'Upload picture', 'owc' ); ?></a>
					<small><?php _e( 'Requirements: a <b>.jpg</b> file with a maximum file-size of <b>5 Mb</b>.<br>The picture will be cropped to <b>250 x 250</b> px if bigger.', 'owc' ); ?></small>
				</div>
				<?php owc_form_display_error_message( 'settings', 'photo', $error_messages );?> 
			</fieldset>

			<label>
				<span class="input-title"><?php _e( 'Nationality', 'owc' ); ?>*</span>
				<select id="s_nationality" name="s_nationality" required >
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_user_get_data( 'nationality' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'settings', 'nationality', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Type of Education', 'owc' ); ?></span>
				<input id="s_education" type="text" name="s_education" placholder="<?php _e('Eg. Industrial design', 'owc');?>" value="<?php owc_user_data( 'education' ); ?>">
				<?php owc_form_display_error_message( 'settings', 'education', $error_messages );?> 
			</label>


			<label>
				<span class="input-title"><?php _e( 'University', 'owc' ); ?>*</span>
				<input id="s_university" type="text" name="s_university" placholder="<?php _e('Type in the name of your University', 'owc');?>" value="<?php owc_user_data( 'university' ); ?>" required >
				<?php owc_form_display_error_message( 'settings', 'university', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Country of University', 'owc' ); ?>*</span>
				<select id="s_university_country" name="s_university_country" required >
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_user_get_data( 'university_country' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'settings', 'university_country', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Short Presentation', 'owc' ); ?><small><?php _e( '(maximum 250 characters)', 'owc' ); ?></small></span>
				<textarea id="s_presentation" type="text" name="s_presentation" placholder="<?php _e('A short presentation of you, for your public profile', 'owc');?>" ><?php owc_user_data( 'presentation' ); ?></textarea>
				<?php owc_form_display_error_message( 'settings', 'presentation', $error_messages );?> 
			</label>
		</fieldset>

		<fieldset class="private">
			<label>
				<span class="input-title"><?php _e( 'Email', 'owc' ); ?></span>
				<input id="s_email" type="email" name="" value="<?php owc_user_data( 'user_email' ); ?>" disabled>
			</label>


			<label>
				<span class="input-title"><?php _e( 'Phone Number', 'owc' ); ?>* <small><?php _e( '(full number including country and area code)', 'owc' ); ?></small></span>
				<input id="s_phone" type="text" name="s_phone" value="<?php owc_user_data( 'phone' ); ?>" required>
				<?php owc_form_display_error_message( 'settings', 'phone', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'Street Address', 'owc' ); ?>*</span>
				<input id="s_street" type="text" name="s_street" value="<?php owc_user_data( 'street' ); ?>" required>
				<?php owc_form_display_error_message( 'settings', 'street', $error_messages );?> 
			</label>
			<div class="row">
				<div class="col-3">
					<label>
						<span class="input-title"><?php _e( 'Zip Code', 'owc' ); ?>*</span>
						<input id="s_zip_code" type="text" name="s_zip_code" value="<?php owc_user_data( 'zip_code' ); ?>" required>
						<?php owc_form_display_error_message( 'settings', 'zip_code', $error_messages );?> 
					</label>
				</div>
				<div class="col-5">
					<label>
						<span class="input-title"><?php _e( 'City', 'owc' ); ?>*</span>
						<input id="s_city" type="text" name="s_city" value="<?php owc_user_data( 'city' ); ?>" required>
						<?php owc_form_display_error_message( 'settings', 'city', $error_messages );?> 
					</label>
				</div>
			</div>

			<label>
				<span class="input-title"><?php _e( 'State / Province', 'owc' ); ?></span>
				<input id="s_state" type="text" name="s_state" value="<?php owc_user_data( 'state' ); ?>">
				<?php owc_form_display_error_message( 'settings', 'state', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Country', 'owc' ); ?>*</span>
				<select id="s_country" name="s_country" required>
					<option value=""><?php _e( 'Choose Country', 'owc' ); ?></option>
					<?php foreach( owc_countries() as $id => $country_arr ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( owc_user_get_data( 'country' ), esc_attr( $id ) ); ?>><?php echo esc_attr( $country_arr['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php owc_form_display_error_message( 'settings', 'country', $error_messages );?> 
			</label>

			<h2><?php _e('Change Password', 'owc');?></h2>

			<label>
				<span class="input-title"><?php _e( 'Old password', 'owc' ); ?></span>
				<input id="s_current_password" type="password" name="s_current_password" class="<?php owc_form_error_class('settings', 'current_password');?>">
				<?php owc_form_display_error_message( 'settings', 'current_password', $error_messages );?> 
			</label>

			<label>
				<span class="input-title"><?php _e( 'New password', 'owc' ); ?></span>
				<input id="s_password" type="password" name="s_password" class="<?php owc_form_error_class('settings', 'password');?>">
				<?php owc_form_display_error_message( 'settings', 'password', $error_messages );?> 
			</label>
			
			<label>
				<span class="input-title"><?php _e( 'Repeat new password', 'owc' ); ?></span>
				<input id="s_password_repeat" type="password" name="s_password_repeat" class="<?php owc_form_error_class('settings', 'password_repeat');?>">
				<?php owc_form_display_error_message( 'settings', 'password_repeat', $error_messages );?> 
			</label>
		</fieldset>

		<div class="registration-progress">
			<?php owc_form_display_error_messages('settings', $error_messages);?>
			<div class="submit">
				<input type="submit" value="<?php _e( 'Save Settings', 'owc' ); ?>">				
			</div>
		</div>
	</div>

	<aside class="col-4">
		<div class="standard-module profile-public-info">
			<h3 class="title"><i class="icon-public-info"></i> <?php echo esc_html( get_post_meta( get_the_ID(), 'help-title', true ) ); ?></h3>
			<p><?php echo esc_html( get_post_meta( get_the_ID(), 'help-text', true ) ); ?></p>
		</div>
	</aside>
</form>

<?php get_footer(); ?>