<?php
/*
Plugin Name: Ludou Custom User Register
Plugin URI: http://www.ludou.org/wordpress-ludou-custom-user-register.html
Description: Change register
Version: 3.0
Author: Ludou
Author URI: http://www.ludou.org
*/

if (!isset($_SESSION)) {
 	session_start();
	session_regenerate_id(TRUE);
}

/**
 * 
 */
if ( !function_exists('wp_new_user_notification') ) :
/**
 * Notify the blog admin of a new user, normally via email.
 *
 * @since 2.0
 *
 * @param int $user_id User ID
 * @param string $plaintext_pass Optional. The user's plaintext password
 */
function wp_new_user_notification($user_id, $plaintext_pass = '', $flag='') {
	if(func_num_args() > 1 && $flag !== 1)
		return;

	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
	
	if ( empty($plaintext_pass) )
		return;

	// Email
// 	$message  = sprintf(__(), $user_login) . "\r\n";
// 	$message .= sprintf(__(), $plaintext_pass) . "\r\n";
// 	$message .= 'address: ' . wp_login_url() . "\r\n";

	// sprintf(__('[%s] Your username and password'), $blogname) title
	wp_mail($user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);
}
endif;

/* change table data */
function ludou_show_password_field() {
  // make token，
	$token = md5(uniqid(rand(), true));
	
	$_SESSION['ludou_register_584226_token'] = $token;
	
	define('LCR_PLUGIN_URL', plugin_dir_url( __FILE__ ));
?>
<style type="text/css">
<!--
#user_role {
  padding: 2px;
  -moz-border-radius: 4px 4px 4px 4px;
  border-style: solid;
  border-width: 1px;
  line-height: 15px;
}

#user_role option {
	padding: 2px;
}
-->
</style>
<p>
	<label for="user_nick">Nickname<br/>
		<input id="user_nick" class="input" type="text" size="25" value="<?php echo empty($_POST['user_nick']) ? '':$_POST['user_nick']; ?>" name="user_nick" />
	</label>
</p>
<p>
	<label for="user_pwd1">Password(At least 6)<br/>
		<input id="user_pwd1" class="input" type="password" size="25" value="" name="user_pass" />
	</label>
</p>
<p>
	<label for="user_pwd2">Repeat password<br/>
		<input id="user_pwd2" class="input" type="password" size="25" value="" name="user_pass2" />
	</label>
</p>
<p style="margin:0 0 10px;">
	<label>User role:
		<select name="user_role" id="user_role">
			<option value="subscriber" <?php if(!empty($_POST['user_role']) && $_POST['user_role'] == 'subscriber') echo 'selected="selected"';?>>Subscriber</option>
			<option value="contributor" <?php if(!empty($_POST['user_role']) && $_POST['user_role'] == 'contributor') echo 'selected="selected"';?>>Contributor</option>
		</select>
	</label>
	<br />
</p>
<p>
<!-- 	<label>
	<img id="captcha_img" src="<?php echo constant("LCR_PLUGIN_URL"); ?>/captcha/captcha.php" title="Change pic" alt="Change pic" onclick="document.getElementById('captcha_img').src='<?php echo constant("LCR_PLUGIN_URL"); ?>/captcha/captcha.php?'+Math.random();document.getElementById('CAPTCHA').focus();return false;" />
	</label>
</p>
<input type="hidden" name="spam_check" value="<?php echo $token; ?>" /> -->
<?php
}

/* deal data */
function ludou_check_fields($login, $email, $errors) {
//   if(empty($_POST['spam_check']) || $_POST['spam_check'] != $_SESSION['ludou_register_584226_token'])
   if(1 !=1 )
		$errors->add('spam_detect', "<strong>Error</strong>：请勿恶意注册");
	
	if (!isset($_POST['user_nick']) || trim($_POST['user_nick']) == '')
	  $errors->add('user_nick', "<strong>Error</strong>：No nickname");
	  
	if(strlen($_POST['user_pass']) < 6)
		$errors->add('password_length', "<strong>Error</strong>：Password at least 6");
	elseif($_POST['user_pass'] != $_POST['user_pass2'])
		$errors->add('password_error', "<strong>Error</strong>：Password not match");

	if($_POST['user_role'] != 'contributor' && $_POST['user_role'] != 'subscriber')
		$errors->add('role_error', "<strong>Error</strong>：No role");
}

/* Save data */
function ludou_register_extra_fields($user_id, $password="", $meta=array()) {
	$userdata = array();
	$userdata['ID'] = $user_id;
	$userdata['user_pass'] = $_POST['user_pass'];
	$userdata['role'] = $_POST['user_role'];
	$userdata['nickname'] = str_replace(array('<','>','&','"','\'','#','^','*','_','+','$','?','!'), '', $_POST['user_nick']);
  
	$pattern = '/[一-龥]/u';
  if(preg_match($pattern, $_POST['user_login'])) {
    $userdata['user_nicename'] = $user_id;
  }
  
	wp_new_user_notification( $user_id, $_POST['user_pass'], 1 );
	wp_update_user($userdata);
}

function remove_default_password_nag() {
	global $user_ID;
	delete_user_setting('default_password_nag', $user_ID);
	update_user_option($user_ID, 'default_password_nag', false, true);
}

function ludou_register_change_translated_text( $translated_text, $untranslated_text, $domain ) {
  if ( $untranslated_text === 'A password will be e-mailed to you.' || $untranslated_text === 'Registration confirmation will be emailed to you.' )
    return '';
  else if ($untranslated_text === 'Registration complete. Please check your e-mail.' || $untranslated_text === 'Registration complete. Please check your email.')
    return 'Registration complete！';
  else
    return $translated_text;
}

add_filter('gettext', 'ludou_register_change_translated_text', 20, 3);
add_action('admin_init', 'remove_default_password_nag');
add_action('register_form','ludou_show_password_field');
add_action('register_post','ludou_check_fields',10,3);
add_action('user_register', 'ludou_register_extra_fields');
