<?php
namespace JLTMRT;

use JLTMRT\Libs\Assets;
use JLTMRT\Libs\Helper;
use JLTMRT\Libs\Featured;
use JLTMRT\Inc\Classes\Recommended_Plugins;
use JLTMRT\Inc\Classes\Notifications\Notifications;
use JLTMRT\Inc\Classes\Pro_Upgrade;
use JLTMRT\Inc\Classes\Row_Links;
use JLTMRT\Inc\Classes\Upgrade_Plugin;
use JLTMRT\Inc\Classes\Feedback;
use JLTMRT\Inc\Admin\Option_Settings;
use JLTMRT\Inc\Classes\Shortcode;
use JLTMRT\Inc\Classes\Hooks;


/**
 * Main Class
 *
 * @my-reading-time-lite
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.2
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_My_Reading_Time Class
 */
if ( ! class_exists( '\JLTMRT\JLT_My_Reading_Time' ) ) {

	/**
	 * Class: JLT_My_Reading_Time
	 */
	final class JLT_My_Reading_Time {

		const VERSION            = JLTMRT_VER;
		private static $instance = null;

		public $mrt;
		private $settings_api;
		
		// Allowed HTML Tags
		public static $mrt_attr = [
			'strong' => [],
			'br'     => [],
			'b'      => [],
			'em'     => []
		];		

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {

			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltmrt_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltmrt_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltmrt_maybe_run_upgrades' ], -100 ); .
		}


		// My Reading Times Filter
		public static function jltmrt_times($time, $single, $plugral ) {
			if ( $time > 1 ) {
				$mrt_in_times = $plugral;
			} else {
				$mrt_in_times = $single;
			}

			$mrt_in_times = apply_filters( 'mrt_edit_times', $mrt_in_times, $time, $single, $plugral );

			return $mrt_in_times;
		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltmrt_plugins_loaded() {
			$this->jltmrt_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltmrt_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltmrt_activate() {
			$current_jltmrt_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltmrt_activation_time' ) === false ) {
				update_option( 'jltmrt_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltmrt_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltmrt_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltmrt_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltmrt_body_class( $classes ) {
			$classes .= ' my-reading-time-lite ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltmrt_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Option_Settings();
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
			new Shortcode();
			new Hooks();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltmrt_init() {
			$this->jltmrt_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltmrt_load_textdomain() {
			$domain = 'my-reading-time-lite';
			$locale = apply_filters( 'jltmrt_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTMRT_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_My_Reading_Time ) ) {
				self::$instance = new JLT_My_Reading_Time();
				self::$instance->jltmrt_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_My_Reading_Time Class .
	JLT_My_Reading_Time::get_instance();
}