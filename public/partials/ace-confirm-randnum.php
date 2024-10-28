<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/public/partials
 */
$css_by_option = "";
$css_by_option = get_option( 'ace_custom_css_plugin' );
?>
<style>
  <?php echo $css_by_option;  ?>

</style>
<div class="ace-user_confrim_pass">
	<form action="" method="post" class="ace-confrim-pass">
		<div class="ace-form-label">
			<label><?php _e('Password','ace-user-management'); ?></label>
			<input type="password" name="password" class="ace-new-password" >
		</div>
		<div class="ace-form-label">
			<label><?php _e('Confirm Password','ace-user-management'); ?></label>
			<input type="text" name="confirm_password" class="ace-confirm-password" >
		</div>
		<div class="ace-form-label" style="float: right;">
				<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
				<input type="submit" name="submit_password" class="ace-btn-cfm-pas" value="<?php _e('Submit','ace-user-management'); ?>">
		</div>
	</form>
</div>