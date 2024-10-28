<form action="" method="post">
	<div class="Ace-Setting-title-bar">
        <div class="Ace-Setting-title-content">
            <div class="Ace-Setting-title-menu" id="Ace-Setting-menu1">&nbsp;<h1 class="Ace-Setting-title">Settings</h1>
            </div>
            <a class="Ace-Setting-awm-links-paypal" target="_blank" href="https://www.paypal.com/paypalme/acewebx">You Liked It ? Donation  <img class="Ace-Setting-paypal-svg" src="<?php echo home_url(); ?>/wp-content/plugins/ace-user-management/admin/images/paypal-svgrepo-com.svg" alt="paypalicon"></a>
        </div>
    </div>
	<div class="ace-reCap-box">
		<table class="ace-reCap-setting">
			<tr>
				<td class="Ace-Setting_label">
                    <h4 class="label-name">
                    <?php if (is_array($recaptchaKeys) && isset($recaptchaKeys["c_reCaptcha_value"]) && $recaptchaKeys["c_reCaptcha_value"] == 1) {
                            echo "Enable reCaptcha";
                        } else {
                            echo "Disable reCaptcha";
                        } ?> 
                    </h4>
                </td>
				<td>
					<label class="switch">
					    <input type="checkbox" name="reCapatchacheck" value="1" <?php echo $reChecked; ?> class="recaptcha-css">
					    <span class="slider round"></span>
				    </label>
                </td>
			</tr>
			<tr>
				<td class="label"><h4 class="label-name">Site Key : </h4></td> 
                <td>
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <input type="text" name="siteKEY" class="sitekey" value="<?php echo isset( $recaptchaKeys["author_siteKey"]) ? esc_attr($recaptchaKeys["author_siteKey"]) : ""; ?>" class="recaptcha-css">
                </td>
			</tr>
			<tr>
			  	<td class="label"><h4 class="label-name">Secert Key : </h4></td> 
			  	<td><i class="fa fa-key" aria-hidden="true"></i>
			  		<input type="text" name="secretKEY" class="secretkey" value="<?php echo isset( $recaptchaKeys["author_reCap_secertkey"]) ? esc_attr($recaptchaKeys["author_reCap_secertkey"]) : ""; ?>" class="recaptcha-css" >
                </td>
			<tr>
		</table>
		<br>
	</div>
	<br>
	<?php if (isset($updateCusCss)) { echo $updateCusCss; } ?>
	<br>
	<div class="ace-reCap-box">
        <table class="ace-reCap-setting">
            <tr>
                <td class="Ace-Setting_label"><h3 class="label-name">Short Codes</h3></td>
                <td><h4 class="Ace-Setting_right_input"></h4></td>
            </tr>
            <tr>
                <td class="Ace-Setting_label"><h3 class="label-name">Profile:</h3></td>
                <td><h4 class="Ace-Setting_right_input">[ace-profile-page]</h4></td>
            </tr>
            <tr> 
                <td class="Ace-Setting_label"><h3 class="label-name">Login:</h3></td>
                <td><h4 class="Ace-Setting_right_input">[ace-login-public-form]</h4></td>
            </tr>
            <tr><td class="Ace-Setting_label"><h3 class="label-name">Registration:</h3></td>
                <td><h4 class="Ace-Setting_right_input" >[ace-registration-public-form]</h4>
                </td>
            </tr>
        </table>
	    <br>
	</div>
    <br><br>
	<div class="ace-reCap-box">
		<table class="ace-reCap-setting">
			<tr>
				<td class="Ace-Setting_label"><h3 class="label-name">StyleSheet(plugin pages css)</h3></td>
				<td><textarea id="myTextArea" class="css-textarea" cols="100" rows="10" name="custom_css_for_pages"><?php echo $getCustomCss; ?></textarea></td>
			</tr>
			<tr>
				<td></td>
			</tr>
		</table>
		<br>
		<input type="submit" name="custom_css" value="Save" class="ace-recap-save desc_btn">
	</div>
</form>