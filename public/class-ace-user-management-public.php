<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ace_User_Management
 * @subpackage Ace_User_Management/public
 * @author     Webbninja <webbninja2@gmail.com>
 */
class Ace_User_Management_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $pluginName    The ID of this plugin.
	 */
	private $pluginName;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $pluginName       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pluginName, $version ) {

		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function aceEnqueueStyles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ace_User_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ace_User_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->pluginName, plugin_dir_url( __FILE__ ) . 'css/ace-user-management-public.css', array(), $this->version, 'all' );
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function aceEnqueueScripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ace_User_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ace_User_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->pluginName, plugin_dir_url( __FILE__ ) .'js/ace-user-management-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'ajax-script', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->pluginName.'api', plugin_dir_url( __FILE__ ) . 'js/ace-api.js', array(), $this->version, 'all' );
		// wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
	}

	public function acePagesPermalink() {
		global $pagePermalink; 
			$pagePermalink = array(
				'login_permalink' => get_page_by_title('login'),
				'reg_permalink' => get_page_by_title('registration'),
				'profile_permalink' => get_page_by_title('profile'),
				'confirm_pass'  => get_page_by_title('Confirm Password')
			 );
	}

	public function aceShowAdminBarStatus(){ 
		if ( ! current_user_can( 'manage_options' ) ) {
	    show_admin_bar( false );
		}
	}

	// user logout 
	public	function aceCustomLogoutPage(){
		global $pagePermalink;
		//print_r($pagePermalink); 	
		// wp_redirect( site_url().$pagePermalink['login_permalink']->ID );
		wp_redirect( site_url('/').$pagePermalink['login_permalink']->post_name );
		exit;
	}

	function aceRegisterUrl($link){
		global $pagePermalink;
	    return str_replace(site_url('wp-login.php?action=register', 'login'),site_url().$pagePermalink['reg_permalink']->ID,$link);	
	}

	// login error
	public function aceMyLoginRedirect($redirect_to, $requested_redirect_to, $user) {
		global $pagePermalink;
		$loginPermalink = get_page_by_title( 'login' );
	    if (is_wp_error($user)) {
	    	if (isset($_POST['wp-submit'])) {
				// Your code here
	    	    wp_redirect( get_permalink($loginPermalink->ID)."?&login=failed" ); 
	     	}else{
	       	 	wp_redirect( get_permalink($loginPermalink->ID) ); 
	        }
	        exit;
	    }else{
	    	if( $user->roles[0] == 'administrator' ) {
	    		wp_redirect( site_url('/wp-admin'));
	    	}else {
	    		wp_redirect( site_url($pagePermalink['profile_permalink']->ID)	);
	    	}
	    }
	}

	public function aceCatchEmptyUser( $username, $pwd ) {
		$loginPermalink = get_page_by_title( 'login' );
		$recaptchaKeys = get_option('custom_reCapatcha_value');
		if( $recaptchaKeys['c_reCaptcha_value'] == 1  ){
		  	$recEmpty = empty($_POST['g-recaptcha-response']);
		  }
		// if( $_POST['wp-submit']){
		//   if ( empty( $username )  || empty($pwd))  {
		//     wp_redirect( get_permalink($loginPermalink->ID).'?&login=empty' );
		//     exit;
		//   }
		// } else {
		// 	wp_redirect( site_url() . "/login" ); 
		//     exit;
		// }
  	}

	// user custom profile page
	public function aceSubscriberLogin(){
		 global $current_user, $pagePermalink;
		get_currentuserinfo();
		if ( ! user_can( $current_user, "administrator" ) ) {
		 	//wp_redirect( site_url(). $pagePermalink['profile_permalink']->ID );
		 } 
	}

	public function aceLoginoutMenuLink( $items, $args ) {
		global $pagePermalink;
	   if ($args->theme_location == 'primary') {
	      if (is_user_logged_in()) {
	      	 $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink($pagePermalink['profile_permalink']->ID).'">'. __("Profile") .'</a></li>';
	         $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. wp_logout_url() .'">'. __("Log Out") .'</a></li>';
	      } else {
	        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink($pagePermalink['login_permalink']->ID).'">'. __("Log In") .'</a></li>';
	      	$items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink($pagePermalink['reg_permalink']->ID).'">'. __("Sign Up") .'</a></li>';
	      }
	   }
	   return $items;
	}
	
	// login and profile access
	public function aceRedirectToSpecificPage() {
		global $current_user, $pagePermalink;
		get_currentuserinfo();
		if ( ! user_can( $current_user, "administrator" ) ) {
			if ( is_user_logged_in()  ) {
				if ( is_page($pagePermalink['login_permalink']->ID))  {
					wp_redirect( get_permalink( $pagePermalink['profile_permalink']->ID ) ); 
					exit;
			    }
			    if ( is_page($pagePermalink['reg_permalink']->ID)) {
					wp_redirect( site_url() ); 
					exit;
			    }
			}else{
				if( is_page($pagePermalink['profile_permalink']->ID)) {
					wp_redirect( get_permalink($pagePermalink['login_permalink']->ID ) ) ; 
					exit;	
				}
			}
		}
	}

	public function acePageLoadActionHooks(){
		// custom profile page 
		function ace_subscriber_profile(){
			global $pagePermalink;
			if(current_user_can( 'manage_options' )) return ''; 
			if( strpos( site_url(), 'wp_admin/?action=reg.php' ) ){
				wp_redirect( get_permalink($pagePermalink['login_permalink']->ID ) );
				exit;
			}
		}
		function ace_user_profile_template(){
			require_once ( __DIR__ ). '/partials/ace-profile.php';				
		}
		add_shortcode('ace-profile-page', 'ace_user_profile_template');
		
		function ace_login_form(){
			ob_start();
			$loginPermalink = get_page_by_title( 'login' );
		    if( isset( $_GET['forget-password'] ) ){ 
		   	global $wpdb, $pagePermalink ;
				if(isset($_POST['reset-submit'])){
					$resetPassword = $wpdb->escape($_POST['reset_password']);
					$error 			= array();
					if(!empty($resetPassword)){
						if(is_email($resetPassword)){
							if(email_exists($resetPassword)){
									$user = get_user_by('email',$resetPassword);
									$userId 	=  $user->ID;
									$user_email =  sanitize_text_field( $user->user_email);
									$randomCode = str_shuffle( rand(10000,1000000) );
									$table_name = $wpdb->prefix."ace_reset_password" ;
									$wpdb->insert($table_name, 
												array(
												  "user_id" 	=> $userId,
												  "email"   	=> $resetPassword,
												  "randomCode"  => $randomCode )
											);							
									$to      = $resetPassword;
								    $subject = __('Lost Password','ace-user-management');
								    $message = get_permalink( $pagePermalink['confirm_pass']->ID)."?randNum=".$randomCode;
								    $headers = get_option('admin_email');		    
								    if( wp_mail( $to, $subject, $message, $headers )){ ?>
										<div class="ace-all-success"><?php _e('Please check you email for reset password','ace-user-management'); ?></div><br> 
									<?php exit;		
									} else { ?>
									<div class="ace-all-error"><?php _e('! Link not send','ace-user-management'); ?></div><br> 
							<?php	} 

							} else {
								$error['email_exists'] = __('! Email Not exists','ace-user-management');
							}
						} else {
							$error['email_validate'] = __('! Please enter a validate email','ace-user-management');
						}

					} else {
						$error['empty_email'] = __('! Please enter Email field','ace-user-management'); 
					}
					foreach ($error as $emailError) {
						 ?>
					<div class="ace-all-error"><?php print_r($emailError); ?></div><br> 
					<?php
					}
				}
				require_once ( __DIR__ ). '/partials/ace-forget-password.php';
				$wp_content = ob_get_clean();
				return $wp_content;
				?>
		   <?php
		    } else {
		      $recaptchaKeys = get_option('custom_reCapatcha_value');
			if ( isset( $_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
			   $captcha = $_POST['g-recaptcha-response']  ;
			   $secretKey = '<?php echo $recaptchaKeys["author_reCap_secertkey"] ?>';
			   $remoteip = $_SERVER['REMOTE_ADDR'];
			   $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $remoteip);
		    	$responseKeys = json_decode($response, true);
			        if (intval($responseKeys["success"]) !== 1) {
			            return "failed";
			        } else {
			            return "success";
			        }
		    }
		     	  $url = ( __DIR__ );
			require_once ( __DIR__ ). '/partials/ace-login.php';
			return ob_get_clean();
		    }
	 	}
		add_shortcode( 'ace-login-public-form', 'ace_login_form');
	
		function ace_confirm_code_page(){
			ob_start();
				global $wpdb;
				$getRandcode = (isset( $_GET['randNum'] ) ) ? sanitize_text_field( $_GET['randNum'] ) : '' ;
				$tablename = $wpdb->prefix."ace_reset_password";
				$sql = $wpdb->get_row( "SELECT * FROM $tablename WHERE randomCode = '$getRandcode'" );
				if( !empty( $sql->randomCode ) ){ 
					$userId = $sql->user_id;
					$error = array(); 
						$password = (isset( $_POST['password'] ) ) ? sanitize_text_field($_POST['password']) : '' ;
						$conPassword = (isset( $_POST['password'] ) ) ? sanitize_text_field($_POST['confirm_password']) : '' ;
						if(!empty($password)){
							if(strlen($password) > 4){
								if(!empty($conPassword)){
									if(strcmp($password, $conPassword) == 0){
										if(isset( $_POST['submit_password'])){
										
											 $user = intval($_POST['user_id']);
											 $password = md5($password);
											 $userTable = $wpdb->prefix.'users';
											 $update_pass = $wpdb->query("UPDATE $userTable SET user_pass = '$password' WHERE ID =$user");
												$wpdb->delete( $tablename, [ 'user_id' => $user] ); ?>
											<div class="ace-all-success"><?php _e('Password seccessfully update','ace-user-management'); ?></div>
								  <?php }
									} else {
										$error['confrim_password'] = __('! Confrim password not match','ace-user-management');
									}
								} else {
									$error['empty_password'] = __('! Please enter confrim password','ace-user-management');	
								}
							} else {
								$error['empty_password'] = __('! More than 5 character','ace-user-management');	
							}
						} else {
							$error['empty_password'] = __('! Please Enter  password','ace-user-management');
						}
						foreach ($error as $error_key => $errorValue) {
							?>
							<div class="ace-all-error"><?php print_r($errorValue); ?></div>
				  <?php }
					require_once ( __DIR__ ). '/partials/ace-confirm-randnum.php';
					} else {
						 _e('This link has been expired.','ace-user-management');
					}
					$wp_content = ob_get_clean();
					return $wp_content;		
		}
		add_shortcode( 'ace-random-code-page', 'ace_confirm_code_page' );

		if(!function_exists('ace_reg_form')){
	        function ace_reg_form(){
				ob_start();
	        	global $wpdb, $userID;
	        	$loginPermalink = get_page_by_title( 'login' );
	        	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ace_register_fields ORDER BY sortby ASC ", OBJECT );
		            $firstname='';
		            $lastname='';
		            $username='';
		            $email='';
			    if(isset( $_POST['submit'] )  && sanitize_text_field( $_POST['submit']) != ''){
		            $username = sanitize_text_field(  $_REQUEST['username'] );
		            $email = sanitize_text_field(  $_REQUEST['email']  );
		            $password = $wpdb->escape( sanitize_text_field( $_REQUEST['password']));
		            $c_password = sanitize_text_field($_POST['c_password']);
		            $reCaptcha = ( isset ($_POST['g-recaptcha-response'])) ? sanitize_text_field($_POST['g-recaptcha-response'] ) : '' ;
		            $error = array( );
		            $success ='';
			        if(!empty($username)){
			            if(username_exists($username)){
			                $error['username_exists'] = __('Username exists','ace-user-management');
			            }
			        }else{
			                $error['username_empty'] = __('Enter Username','ace-user-management');
			           }
			        if(!empty($email)){
			            if(is_email($email)){
			                if(email_exists($email)) {
			                    $error['email_exists'] = __('This email already exists','ace-user-management');
			                }
			            } else {
			                $error['email_valid'] = __('Enter valid email','ace-user-management');
			            }
			        } else {
			            $error['email_empty'] = __('Enter email','ace-user-management');
			        }
			        if(!empty($password)){
			            if(!empty($c_password)){
			                if(strcmp($password, $c_password) != 0){
			                $error['con_password'] =__('password not same','ace-user-management');
			            	}
			            }else{
			                $error['confirm_empty'] = __('Enter Confirm Password','ace-user-management');    
			            }
			        }else{
			            $error['password_empty'] = __('Enter Password','ace-user-management');
			        }
			        $recaptcha_v = get_option('custom_reCapatcha_value');
					if (is_array($recaptcha_v) && isset($recaptcha_v['c_reCaptcha_value']) && $recaptcha_v['c_reCaptcha_value'] == 1){
				        if( empty( $recaptcha_v ) ){
				        	$error['reCap'] = __('reCaptcha is not set','ace-user-management');
				        }
			    	}
			        if(empty($error)){
						$userId = wp_create_user( $username, $password, $email );
				        unset($_POST['username']);
					    unset($_POST['email']);
					    unset($_POST['password']);
					    unset($_POST['c_password']);
					    unset($_POST['submit']);
					    $userExtrafields = Ace_User_Management_Function::sanitize($_POST );
					 	update_user_meta( $userId, 'user_extrafields', $userExtrafields );
					 	$user_data = get_user_meta( $userId, 'user_extrafields', true );
					 	foreach ( $user_data as $userkey => $userValue ) {
							update_user_meta( $userId, $userkey , $userValue );
					 	} ?>
					 	<script>alert('You have successfully registered and logged in.');</script>
					 	<script>window.location = "<?php echo get_permalink( $loginPermalink->ID );?>"</script>
			  <?php }
			    }
	            require_once  plugin_dir_path( __FILE__ ). 'partials/ace-registration.php';
				$wp_content = ob_get_clean();
				return $wp_content;
	         }
	        add_shortcode( 'ace-registration-public-form', 'ace_reg_form');

	        function ace_current_user_profile(){
				ob_start();
	        	require_once  plugin_dir_path( __FILE__ ). 'partials/ace-profile.php';
				$wp_content = ob_get_clean();
				return $wp_content;
	        }
	        add_shortcode( 'ace-profile-page', 'ace_current_user_profile' );
    	}	
	}
}
