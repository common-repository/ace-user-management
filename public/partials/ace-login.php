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
global $post; 
$css_by_option = "";
$css_by_option = get_option( 'ace_custom_css_plugin' );
?>
<head>
	<style type="text/css">
		<?php echo $css_by_option;  ?>

	</style>
</head>
	<div class="ace-user_login-form">
	<?php
	if ( is_user_logged_in() ) {
		echo "<script>window.location.href = '" . home_url() . "';</script>";
	}
	$recaptcha_keys = get_option('custom_reCapatcha_value');
	$login_error = get_permalink( $post->ID );
	 if( isset($_GET['login']) && $_GET['login'] == 'failed' ){ ?>
				<div class="ace-login-failed"><?php echo "!"." "."Username and password incorrect"; ?></div>		
	<?php  } ?>
	<?php if( isset($_GET['login']) && $_GET['login'] == 'empty'){ ?>
				<div class="ace-login-empty"><?php echo  "!"." "."Please fill all fields" ; ?></center></div>
	<?php  } ?>

	<form class="ace-login-form" id="ace-login-form" method="post" action="<?php echo site_url()?>/wp-login.php">	
		<div class="ace-form-label">
			<label><?php _e('Username','ace-user-management'); ?></label>
			<input type="text" name="log" placeholder="Enter username">
		</div>
		<div class="ace-form-label">
			<label><?php _e('Password','ace-user-management'); ?></label>
			<input  type="password" name="pwd"  placeholder="Enter password">
		</div>
		<div class="ace-form-label">
			<input type="checkbox" name="remember-me"><label><?php _e( 'Remember me','ace-user-management'); ?></label>
				<a href="<?php echo get_permalink( $post->ID ).'?forget-password'; ?>" class="ace-forget-pass">
				<?php _e('Forgot Password','ace-user-management').'?'; ?>
			</a>
		</div>
		<?php if (is_array($recaptchaKeys) && isset($recaptchaKeys['c_reCaptcha_value']) && $recaptchaKeys['c_reCaptcha_value'] == 1){ ?>
				<div class="ace-form-label">
					<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_keys['author_siteKey']; ?>" required ></div>			
				</div>
		<?php } ?>
		<div class="ace-form-label">
			<input type="submit" name="wp-submit" value="<?php _e('Login'); ?>" class="ace-login-btn">
			<input type="hidden" name="redirect_to" value="<?php echo site_url()?>">
		</div>
	</form>
	</div>