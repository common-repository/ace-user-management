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
<div class="ace-user_forget-form">
	<form name="mylostpasswordform" id="ace-mylostpasswordform" class="ace-mylostpasswordform" action="" method="post">
	    <div class="ace-form-label">
	        <label><?php _e('Username or E-mail:'); ?><br><br>
	        <input type="text" name="reset_password" value="" size="20" tabindex="10"></label>
	    </div><br>    
	    <input type="submit" name="reset-submit" class="ace-btn-rest-pass" id="rest-password" value="Get New Password">
	</form>
</div>