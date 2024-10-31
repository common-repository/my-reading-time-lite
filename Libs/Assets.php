<?php
namespace JLTMRT\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Assets' ) ) {

	/**
	 * Assets Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 * @version     1.0.2
	 */
	class Assets {

		/**
		 * Constructor method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'jltmrt_enqueue_scripts' ), 100 );
			add_action( 'admin_enqueue_scripts', array( $this, 'jltmrt_admin_enqueue_scripts' ), 100 );
			add_action( 'admin_footer', [ $this, 'jltmrt_admin_footer_script' ]);
		}

        public function jltmrt_admin_footer_script(){?>

            <script src="text/javascript">
                jQuery(document).ready(function(){    
                    jQuery(".mrt_enable_progress td").addClass("jltma-mrt-disabled");
                    jQuery(".mrt_bg_color .button").addClass("jltma-mrt-disabled");
                    jQuery(".faq_collapse_style").append( JLTMRTCORE.upgrade_pro );
                });
            </script>
        <?php }


		/**
		 * Get environment mode
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function get_mode() {
			return defined( 'WP_DEBUG' ) && WP_DEBUG ? 'development' : 'production';
		}

		/**
		 * Enqueue Scripts
		 *
		 * @method wp_enqueue_scripts()
		 */
		public function jltmrt_enqueue_scripts() {

			// CSS Files .
			wp_enqueue_style( 'my-reading-time-lite-frontend', JLTMRT_ASSETS . 'css/my-reading-time-lite-frontend.css', JLTMRT_VER, 'all' );

			// JS Files .
			wp_enqueue_script( 'my-reading-time-lite-frontend', JLTMRT_ASSETS . 'js/my-reading-time-lite-frontend.js', array( 'jquery' ), JLTMRT_VER, true );

		}


		/**
		 * Enqueue Scripts
		 *
		 * @method admin_enqueue_scripts()
		 */
		public function jltmrt_admin_enqueue_scripts() {
			// CSS Files .
			wp_enqueue_style( 'my-reading-time-lite-admin', JLTMRT_ASSETS . 'css/my-reading-time-lite-admin.css', array( 'dashicons' ), JLTMRT_VER, 'all' );

			
			$jltmrt_upgrade_pro = '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>';
            

			// JS Files .
			wp_enqueue_script( 'my-reading-time-lite-admin', JLTMRT_ASSETS . 'js/my-reading-time-lite-admin.js', array( 'jquery' ), JLTMRT_VER, true );
			wp_localize_script(
				'my-reading-time-lite-admin',
				'JLTMRTCORE',
				array(
					'admin_ajax'        => admin_url( 'admin-ajax.php' ),
					'upgrade_pro'   	=> $jltmrt_upgrade_pro,
					'recommended_nonce' => wp_create_nonce( 'jltmrt_recommended_nonce' ),
				)
			);
		}
	}
}