<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Helpers\Classes\InternetProtocol;

class LoginFormController
{
  /**
   * LoginForm constructor.
   */
  public function __construct()
  {
    // Run the class if is in wp-login page
    if (strpos($GLOBALS['_SERVER']['REQUEST_URI'], 'wp-login') !== false) {
      include_once ABSPATH . 'wp-admin/includes/plugin.php';

      if (! \is_plugin_active('user-registration/user-registration.php')) {
        add_action('login_form', [$this, 'authenticator']);
        add_action('authenticate', [$this, 'authenticate'], 30, 3);
        add_action('login_head', [$this, 'styles']);
        add_filter('login_headerurl', [$this, 'url']);
        add_filter('login_headertext', [$this, 'title']);
        add_filter('login_errors', [$this, 'errors'], 99);
        add_action('login_head', [$this, 'remove_shake'], 20);
        add_filter('login_redirect', [$this, 'redirect'], 10, 3);
        add_filter('widget_text', 'do_shortcode');
        add_action('admin_notices', [$this, 'errors_credentials']);
        add_filter('admin_body_class', [$this, 'dashboard']);
      }
    }
  }

  /**
   * Creates and gets unique ID for login user.
   *
   * This will prevent a race condition if multiple people try to login at the same time.
   *
   * @access private
   * @param  string $session_token optional If set, it will get uniqid from transients. If
   *     not set, it will generate one.
   * @return bool|string
   */
  private function uniqid($session_token)
  {
    // edit these if you wish
    if (! isset($session_token)) {
      $session_token = '';
    }

    $key_length   = 12;
    $uniqid_length = 64;
    $transient_expires = 10 * 60 * 60;

    if (! $session_token) {
      // generate new uniqid. This should be unique for all users who request wp-login form.
      $key = bin2hex(openssl_random_pseudo_bytes($key_length));
      $uniqid = bin2hex(openssl_random_pseudo_bytes($uniqid_length));

      $transient_name = 'auth_uniqid_' . $key;
      $transient_value = $key . $uniqid;

      set_transient($transient_name, $transient_value, $transient_expires);

      return $transient_value;
    } else {
      // need to get the uniqid
      $transient_name = 'auth_uniqid_' . substr($session_token, 0, ($key_length * 2));	// bin2hex doubles the key length
      $transient_value = get_transient($transient_name);

      if ($transient_value == $session_token) {
        return true;
      } else {
        // transient is either wrong or expired. Either way, let's clean it up.
        delete_transient($transient_name);
        return false;
      }
    }
  }

  /**
   * Adds one or more classes to the body tag in the dashboard.
   *
   * @link https://wordpress.stackexchange.com/a/154951/17187
   * @param  String $classes Current body classes.
   * @return String          Altered body classes.
   */
  public function dashboard($classes)
  {
    $loginScreen = get_option( 'aios_custom_login_screen' );
    $loginScreen = ! empty($loginScreen) ? $loginScreen : 'default';

    $tdp_class  = '';
    if ($loginScreen == 'thedesignpeople') {
      $tdp_class = "$classes tdp-dashboard";
    }

    return $tdp_class;
  }

  /**
   * Custom Fields on WP Login.
   *
   * @since 3.1.5
   *
   * @access protected
   */
  public function authenticator()
  {
    if (is_plugin_active('user-registration/user-registration.php')) {
      return;
    }

    // set uniqid
    $uniqid = $this->uniqid('');

    $loginScreen = get_option( 'aios_custom_login_screen' );
    $loginScreen = ! empty($loginScreen) ? $loginScreen : 'default';

    echo '<div id="imhuman-container">
				<p>Security</p>
				<div class="imcontainer">
					<label for="imhuman"><input type="checkbox" name="imhuman" id="imhuman" value="imnotarobot"> I\'m not a robot</label>
					<input type="hidden" name="session_token" id="session_token" value="' . $uniqid . '"></div>
				</div>';

    if($this->aios_original_login()){
      echo '<div id="rm-rb"><div class="clear"></div></div>';
      if ($loginScreen == 'thedesignpeople'){
        echo '<div id="powered-by">Powered by <a href="https://www.agentimage.com/" target="_blank" style="color:#e61e25 !important;">TheDesignPeople, Inc</a></div>';
      } else {
        echo '<div id="powered-by">Powered by <a href="https://www.agentimage.com/" target="_blank">Agent Image</a></div>';
      }
    }
  }

  /**
   * Authenticate on login
   *
   * @param $user
   * @param $username
   * @param $password
   * @return mixed
   * @since 3.1.5
   *
   * @access protected
   */
  public function authenticate($user, $username, $password)
  {
    if (isset($_POST['imhuman'])) {
      if ($_POST['imhuman'] == 'imnotarobot') {
        if ($this->uniqid($_POST['session_token'])) {
          return $user;
        } else {
          return new \WP_Error( 'denied', 'Session expired, Create New <a href="' . admin_url() . '">Session Create</a>.' );
        }
      }
    }

    return false;
  }

  /**
   * Add custom style for wp-login.
   *
   * @since 3.1.5
   *
   * @access protected
   */
  public function styles()
  {
    $_loginscreen = get_option( 'aios_custom_login_screen' );
    $_loginscreen_logo = get_option( 'aios_custom_login_screen_logo' );
    switch ( $_loginscreen ) {
      case 'agentpro':
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-ap-bg.jpg';
        break;
      case 'imaginestudio':
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-is-bg.jpg';
        break;
      case 'propertypro':
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-pp-bg.jpg';
        break;
      case 'communitypro':
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-cp-bg.jpg';
        break;
      case 'solidsource':
      case 'aix':
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-aix-bg.jpg';
        break;
      case 'thedesignpeople':
        $wp_login_logo = 'tdp-logo.png';
        $wp_login_background = '';
        break;
      case 'true-custom':
        $wp_login_logo = $_loginscreen_logo;
        $wp_login_background = 'login-tc-bg.jpg';
        break;
      default:
        $wp_login_logo = 'new-ai-login-logo.png';
        $wp_login_background = 'login-sc-bg.jpg';
        break;
    }

    $cdn_url = 'https://resources.agentimage.com/plugins/aios-initial-setup/custom-login-screen-assets/';

    if ($_loginscreen != 'true-custom') {
      $_login_logo = ! empty($wp_login_logo) ? '.login h1 a {
					background-image: url("' . $cdn_url . $wp_login_logo . '") !important;
					background-color: transparent;
					background-size: auto;
					width: 100%;
					margin-bottom: 0;
					margin-top: 22px;
				}' : '';
    } else {
      $_login_logo = ! empty($wp_login_logo) ? '.login h1 a {
					background-image: url("' . $_loginscreen_logo . '") !important;
					background-color: transparent;
					background-size: auto;
					width: 100%;
					margin-bottom: 0;
					margin-top: 22px;
				}' : '';
    }

    if ($_loginscreen === 'thedesignpeople'){
      echo '<style>
          #wp-submit{
            background: #e61e25 !important;
          }
        </style>';
    }

    if ($this->aios_original_login()) {
      $_login_background = ! empty($wp_login_background) ? 'body.login {
					background-image: url("' . $cdn_url . $wp_login_background . '");
					background-color: transparent;
					background-repeat: no-repeat;
					background-attachment: fixed;
					background-position: center;
					background-size: cover;
				}' : 'body.login {background: #FFF;}';

      echo '
				<script>
					document.addEventListener("DOMContentLoaded",function(){
						function insertAfter(referenceNode, newNode) {
						    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
						}

						var $nav 			= document.getElementById("nav");
						var $backtoblog 	= document.getElementById("backtoblog");
						var $loginform 		= document.getElementById("loginform");
						var $userpass 		= document.getElementById("user_pass");
						var $poweredby 		= document.getElementById("powered-by");
						var $imhuman 		= document.getElementById("imhuman-container");
						var $rmrb 			= document.getElementById("rm-rb");
						var $forgetmenot 	= document.getElementsByClassName("forgetmenot");
						var $submit 		= document.getElementsByClassName("submit");
						var $login_error 	= document.createElement( "div" );

						$login_error.id = "login_error";
						$login_error.className = "shake_error";
						$login_error.innerHTML = "We need to make sure you\'re not a robot.";

						if( $nav != null ) {
							$nav.querySelector("a").innerHTML = "Forgot Password?";
							$backtoblog.querySelector("a").innerHTML = "Back to ' . get_site_url() . '";
							insertAfter( $userpass, $nav );
						}

						$loginform.append( $submit[0] );
						$loginform.append( $rmrb );
						if( $backtoblog != null ) {
							$loginform.append( $backtoblog );
						}
						$loginform.append( $poweredby );

						$submit.value = "Login";

						$rmrb.prepend( $forgetmenot[0] );

						document.getElementById("wp-submit").addEventListener( "click", function( e ) {
							if( document.getElementById("imhuman").checked == false ) {
								e.preventDefault();
								if( document.getElementById("login_error") == null ) {
									$loginform.className="imhuman-error"
									document.getElementById("login").insertBefore( $login_error, $loginform );
								}
							}
						} );
					});
				</script>
				<style>
					@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
					body{ font-family: "Open Sans", sans-serif; text-align:center; }
					' . $_login_background . '

					body:before{
						content: "";
						height: 100%;
						width: 0;
						display: inline-block;
						vertical-align: middle;
					}
					.clear{
						clear:both;
					}
					#login{
						background: #fff;
						max-width: 471px;
						width: 100%;
						padding: 3% 0 2% !important;
						display: inline-block;
						vertical-align: middle;
						position: relative;
						border: 1px solid #efefef;
						border-radius: 4px;
						-webkit-box-shadow: 1px 1px 17px 2px rgba(0,0,0,0.3);
						-moz-box-shadow: 1px 1px 17px 2px rgba(0,0,0,0.3);
						box-shadow: 1px 1px 17px 2px rgba(0,0,0,0.3);
					}
					.login h1{
						width: 100%;
						margin: auto;
					}
					' . $_login_logo . '
					.shake_error {
						animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
						transform: translate3d(0, 0, 0);
						backface-visibility: hidden;
						perspective: 1000px;
					}
						@keyframes shake {
							10%, 90% {
								transform: translate3d(-1px, 0, 0);
							}

							20%, 80% {
								transform: translate3d(2px, 0, 0);
							}

							30%, 50%, 70% {
								transform: translate3d(-4px, 0, 0);
							}

							40%, 60% {
								transform: translate3d(4px, 0, 0);
							}
						}
					.login form{
						padding: 0;
						background: transparent;
						box-shadow: 0 1px 3px rgba(0,0,0,0);
						width: 68%;
						margin: 0 auto !important;
						border: none;
					}
					.login label {
						font-size: 14px;
						color: #555555;
					}
					.login input[type="text"]{
						border: 1px solid #bebebe;
						box-shadow: inset 0 1px 2px rgba(0,0,0,0);
						border-radius: 3px;
						height: 38px;
						font-size: 15px;
						padding: 10px;
					}
					.login input[type="password"]{
						border: 1px solid #bebebe;
						box-shadow: inset 0 1px 2px rgba(0,0,0,0);
						border-radius: 3px;
						height: 38px;
						font-size: 15px;
						padding: 10px;
					}
					.login #login_error, .login .message, .login .success{
						width: 74%;
						left: 13%;
						color: red;
						bottom: 91%;
						position: absolute;
						padding: 5px 0;
						margin: 0 !important;
					}
					#rm-rb {
						float: left;
						width: 100%;
						padding-top: 15px;
					}
					#login form #imhuman-container{
						display: block;
				      float: none;
				      width: 100%;
				      text-transform: uppercase;
				      margin-bottom: 20px;
						text-align:left;
					}
					#login form #imhuman-container p {
						padding-bottom: 5px;
						color: #a3a2a2;
						text-transform: capitalize;
					}
						.imcontainer {
							padding: 10px 0 10px 10px;
							border: 1px solid #b9b9b9;
						}
						#imhuman-container label{
							font-size: 12px;
							text-transform: initial;
							line-height: 19px;
						}
						.imhuman-error #imhuman {
							border-color: red;
						}
					#login form p.forgetmenot{
						float: left;
						width: 50%;
					}
					#login form label{
						color: #a3a2a2;
					}   
					#login form p.forgetmenot input {
		                float: left;
		                margin-top: 4px;
		            }
					#login form p{
						text-align:left;
						position:relative;

					}
						#login form p #nav{
							position: absolute;
							right: 0;
							top: 0;
							margin: 0;
							padding: 0;

						}
						#login form p #nav a{
							color: #a3a2a2;
							font-size: 12px;
							text-decoration:underline;
						}
						.login label{
							color: #a3a2a2;
							display: block;
							text-align: left
						}
						#login form p.forgetmenot input {
							display: inline-block;
						}
						
						
						#login form p label {
							display: block;
						}
						
						
					#login form p.submit{
						float: left;
						width: 100%;
					}
						#login form p.submit:after{
							content: "";
							display: block;
							width: 100%;
							clear: both;
						}
						#wp-submit {
							-webkit-appearance: none;
							float: left;
							border: 0;
							background: #009bbb;
							width: 100%;
							height: 39px;
							padding: 0 15px;
							font-weight: 700;
							font-size: 15px;
							color: #FFFFFF;
							text-align: center;
							text-decoration: none;
							text-transform: uppercase;
							line-height: 39px !important;
							outline: 0;
							transition: opacity 0.2s linear;
							cursor: pointer;
							-webkit-border-radius: 3px;
							-moz-border-radius: 3px;
							border-radius: 3px;
						}
							#wp-submit:hover{
								opacity: 0.7;
							}

						.wp-core-ui .button-primary {
						    border-color: transparent;
						    box-shadow: 0 1px 0 transparent;
						    color: #fff;
						    text-decoration: none;
						    text-shadow: 0 0px 0px #fff;
						}
						.login #backtoblog{
							float: left;
							width: 100%;
							padding:0;
							text-align:center;
						    margin-top: 30px;
						}
							.login #backtoblog a{
								display: inline-block;
								border: 1px solid #cbcbcb;
								color: #9d9a9a !important;
								padding: 14px 9px;
								border-radius: 3px;
								transition: all .25s ease-in-out;
								-moz-transition: all .25s ease-in-out;
								-webkit-transition: all .25s ease-in-out;
							}
							.login #backtoblog a:hover {
								background: #9d9a9a !important;
								color: #fff !important;
							}
					#powered-by{
						float: left;
						width: 100%;
						color: #a3a2a2;
						font-size: 12px;
					    padding-top: 16px;
					}
						#powered-by a{
							color:#009bba;
							text-decoration: none;
							transition: opacity 0.2s linear;
						}
							#powered-by a:hover{
								opacity: 0.8;
							}
					.login form .input, .login form input[type=checkbox], .login input[type=text] {
					    background: #fff;
					    border: 1px solid #a3a2a2;
					    box-shadow: inset 0 1px 2px rgba(0,0,0,0);
					}

					.login #login_error, .login .message, .login .success{
						border: 1px solid red;
					}
					.interim-login #login{
						margin: 57px auto 0 !important;
					}
					.login #nav{
						margin: 0;
						padding: 0;
						text-align: right;
						color: #a3a2a2;
						font-size: 12px;
						text-decoration: underline;
					}
					.login-action-lostpassword #nav{
						display: none;
					}

					@media(max-width: 330px){
						#login{
							max-width: 300px;
						}
						.login h1 a{
						    background-size: 71%;
						    background-position: center;
						}
						.login form{
							width:88%;
						}
					}
				</style>';

    } else {
      echo ' <script>
					document.addEventListener("DOMContentLoaded",function(){
			
						var $loginform 		= document.getElementById("loginform");
						var $imhuman 		= document.getElementById("imhuman-container");
						var $login_error 	= document.createElement( "div" );

						$login_error.id = "login_error";
						$login_error.className = "shake_error";
						$login_error.innerHTML = "We need to make sure you\'re not a robot.";
			
						document.getElementById("wp-submit").addEventListener( "click", function( e ) {
							if( document.getElementById("imhuman").checked == false ) {
								e.preventDefault();
								if( document.getElementById("login_error") == null ) {
									$loginform.className="imhuman-error"
									document.getElementById("login").insertBefore( $login_error, $loginform );
								}
							}
						} );
					});
				</script> ';
    }
  }

  /**
   * Add custom style for wp-login.
   *
   * @since 3.1.5
   *
   * @access protected
   * @return string
   */
  public function url()
  {
    return get_bloginfo('url');
  }

  /**
   * Add custom style for wp-login.
   *
   * @since 3.1.5
   *
   * @access protected
   * @return string
   */
  public function title()
  {
    return get_bloginfo('name');
  }

  /**
   * Add custom style for wp-login.
   *
   * @param $error
   * @return string
   * @since 3.1.5
   *
   * @access protected
   */
  public function errors($error)
  {
    global $errors;

    // Return if error is null and login is correct for custom plugins
    if( is_null( $errors ) ) {
      return $error;
    }

    $err_codes = $errors->get_error_codes();
    $login_tries = '';
    $internetProtocol = new InternetProtocol();

    if (! $internetProtocol->whitelist_ip()) {
      $post = get_posts( array( 'title' => $internetProtocol->isp(), 'post_type' => 'aios-login-attempts' ));
      if (! empty($post[0]->ID)) {
        $attempts = get_post_meta($post[0]->ID, 'attempts', true);
        $attempts = ! empty($attempts) ? $attempts : 0;
        $tries = 5 - $attempts;
        $login_tries = "$tries attempts left and you will wait for 24 hours to lift ban";
      }
    }

    // Invalid username.
    // Default: '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?'
    if (in_array('invalid_username', $err_codes) || in_array('incorrect_password', $err_codes) || in_array('authentication_failed', $err_codes)) {
      if ($this->aios_original_login()){
        $error = "<strong>ERROR</strong>: Invalid Credentials. <a href=".get_site_url()."/wp-login.php?action=lostpassword>Lost your password</a>? You can contact our support for assistance 1.877.317.4111<br> $login_tries";
      } else {
        $error = "<strong>ERROR</strong>: Invalid Credentials. <a href=".get_site_url()."/wp-login.php?action=lostpassword>Lost your password</a>?";
      }
    }

    return $error;
  }

  /**
   * Remove shake on wrong login.
   *
   * @since 3.1.5
   *
   * @access protected
   */
  public function remove_shake()
  {
    remove_action('login_head', 'wp_shake_js', 12);
  }

  /**
   * Redirect users to homepage if admin.
   *
   * @param $redirect_to
   * @param $request
   * @param $user
   * @return string
   * @since 3.1.5
   *
   * @access protected
   */
  public function redirect($redirect_to, $request, $user)
  {
    global $user;

    if (isset($user->roles) && is_array($user->roles)) {
      if(in_array("administrator", $user->roles)) {
        return $redirect_to;
      } else {
        return home_url();
      }
    } else {
      return $redirect_to;
    }
  }

  /**
   * Custom Error Message on Wrong Login
   *
   * @since 3.1.5
   *
   * @access protected
   */
  public function errors_credentials()
  {
    $current_username = wp_get_current_user()->user_login;
    if (isset($current_username)) {
      if (strtolower($current_username) === 'agentimage') {
        $_loginscreen = get_option('aios_custom_login_screen');
        if (empty($_loginscreen)) {
          printf('<div class="notice notice-error"><p>Please select login screen <a href="' . get_admin_url() . 'admin.php?page=aios-initial-setup&panel=login-screen">click here</a> to change login screen</p></div>');
        }
      }
    }
  }

  /**
   * Original Login Condition
   *
   * @since 3.1.5
   *
   * @access protected
   * @return string
   */
  public function aios_original_login()
  {
    return get_option('aios_custom_login_screen') !== 'original';
  }
}

new LoginFormController();
