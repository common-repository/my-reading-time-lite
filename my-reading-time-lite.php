<?php
/**
 * Plugin Name: My Reading Time Lite
 * Plugin URI:  https://jeweltheme.com
 * Description: Post/Page Reading Time for WordPress
 * Version:     1.0.3
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: my-reading-time-lite
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package my-reading-time-lite
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'my-reading-time-lite' ) );
}

$jltmrt_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTMRT' ) ) {
	define( 'JLTMRT', $jltmrt_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTMRT_VER' ) ) {
	define( 'JLTMRT_VER', $jltmrt_plugin_data['Version'] );
}

if ( ! defined( 'JLTMRT_AUTHOR' ) ) {
	define( 'JLTMRT_AUTHOR', $jltmrt_plugin_data['Author'] );
}

if ( ! defined( 'JLTMRT_DESC' ) ) {
	define( 'JLTMRT_DESC', $jltmrt_plugin_data['Author'] );
}

if ( ! defined( 'JLTMRT_URI' ) ) {
	define( 'JLTMRT_URI', $jltmrt_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTMRT_DIR' ) ) {
	define( 'JLTMRT_DIR', __DIR__ );
}

if ( ! defined( 'JLTMRT_FILE' ) ) {
	define( 'JLTMRT_FILE', __FILE__ );
}

if ( ! defined( 'JLTMRT_SLUG' ) ) {
	define( 'JLTMRT_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTMRT_BASE' ) ) {
	define( 'JLTMRT_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTMRT_PATH' ) ) {
	define( 'JLTMRT_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTMRT_URL' ) ) {
	define( 'JLTMRT_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTMRT_INC' ) ) {
	define( 'JLTMRT_INC', JLTMRT_PATH . '/Inc/' );
}

if ( ! defined( 'JLTMRT_LIBS' ) ) {
	define( 'JLTMRT_LIBS', JLTMRT_PATH . 'Libs' );
}

if ( ! defined( 'JLTMRT_ASSETS' ) ) {
	define( 'JLTMRT_ASSETS', JLTMRT_URL . 'assets/' );
}

if ( ! defined( 'JLTMRT_IMAGES' ) ) {
	define( 'JLTMRT_IMAGES', JLTMRT_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTMRT\\JLT_My_Reading_Time' ) ) {
	// Autoload Files.
	include_once JLTMRT_DIR . '/vendor/autoload.php';
	// Instantiate JLT_My_Reading_Time Class.
	include_once JLTMRT_DIR . '/class-my-reading-time-lite.php';
}