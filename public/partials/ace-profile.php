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
global $wpdb, $user_ID;
$current_user = new WP_User( get_current_user_id() );
$current_user = wp_get_current_user(); 
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ace_register_fields ORDER BY sortby ASC ", OBJECT );
		if( isset($_POST['submit'] ) ){
			$password     = ( !empty($_POST['password'] ) ) ? sanitize_text_field( $_POST['password'] ) : '' ;
			$confirm_pass = ( !empty($_POST['confirm_password'] ) ) ? sanitize_text_field( $_POST['confirm_password'] ) : '' ;
			foreach ($_POST as $post_keys => $post_values) {
			}
			if( $post_keys != ''){
				unset($_POST['password']);
				unset($_POST['confirm_password']);
				unset($_POST['submit']);
				$update_detail = Ace_User_Management_Function::sanitize($_POST );
				$myNewArray = array_combine(
									array_map(function($key){ return $key.'_'; }, 
									array_keys($update_detail)),
									$update_detail
								);
					if(update_user_meta( $current_user->ID , 'user_extrafields' ,$myNewArray ) == TRUE){		
						foreach ($_POST as $key => $update_user ) {

							update_user_meta( $current_user->ID, $key, sanitize_text_field($update_user) );
						}
					 $success  =   "&nbsp".__('Successfull Update','ace-user-management');
					}
			} else {
				$error['empty_field'] 	=  __('Field empty','ace-user-management');
			}
			if( strcmp($password, $confirm_pass ) == 0 ){
					if( !empty( $password ) && !empty( $confirm_pass )){
						$password = md5( $password );
						$tableName = $wpdb->prefix.'users';
						$update_pass = $wpdb->query("UPDATE $tableName SET user_pass = '$password' WHERE ID =$user_ID");
						echo "<div class='ace-all-success'>Your Passwod Change</div><br>";		
					}
			} else {
				$error['same_password'] = __('Password not match','ace-user-management');
			}		
		}
		$user_extrafields_value = get_user_meta( $current_user->ID, 'user_extrafields', true );
		if(isset( $error ) ){
			foreach ($error as $value) { ?>
				<div class="ace-all-error"><?php print_r($value); ?></div>
			<?php }
		}
		if( isset( $success ) ){ ?>
		<div class="ace-all-success"><?php echo $success; ?></div>
		<?php } 
		if( isset( $faild ) ){ ?>
				<div class="ace-all-error"><?php echo $faild; ?></div>
		<?php } ?>
		<div class="ace-add_user_profile">		
		<form method="post" action="" class="ace-profile-form">
			<div class="ace-form-label">
								<label><?php _e('Email','ace-user-management'); ?></label>
								<input type="text" value="<?php echo $current_user->user_email; ?>" disabled="disabled">
							</div>
							<div class="ace-form-label"> 
								<label><?php _e('Username','ace-user-management'); ?></label>
								<input type="text" value="<?php echo $current_user->user_login; ?>" disabled="disabled">
							</div>
							<div class="ace-form-label">
								<label><?php _e('Password','ace-user-management'); ?></label>
								<input type="password" name="password" class="ace-profile-password" value="">
							</div>
							<div class="ace-form-label">
								<label><?php _e('Confirm Password','ace-user-management'); ?></label>
								<input type="text" name="confirm_password" class="ace-profile-confirm-password" value=""> 
							</div>
	     <?php  foreach ( $results as $key => $value ) { 
		        	$dropdown_options =  explode(",", $value->dropdown_options);

		        		$iVal = $user_extrafields_value[$value->input_name."_"];      	
		        	?>	<div class="ace-form-label">
		            		<label><?php echo ucfirst($value->input_label ); ?></label>
		            		<?php if($value->input_type == 'text'){ ?>
				                <input type="text" placeholder="<?php echo ucfirst($value->input_placeholder); ?>" name="<?php echo $value->input_name; ?>" id="<?php echo $value->input_name; ?>" value="<?php echo $iVal; ?>" required/>
				            <?php }
				            elseif ($value->input_type == 'textarea') { ?>
								<textarea placeholder="<?php echo ucfirst($value->input_placeholder); ?>" name="<?php echo $value->input_name; ?>" id="<?php echo $value->input_name; ?>" rows="2" cols="20" required><?php echo $get_meta; ?></textarea>
	        				<?php }
	        				elseif ($value->input_type == 'dropdown') {  ?>
				            	<select name="<?php echo $value->input_name; ?>" id="<?php echo $value->input_name; ?>" placeholder="<?php echo $value->input_placeholder; ?>" value="" required> 
				            		<?php 
				            		foreach ($dropdown_options as $key => $val) {
				            			$options = explode(":", $val);
				            			print_r( $options[0] );
				            			?>
				            			<option value="<?php echo $options[0]; ?>" <?php if($iVal==$options[0]) echo 'selected';?>  > <?php echo $options[1]; ?></option>
				            	<?php	} ?>
				            	</select> 
				            <?php } ?></div>
	    <?php  } ?>		
							<button type="submit" name="submit"  class="ace-update-btn ace-form-label"><?php _e('Update','ace-user-management'); ?></button>	
		</form>
	</div>
