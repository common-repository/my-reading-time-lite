<?php
namespace JLTMRT\Inc\Classes;

use JLTMRT\JLT_My_Reading_Time;

defined( 'ABSPATH' ) || exit;

class Shortcode {

	public function __construct() {		
		add_shortcode( 'my_reading_time', array( $this, 'jltma_mrt_shortcode' ) );
	}


	public function jltma_mrt_shortcode( $atts, $content = null ){

		$atts = shortcode_atts(
			array(
				'mrt_label'        		=> '',
				'mrt_time_in_mins'     	=> '',
				'mrt_time_in_min' 	   	=> '',
				'post_id'          		=> '',
			), $atts, 'my_reading_time' );

		$mrt_post_id = $atts['post_id'] && ( get_post_status( $atts['post_id'] ) ) ? $atts['post_id'] : get_the_ID();

		$jltma_mrt 		  = jltmrt_reading_time( $mrt_post_id );

		$mrt_label = jltmrt_options( 'mrt_label', 'jltma_mrt_settings', esc_html__('Reading Time', 'my-reading-time-lite' ) );
		
		
		$calculated_times = JLT_My_Reading_Time::jltmrt_times( $jltma_mrt, $atts['mrt_time_in_min'], $atts['mrt_time_in_mins'] );


		// Label Alignment before/after
		$mrt_label_position  = jltmrt_options( 'mrt_label_position', 'jltma_mrt_settings', 'before' );
		
		if( $mrt_label_position == "before"){
			$mrt_contents = '<span class="mrt-label">' . wp_kses( $mrt_label, $jltma_mrt ) . '</span> <span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span>';
		}elseif ($mrt_label_position == "after") {
			$mrt_contents = '<span class="mrt-time"> ' . esc_html( $jltma_mrt ) . wp_kses( $calculated_times, $jltma_mrt ) . '</span> <span class="mrt-label"> ' . wp_kses( $mrt_label, $jltma_mrt ) . '</span>';
		}

		return '<span class="jltma-mrt">' . $mrt_contents . '</span>';

	}	
}