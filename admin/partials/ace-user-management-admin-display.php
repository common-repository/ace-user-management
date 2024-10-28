<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/admin/partials
 */
global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ace_register_fields ORDER BY sortby ASC ", OBJECT );
$get_meta = "";
		?>
  <div class="ace-reg-container">
  <!-- <div class="preview_style"><h1 class="Preview_title"> Preview <a class="awm-site_links-paypal" target="_blank" href="https://www.paypal.com/paypalme/acewebx">You Liked It ? Donation  <img class="paypal-svg" src="https://wordpress.web-xperts.xyz/wp-content/plugins/ace-social-chat/admin/images/icons-paypal.svg" alt="paypalicon"></a></h1>
</div> -->
    <h1 style="font-weight: 400; font-size: 23px; margin-left: 50px;" >Preview</h1>
    <div class="ace-reg-display">
        <h1 style="font-size: 22px; text-align: center;"><?php _e('Registration Form','ace-user-management'); ?></h1><br> 
            <div class="ace-reg-display-label">
                <label><?php _e( 'Username','ace-user-management'); ?></label><br>
                <input id="username" name="username" type="text" placeholder=<?php _e('Username','ace-user-management'); ?> disabled >
            </div>
            <div class="ace-reg-display-label">
            <label><?php _e( 'E-mail','ace-user-management'); ?></label><br>
             <input id="email" name="email" type="email"  placeholder=<?php _e('Email','ace-user-management'); ?> disabled >
            </div>
             <div class="ace-reg-display-label">
            <label><?php _e( 'Password','ace-user-management'); ?></label><br>
             <input id="password1" name="password" type="password"  placeholder=<?php _e('Password','ace-user-management'); ?>  disabled />
            </div>
             <div class="ace-reg-display-label">
            <label><?php _e( 'Confirm Password','ace-user-management'); ?></label><br>
             <input id="password2" name="c_password" type="text" placeholder=<?php _e('Confirm Password','ace-user-management'); ?>  disabled />
            </div>
    <?php
    	    foreach ( $results as $key => $value) { 
    	       	$dropdown_options =  explode(",", $value->dropdown_options);
    	    ?><div class="ace-reg-display-label">
		       	<label><?php echo ucfirst($value->input_label); ?></label><br>
		  <?php if($value->input_type == 'text'){ ?>
			        <input type="text" placeholder="<?php echo ucfirst($value->input_placeholder); ?>" name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" value=""  disabled />
		  <?php }
			    elseif ($value->input_type == 'textarea') { ?>
					<textarea placeholder="<?php echo ucfirst($value->input_placeholder ); ?>" name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" rows="2" cols="20" disabled ><?php echo $get_meta; ?></textarea><br>
          <?php }
        		elseif ($value->input_type == 'dropdown') { ?>
			       	<select name="<?php echo $value->input_name; ?>_" id="<?php echo $value->input_name; ?>" placeholder="<?php echo $value->input_placeholder; ?>" value="" disabled ><br> 
		  <?php 	foreach ($dropdown_options as $key => $val) {
            		$options = explode(":", $val);	?>
            		<option value="<?php echo $options[0]; ?>" > <?php echo $options[1]; ?></option>
			            	<?php	} ?>
			        </select> 
		  <?php } ?></div>
	 <?php } ?>
            <?php if( !empty( $recaptcha_keys['c_reCaptcha_value'] ) ){ if( $recaptcha_keys['c_reCaptcha_value'] == 1 ){ ?>
						<br>
						<div class="ace-recaptcha">
							<div class="g-recaptcha" data-sitekey="<?php  echo $recaptcha_keys['author_siteKey']; ?>" required ></div>			
						</div>
                        <br>
			<?php } } ?>
      <div class="ace-reg-display-label">
        <input type="submit" name="savelayout" value="<?php _e('Submit','ace-user-management'); ?>" class="btn btn-primary submit_btn save_btn" disabled>
      </div>
      <br>
    </div>
  </div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
