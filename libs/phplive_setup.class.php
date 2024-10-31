<?php
	/**************************/
	/* www.phplivesupport.com */
	/**************************/
	require_once( 'phplive.class.php' ) ;

	FINAL CLASS phplive_admin EXTENDS phplive
	{
		protected function __construct()
		{
			parent::__construct() ;
			// [v] admin_menu
			add_action( 'admin_menu', Array( $this, 'phplive_admin_menu' ) ) ;
			add_action( 'wp_ajax_my_action', Array( $this, 'phplive_admin_ajax' ) ) ;
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) { add_action( 'init', Array( $this, 'error_reporting' ) ) ; }
		}

		public static function get_instance()
		{
			if ( !isset( self::$instance ) ) { $class = __CLASS__ ; self::$instance = new $class ; }
			return self::$instance ;
		}

		public function error_reporting() { error_reporting(E_ALL & ~E_USER_NOTICE) ; }

		public function phplive_admin_menu()
		{
			add_menu_page( 'PHP Live! WordPress', 'PHP Live!', 'administrator', 'phplive_wp', Array($this, 'phplive_admin_html'), $this->fetch_phplive_wp_plugin_path().'/pics/phplive.png' ) ;
		}

		public function phplive_admin_html()
		{
			$phplive_html_code = get_option( 'phplive_html_code' ) ;
			$phplive_url_showhide = get_option( 'phplive_url_showhide' ) ;
			global $current_user ;

			wp_enqueue_style( 'phplive_wp', $this->fetch_phplive_wp_plugin_path().'/css/style.css' ) ;
			get_currentuserinfo() ;
			// for future reference of populating other options
			$name = $current_user->display_name ;
			$lname = $current_user->user_lastname ;
			$email = $current_user->user_email ;

			$wp_output = '<script type="text/javascript" src="'.$this->fetch_phplive_wp_plugin_path().'/js/pre_load.js"></script>' ;
			$wp_output .= '<div style="padding-top: 20px; padding-right: 20px;">' ;

			$div_html = $div_settings = "" ;

			$wp_output .= '<div class="phplive_wp_menu_wrapper" style="min-width: 620px;"><div id="menu_html" class="phplive_wp_menu" onClick="phplive_wp_launch(\'html\')"><img src="'.$this->fetch_phplive_wp_plugin_path().'/pics/wordpress.png" width="16" height="16" border="0"> Paste your PHP Live! HTML Code</div><div id="menu_settings" class="phplive_wp_menu" onClick="phplive_wp_launch(\'settings\')"><img src="'.$this->fetch_phplive_wp_plugin_path().'/pics/settings.png" width="16" height="16" border="0"> Reset</div><div style="clear: both;"></div></div>' ;

			$phplive_url_show = ( ( $phplive_url_showhide == "show" ) || !$phplive_url_showhide ) ? "checked" : "" ;
			$phplive_url_hide = ( $phplive_url_showhide == "hide" ) ? "checked" : "" ;
			$div_html = "
				<form>
					<div><img src='".$this->fetch_phplive_wp_plugin_path()."/pics/page_white_code.png' width='16' height='16' border='0'> The PHP Live! WordPress plugin is a simple method to add the PHP Live! chat icon to your WordPress pages. The plugin does not replace the actual PHP Live! system. The plugin is just a method to paste the PHP Live! HTML Code to your WordPress pages to display the chat icon.  If you are needing a PHP Live! system, please purchase the <a href='http://www.phplivesupport.com/r.php?r=pr' target='new'>Download</a> solution to install the live chat on your <span style='color: #777BB3; padding: 2px; background: #CCE8FF; text-shadow: none; font-weight: bold;'>PHP</span> and <span style='color: #E77900; padding: 2px; background: #CCE8FF; text-shadow: none; font-weight: bold;'>MySQL</span> enabled web server.  After your PHP Live! system is installed and setup, login to the PHP Live! Setup Admin area and click the top menu \"Live Chat HTML Code\" to generate the chat icon HTML Code.  Paste the chat icon HTML Code below and save.</div>
					<div style='margin-top: 15px; display: none;' class='phplive_wp_info_good' id='div_alert'>Save Success</div>
					<div style='margin-top: 15px;'><textarea id='phplive_html_code' rows=16 wrap='virtual' style='padding: 5px; width: 100%;'>$phplive_html_code</textarea></div>

					<!-- <div style='margin-top: 15px;'>
						Toggle to display or hide the live chat icon.
						<div style='margin-top: 15px;'>
							<input type='radio' name='phplive_url_showhide' id='phplive_url_show' ".$phplive_url_show."> Display chat icon.
							<input type='radio' name='phplive_url_showhide' id='phplive_url_hide' ".$phplive_url_hide."> Hide chat icon.
						</div>
					</div> -->
					<div style='margin-top: 15px;'><input type='button' value='Save' id='submit' class='button-primary' onClick='phplive_wp_sethtml()'></div>

					<div style='margin-top: 25px;' class='phplive_wp_info_box'>
						<big><b>Final Step:</b></big>
						<div style='margin-top: 5px;'>
							Click the left menu <b>Appearance</b> and select <b>widgets</b>.
							<div style='margin-top: 5px; background: #ECCF88; padding: 2px;'>If you don't see the <b>widgets</b> menu under <b>Appearance</b>, tray a different Wordpress theme that allows widgets.</div>
							<div style='margin-top: 5px;'>On the <b>widgets</b> page, look for the <b>+ plus icon</b>.  The <b>plus icon</b> should be visible somewhere on the page.  Click the plus icon and search for <b>php live</b> in the popup window and add the PHP Live! widget to the page.</div>
							<div style='margin-top: 5px;'>After adding the PHP Live! widget, click the <b>Update</b> button on the top right of the <b>widgets</b> page.  Check your Wordpress page and see if the chat icon is visible. <b>Important:</b> The PHP Live! widget can be placed anywhere you like if the WordPress theme has other areas to insert widgets.  Header or footer areas are the recommended places for the PHP Live! widget.</div>
						</div>
						<div style='margin-top: 5px; background: #ECCF88; padding: 2px;'>For past Wordpress versions that <b>does not have the plus icon on the widgets page</b>, simply drag and drop the PHP Live! widget to the header or footer area.</div>
					</div>
				</form>
			" ;

			$div_settings = "
				<form>
					<div style='font-size: 14px; font-weight: bold;'>Reset the PHP Live! addon values.</div>
					<div style='margin-top: 15px;'>Reset will clear the PHP Live! HTML Code.  Reset does not uninstall the plugin or remove the actual PHP Live! system.</div>
					<div style='margin-top: 25px;'><input type='button' value='Reset' id='submit' class='button-primary' onClick='phplive_wp_reset()'></div>
				</form>
			" ;

			$wp_output .= '<div id="phplive_setup_body_wrapper" style="text-align: justify;"><div id="phplive_setup_body_html" style="padding-top: 15px; padding-bottom: 15px;">'.$div_html.'</div><div id="phplive_setup_body_settings" style="display: none; padding-top: 15px; padding-bottom: 15px;">'.$div_settings.'</div></div>' ;
			$wp_output .= '</div><script type="text/javascript" src="'.$this->fetch_phplive_wp_plugin_path().'/js/load.js"></script>' ;

			print $wp_output ;
		}

		public function phplive_admin_ajax()
		{
			if ( isset( $_POST["action"] ) && isset( $_POST["action_sub"] ) )
			{
				if ( $_POST["action_sub"] == "set_html" )
				{
					$phplive_html_code = isset( $_POST['phplive_html_code'] ) ? $_POST['phplive_html_code'] : "" ;
					$phplive_url_showhide = isset( $_POST["phplive_url_showhide"] ) ? $_POST["phplive_url_showhide"] : "" ;
					if ( $phplive_html_code && $phplive_url_showhide ) {
						update_option( 'phplive_html_code', preg_replace( "/%plus%/", "+", urldecode( $phplive_html_code ) ) ) ;
						update_option( 'phplive_url_showhide', $phplive_url_showhide ) ;
						$json_data = "json_data = { \"status\": 1, \"error\": \"\" };" ;
					}
					else
						$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid PHP Live! HTML Code.\" };" ;
				}
				else if ( $_POST["action_sub"] == "reset" )
				{
					delete_option( 'phplive_html_code' ) ;
					delete_option( 'phplive_url_showhide' ) ;
					$json_data = "json_data = { \"status\": 1, \"error\": \"\" };" ;
				}
				else
					$json_data = "json_data = { \"status\": 1, \"error\": \"Invalid sub action.\" };" ;

			}
			else
				$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid action.\" };" ;
		
			print $json_data ; die() ;
		}

	}
?>
