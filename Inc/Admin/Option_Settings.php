<?php
namespace JLTMRT\Inc\Admin;

use JLTMRT\Libs\Helper;
use JLTMRT\Inc\Admin\AdminSettings;

/*
 * @version 1.0.2
 * @package my-reading-time-lite
 */


if ( !class_exists('Option_Settings' ) ){

    class Option_Settings {

        private $settings_api;

        function __construct() {

            $this->settings_api = new AdminSettings;

            add_action( 'admin_init', array($this, 'jltmrt_admin_init') );
            add_action( 'admin_menu', array($this, 'jltmrt_admin_menu') );

            
        }


        public function jltmrt_admin_init() {
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );
            $this->settings_api->admin_init();
        }

        public function jltmrt_admin_menu() {
            add_options_page(
                esc_html__('My Reading Time Settings', 'my-reading-time-lite' ),
                esc_html__('My Reading Time', 'my-reading-time-lite' ),
                'manage_options',
                'my-reading-time-settings',
                array( $this, 'plugin_page' )
            );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id' => 'jltma_mrt_settings',
                    'title' => esc_html__( 'Settings', 'my-reading-time-lite' )
                ),
                array(
                    'id' => 'jltma_mrt_onscroll',
                    'title' => esc_html__( 'Progressbar', 'my-reading-time-lite' )
                ),
                array(
                    'id' => 'jltma_mrt_free_vs_pro',
                    'title' => esc_html__( 'Free vs Pro', 'my-reading-time-lite' ),
                    'callback' => [$this, 'html_only']
                )
            );
            return $sections;
        }

        function html_only(){
            return 'html';
        }
        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields() {
            
            /* My Reading Time General Settings */
            $settings_fields = array(

                'jltma_mrt_settings' => array(
                    array(
                        'name'      => 'mrt_label',
                        'label'     => esc_html__( 'Reading Time Label', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Reading Time Label', 'my-reading-time-lite' ),
                        'type'      => 'text',
                        'default'   => esc_html__( 'Reading Time:', 'my-reading-time-lite' ),
                    ), 

                    array(
                        'name'      => 'mrt_label_position',
                        'label'     => esc_html__( 'After/Before Reading Label', 'my-reading-time-lite' ),
                        'desc'      => '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>',
                        'type'      => 'html'
                    ),
                    array(
                        'name'      => 'mrt_time_in_mins',
                        'label'     => esc_html__( 'Time in Minutes(mins)', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Minutes text after Time', 'my-reading-time-lite' ),
                        'default'   => esc_html__( 'mins', 'my-reading-time-lite' ),
                        'type'      => 'text'
                    ),  
                    array(
                        'name'      => 'mrt_time_in_min',
                        'label'     => esc_html__( 'Time in Minute(min)', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Minute text after Time', 'my-reading-time-lite' ),
                        'default'   => esc_html__( 'min', 'my-reading-time-lite' ),
                        'type'      => 'text'
                    ),  

                    array(
                        'name'      => 'mrt_words_per_min',
                        'label'     => esc_html__( 'Words Per Minute', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'How many words can read per minute. Standard 275', 'my-reading-time-lite' ),
                        'default'   => esc_html__( '200', 'my-reading-time-lite' ),
                        'type'      => 'text'
                    ),

                    array(
                        'name'      => 'mrt_before_content',
                        'label'     => esc_html__( 'Show on before Content?', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Show "My Reading Time" before Content', 'my-reading-time-lite' ),
                        'type'      => 'checkbox'
                    ),


                    array(
                        'name'      => 'mrt_before_excerpt',
                        'label'     => esc_html__( 'Show on before Excerpt?', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Show "My Reading Time" before Content Excerpt', 'my-reading-time-lite' ),
                        'type'      => 'checkbox'
                    ),


                    array(
                        'name'      => 'mrt_exclude_images',
                        'label'     => esc_html__( 'Exclude Images from Reading Time?', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Check to exclude Images from Content Reading Time', 'my-reading-time-lite' ),
                        'type'      => 'checkbox'
                    ),

                    array(
                        'name'      => 'mrt_shortcodes_include',
                        'label'     => esc_html__( 'Include Shortcode Contents?', 'my-reading-time-lite' ),
                        'desc'      => esc_html__( 'Check to count Shortcodes Contents on Reading Time', 'my-reading-time-lite' ),
                        'type'      => 'checkbox'
                    ),
                ),


                'jltma_mrt_onscroll' => array(

                    array(
                        'name'      => 'mrt_enable_progress',
                        'label'     => esc_html__( 'Enable Progressbar', 'my-reading-time-lite' ),
                        'desc'      => '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>',
                        'type'      => 'html'
                    ),

                    array(
                        'name' => 'mrt_bg_color',
                        'label' => esc_html__( 'Background Color', 'my-reading-time-lite' ),
                        'desc'      => '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>',
                        'type'      => 'html'
                    ),
                    array(
                        'name' => 'mrt_progress_color',
                        'label' => esc_html__( 'Progress Color', 'my-reading-time-lite' ),
                        'desc'      => '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>',
                        'type'      => 'html'
                    ),
                    array(
                        'name'      => 'mrt_progress_height',
                        'label'     => esc_html__( 'Progressbar Height(px)', 'my-reading-time-lite' ),
                        'desc'      => '<div class="jltma-mrt-text-small" style="padding-top:20px;"> Upgrade to  <a href="' . esc_url('https://jeweltheme.com') . '">Pro Version</a> unlock this feature.</div>',
                        'type'      => 'html'
                    ),



                ),

                

                'jltma_mrt_free_vs_pro' => array(
                    array(
                        'name'          => '',
                        'type'          => 'html_content',
                        'reference'     => $this->jltma_mrt_free_vs_pro()
                    ),
                )

            );

            return $settings_fields;
        }


        function jltma_mrt_free_vs_pro(){
            ob_start(); ?>

                   <thead>
                      <tr>
                         <td>
                            <strong>
                               <h3><?php esc_html_e( 'Feature', 'my-reading-time-lite' ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Free', 'my-reading-time-lite' ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Pro', 'my-reading-time-lite' ); ?></h3>
                            </strong>
                         </td>
                      </tr>
                   </thead>

                   <tbody>
                      <tr>
                         <td><?php esc_html_e( 'Elementor support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Classic Editor Support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Gutenberg Support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Shortcode Support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Fully Responsive', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Developer Friendly', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Max Words Per Minute', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Enable/Disable Progressbar', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Unlimited Progressbar Colors', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Progressbar Height', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'After/Before Reading Label', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Supports Excerpt', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Count Images on Reading Time', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Count Shortcodes on Reading Time', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      
                      <tr>
                         <td><?php esc_html_e( 'All Themes Support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'PHP Template Code', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Extensive Documentation', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( '24/7 Support', 'my-reading-time-lite' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                   </tbody>

                   <p style="text-align: right;">
                      <a class="button button-primary button-large" href="https://jeweltheme.com" target="_blank"><?php esc_html_e('View My Reading Time Pro', 'my-reading-time-lite'); ?>
                      </a>
                   </p>



        <?php 
            $output = ob_get_contents();
          ob_end_clean();
          
          return $output;
        }

       function plugin_page() {
            $user = wp_get_current_user();
            ?>

                
            <div class="info-container">

                <p class="hello-user">
                    <?php echo sprintf( __( 'Hello, %s,', 'my-reading-time-lite' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?>
                </p>
                <h1 class="info-title">
                    <?php echo sprintf( __( 'Welcome to %s', 'my-reading-time-lite' ), JLTMRT ); ?>
                    <span class="info-version">
                        <?php echo 'v' . JLTMRT_VER; ?>    
                    </span>
                </h1>
                <p class="welcome-desc"> 
                    <strong> Usage:</strong><br>
                    <code>
                        [my_reading_time mrt_label="Reading Time" mrt_time_in_mins="mins" mrt_time_in_min="minute"]
                    </code><br>

                   <strong> For Specific Post ID:</strong>
                    <code>
                        [my_reading_time mrt_label="Reading Time" mrt_time_in_mins="mins" mrt_time_in_min="minute" post_id="2"]
                    </code>
                    <br>

                    Or simply use <code>[my_reading_time]</code> to return the number with no labels.<br>

                    Want to insert the reading time into your theme? Use <code>do_shortcode('[my_reading_time]')</code>. 
                </p>


                <div class="jltma-mrt-theme-tabs">
                    <?php 
                        $this->settings_api->show_navigation();
                        $this->settings_api->show_forms();
                    ?>

                    <div id="jltma_mrt_support" class="jltma-mrt-tab support">
                        <div class="column-wrapper">
                            <div class="tab-column">
                            <span class="dashicons dashicons-sos"></span>
                            <h3><?php esc_html_e( 'Visit our forums', 'my-reading-time-lite' ); ?></h3>
                            <p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', 'my-reading-time-lite' ); ?></p>
                                <a href="https://jeweltheme.com/support/forum/wordpress-plugins/my-reading-time/" target="_blank"><?php esc_html_e( 'Visit the forums', 'my-reading-time-lite' ); ?></a>              
                                </div>
                            <div class="tab-column">
                            <span class="dashicons dashicons-book-alt"></span>
                            <h3><?php esc_html_e( 'Documentation', 'my-reading-time-lite' ); ?></h3>
                            <p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', 'my-reading-time-lite' ); ?></p>
                            <a href="https://jeweltheme.com/docs" target="_blank"><?php esc_html_e( 'See the Documentation', 'my-reading-time-lite' ); ?></a>
                            </div>
                        </div>
                    </div>

                </div> <!-- jltma-mrt-theme-tabs -->


                <div class="jltma-mrt-theme-sidebar">
                    <div class="jltma-mrt-sidebar-widget">
                        <h3>Review "My Reading Time"</h3>
                        <p>It makes us happy to hear from our users. We would appreciate a review. </p> 
                        <p><a target="_blank" href="https://wordpress.org/support/plugin/my-reading-time/reviews/#new-post">Write a review here</a></p>     
                    </div>
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltma-mrt-sidebar-widget">
                        <h3>Changelog</h3>
                        <p>Keep informed about each theme update. </p>  
                        <p><a target="_blank" href="https://wordpress.org/plugins/my-reading-time/#developers">See the changelog</a></p>       
                    </div>  
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltma-mrt-sidebar-widget">
                        <h3>Upgrade to My Reading Time Pro</h3>
                        <p>Take your "My Reading Time" to a whole other level by upgrading to the Pro version. </p>   
                        <p><a target="_blank" href="https://jeweltheme.com">Discover My Reading Time Pro</a></p>      
                    </div>                                  
                </div>

            </div>

            <?php 
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages() {
            $pages = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
}