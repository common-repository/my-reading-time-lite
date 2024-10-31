<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_My_Reading_Time
 * @license       Copyright JLT_My_Reading_Time
 */

if ( ! function_exists( 'jltmrt_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltmrt_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltmrt_option( $section = 'jltmrt_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jltmrt_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltmrt_exclude_pages() {
		return jltmrt_option( 'jltmrt_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jltmrt_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltmrt_exclude_pages_except() {
		return jltmrt_option( 'jltmrt_triggers', 'exclude_pages_except', array() );
	}
}


if ( ! function_exists( 'jltmrt_options' ) ) {
	// Render Options data from admin settings
	function jltmrt_options( $option, $section, $default = '' ) {
		$options = get_option( $section );
		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}
		return $default;
	}
}



if ( ! function_exists( 'jltmrt_for_images_count' ) ) {

	/**
	 * Adds additional reading time for images
	 *
	 * Calculate additional reading time added by images in posts. Based on calculations by Medium.  
	 * https://blog.medium.com/read-time-and-you-bc2048ab620c
	 */
	function jltmrt_for_images_count( $total_images, $wpm ) {

		$additional_time = 0;
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += ( 12 - ( $i - 1 ) ) * (int) $wpm / 60;
			}
		}
		return $additional_time;

	}
}


if ( ! function_exists( 'jltmrt_reading_time' ) ) {
	// Calculate Reading time
	function jltmrt_reading_time( $mrt_post_id ) {

		$mrt_content       = get_post_field( 'post_content', $mrt_post_id );
		$image_count 	   = substr_count( strtolower( $mrt_content ), '<img ' );
		$word_count 	  = count( preg_split( '/\s+/', $mrt_content ) );

		// Options
		$mrt_shortcodes_include 	= jltmrt_options( 'mrt_shortcodes_include', 'jltma_mrt_settings', 'on' );
		$mrt_exclude_images 		= jltmrt_options( 'mrt_exclude_images', 'jltma_mrt_settings', 'on' );
		$mrt_words_per_min 			= jltmrt_options( 'mrt_words_per_min', 'jltma_mrt_settings', '200' );
		

		if ( isset( $mrt_shortcodes_include ) && $mrt_shortcodes_include == "on" ) {
			$mrt_content = strip_shortcodes( $mrt_content );
		}

		$mrt_content = wp_strip_all_tags( $mrt_content );

		if ( isset( $mrt_exclude_images ) && $mrt_exclude_images =="on") {
			$count_images_words 		 = jltmrt_for_images_count( $image_count, $mrt_words_per_min );
			$word_count                 += $count_images_words;

		}

		$word_count = apply_filters( 'mrt_word_count', $word_count );
		$jltma_mrt = $word_count / $mrt_words_per_min;


		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( 1 > $jltma_mrt ) {
			$jltma_mrt = esc_html__( '< 1', 'my-reading-time-lite' );
		} else {
			$jltma_mrt = ceil( $jltma_mrt );
		}

		return $jltma_mrt;
	}
}