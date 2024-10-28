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
<?php 

if ( is_user_logged_in() ) {
   
    //ob_clean(); // Clean the output buffer
    echo "<script>window.location.href = '" . home_url() . "';</script>";
   
    
   
}
    if(isset($error)){ ?>
        <div class="ace-error">
                    <div class="ace-all-error">
        <?php 
            $dot = "*";
                foreach ( $error as $error_show) { ?>
                    <?php print_r($dot);
                    echo "&nbsp&nbsp   ";
                    print_r($error_show); ?>
               <?php }
        ?>
        </div>
        </div>        
<?php    
    }
	$recaptcha_keys = get_option('custom_reCapatcha_value');
	if ( isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
	   $captcha = sanitize_text_field( $_POST['g-recaptcha-response'] );
	   $secretKey = '<?php  echo $recaptcha_keys["author_reCap_secertkey"]; ?>';
	   $remoteip = $_SERVER['REMOTE_ADDR'];
	   $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $remoteip);
		$responseKeys = json_decode($response, true);
	        if (intval($responseKeys["success"]) !== 1) {
	            return "failed";
	        } else {
	            return "success";
	        }
	} 
?>
	<div class="ace-add_user_outer">
        <center><h1 style="font-size: 22px;"><?php _e('Add User Form','ace-user-management'); ?></h1></center><br> 
        <form  name="form" id="add_user"  method="post" action="" class="ace-registration-form">
            <div class="ace-form-label">
                <label><?php _e('Username','ace-user-management'); ?></label><br>
                <input id="username" name="username" type="text" value="<?php echo $username; ?>" placeholder="<?php _e('Username','ace-user-management'); ?>" >
            </div>
            <div class="ace-form-label">
            <label><?php _e('E-mail','ace-user-management'); ?></label><br>
             <input id="email" name="email" type="email"  value="<?php echo $email; ?>" placeholder="<?php _e('Email','ace-user-management'); ?>" >
            </div>
             <div class="ace-form-label">
            <label><?php _e('Password','ace-user-management'); ?></label><br>
             <input id="password1" name="password" type="password"  placeholder="<?php _e('Password','ace-user-management'); ?>" />
            </div>
             <div class="ace-form-label">
            <label><?php _e('Confirm Password','ace-user-management'); ?></label><br>
             <input id="password2" name="c_password" type="text" placeholder="<?php _e('Confirm Password','ace-user-management'); ?>" />
            </div>
    <?php
    	    foreach ( $results as $key => $value) { 
    	       	$dropdown_options =  explode(",", $value->dropdown_options);
    	    ?><div class="ace-form-label">
		       	<label><?php echo ucfirst($value->input_label); ?></label><br>
		  <?php if($value->input_type == 'text'){ ?>
			        <input type="text" placeholder="<?php echo ucfirst($value->input_placeholder); ?>" name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" value="" />
		  <?php }
			    elseif ($value->input_type == 'textarea') { ?>
					<textarea placeholder="<?php echo $value->input_placeholder; ?>" name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" rows="2" cols="20"><?php echo $get_meta; ?></textarea><br>
          <?php }
        		elseif ($value->input_type == 'dropdown') { ?>
			       	<select name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" placeholder="<?php echo $value->input_placeholder; ?>" value=""><br> 
		  <?php 	foreach ($dropdown_options as $key => $val) {
            		$options = explode(":", $val);	?>
            		<option value="<?php echo $options[0]; ?>" > <?php echo $options[1]; ?></option>
			            	<?php	} ?>
			        </select> 
		  <?php } ?></div>
	 <?php } ?>
            <?php if (is_array($recaptcha_keys) && isset($recaptcha_keys['c_reCaptcha_value']) && $recaptcha_keys['c_reCaptcha_value'] == 1) { ?>
						<br>
						<div class="ace-recaptcha">
							<div class="g-recaptcha" data-sitekey="<?php  echo $recaptcha_keys['author_siteKey']; ?>" required ></div>			
						</div>
                        <br>
			<?php } ?>
            <br>
            <input type="submit" name='submit' value="<?php _e('Submit','ace-user-management'); ?>" class="ace-reg-submit">
        </form>
    </div>