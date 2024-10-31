<?php
namespace JLTMRT\Inc\Classes;

use JLTMRT\JLT_My_Reading_Time;

defined( 'ABSPATH' ) || exit;

class Hooks {

	public function __construct() {		

		$this->jltma_mrt_init();

	}


	public function jltma_mrt_init(){

		$mrt_shortcodes_include 	= jltmrt_options( 'mrt_shortcodes_include', 'jltma_mrt_settings', 'on' );
		$mrt_exclude_images 		= jltmrt_options( 'mrt_exclude_images', 'jltma_mrt_settings', 'on' );
		$mrt_words_per_min 			= jltmrt_options( 'mrt_words_per_min', 'jltma_mrt_settings', '200' );
		
		$mrt_before_content 	    = jltmrt_options( 'mrt_before_content', 'jltma_mrt_settings', 'on' );
		$mrt_before_excerpt 	    = jltmrt_options( 'mrt_before_excerpt', 'jltma_mrt_settings', 'on' );
		
		if( isset($mrt_before_content) && $mrt_before_content == "on"){
			add_filter( 'the_content', [ $this, 'jltmrt_before_content' ]);	
		}

		if( isset($mrt_before_excerpt) && $mrt_before_excerpt == "on"){
			add_filter( 'get_the_excerpt', array( $this, 'jltma_mrt_before_excerpt' ), 1000 );
		}

	}



	public function jltmrt_before_content( $content ) {
		
		$main_content 	  = $content;
		$mrt_post_id      = get_the_ID();

		$jltma_mrt 		  = jltmrt_reading_time( $mrt_post_id );

		$mrt_label        = jltmrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', 'my-reading-time-lite' ) );
		$mrt_time_in_mins = jltmrt_options( 'mrt_time_in_mins', 'jltma_mrt_settings', esc_html__('mins', 'my-reading-time-lite' ) );
		$mrt_time_in_min  = jltmrt_options( 'mrt_time_in_min', 'jltma_mrt_settings', esc_html__('min', 'my-reading-time-lite' ) );


		if ( in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'], true ) ) {
			return $content;
		}
		
		$calculated_times = JLT_My_Reading_Time::jltmrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_mins );

		// Label Alignment before/after
		$mrt_label_position  = jltmrt_options( 'mrt_label_position', 'jltma_mrt_settings', 'before' );
		
		if( $mrt_label_position == "before"){
			$mrt_contents = '<span class="mrt-label">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> <span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span>';
		}elseif ($mrt_label_position == "after") {
			$mrt_contents = '<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span> <span class="mrt-label"> ' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>';
		}

		$content  = '<span class="jltma-mrt">' . $mrt_contents . '</span>';

		$content  .= '<div class="ma-el-page-scroll-indicator"><div class="ma-el-scroll-indicator"></div></div>';					

		$content .= $main_content;

		return $content;
	}



	public function jltma_mrt_before_excerpt( $content ){

		$main_content 	  = $content;
		$mrt_post_id      = get_the_ID();

		$jltma_mrt 		  = jltmrt_reading_time( $mrt_post_id );

		$mrt_label        = jltmrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', 'my-reading-time-lite' ) );
		$mrt_time_in_mins = jltmrt_options( 'mrt_time_in_mins', 'jltma_mrt_settings', esc_html__('mins', 'my-reading-time-lite' ) );
		$mrt_time_in_min  = jltmrt_options( 'mrt_time_in_min', 'jltma_mrt_settings', esc_html__('min', 'my-reading-time-lite' ) );


		$calculated_times = JLTMA_My_Reading_Time::jltmrt_times( $jltma_mrt, $mrt_time_in_min, $mrt_time_in_mins );


		// Label Alignment before/after
		$mrt_label_position  = jltmrt_options( 'mrt_label_position', 'jltma_mrt_settings', 'before' );
		
		if( $mrt_label_position == "before"){
			$mrt_contents = '<span class="mrt-label">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> <span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span>';
		}elseif ($mrt_label_position == "after") {
			$mrt_contents = '<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span> <span class="mrt-label"> ' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>';
		}

		
		$content  = '<span class="jltma-mrt" style="display: block;">' . $mrt_contents . '</span> ';

		$content .= $main_content;

		return $content;
	}	
}