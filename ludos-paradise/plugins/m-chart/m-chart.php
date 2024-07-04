<?php
/* M-Chart support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_mchart_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_mchart_theme_setup9', 9 );
	function ludos_paradise_mchart_theme_setup9() {
		if (ludos_paradise_exists_mchart()) {

		}
		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins',		'ludos_paradise_mchart_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_mchart_tgmpa_required_plugins' ) ) {
	function ludos_paradise_mchart_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'm-chart')) {
            $path = ludos_paradise_get_file_dir('plugins/m-chart/m-chart.zip');
			$list[] = array(
				'name' 		=> ludos_paradise_storage_get_array('required_plugins', 'm-chart'),
				'slug' 		=> 'm-chart',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'ludos_paradise_exists_mchart' ) ) {
	function ludos_paradise_exists_mchart() {
		return function_exists('m_mchart');
	}
}

// This filter hook is triggered after all of the Highcharts/Chart.js chart args for a given chart have been generated.
if ( ! function_exists( 'ludos_paradise_mchart_chart_args' ) ) {
	add_filter( 'm_chart_chart_args', 'ludos_paradise_mchart_chart_args', 10, 4 );
	function ludos_paradise_mchart_chart_args( $chart_args, $post, $post_meta, $args ) {
        $colors = array(
        '#f2300d',
        '#0d233a',
        '#8bbc21',
        '#910000',
        '#1aadce',
        '#492970',
        '#f28f43',
        '#77a1e5',
        '#c42525',
        '#a6c96a',
        );

        // Apply colors, yes this kind of sucks, but so does the Chart.js color system
        if( 'line' == $chart_args['type'] && isset( $chart_args['data']['datasets'] ) ) {
            foreach ( $chart_args['data']['datasets'] as $key => $dataset ) {
                $color = $colors[ $key % count( $colors ) ];

                $chart_args['data']['datasets'][ $key ]['fill'] = false;
                $chart_args['data']['datasets'][ $key ]['backgroundColor'] = $color;
                $chart_args['data']['datasets'][ $key ]['borderColor'] = $color;
                $chart_args['data']['datasets'][ $key ]['lineTension'] = 0;
            }
        }

        return $chart_args;
	}
}


?>