<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function owc_admin_screen_general() {

	if ( isset( $_POST['submit'] ) && check_admin_referer( 'general-settings' ) ) {
			
		update_option( 'head_extras', $_POST['head_extras'] );
		update_option( 'footer_extras', $_POST['footer_extras'] );

	}
	?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"><br></div>
		<h2><?php _e( 'Settings', 'owc' ); ?></h2>
		<form action="" method="post">
			<?php wp_nonce_field( 'general-settings' ); ?>

			<h3><?php _e( 'Extras', 'owc' ); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th><?php _e( 'Head', 'owc' ); ?></th>
					<td>
						<textarea name="head_extras" class="large-text code" rows="6"><?php echo stripslashes( get_option( 'head_extras' ) ); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th><?php _e( 'Footer', 'owc' ); ?></th>
					<td>
						<textarea name="footer_extras" class="large-text code" rows="6"><?php echo stripslashes( get_option( 'footer_extras' ) ); ?></textarea>
					</td>
				</tr>
			</table>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'owc' ); ?>"></p>
		</form>
	</div>
<?php 
}
?>