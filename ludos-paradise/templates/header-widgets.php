<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

// Header sidebar
$ludos_paradise_header_name = ludos_paradise_get_theme_option('header_widgets');
$ludos_paradise_header_present = !ludos_paradise_is_off($ludos_paradise_header_name) && is_active_sidebar($ludos_paradise_header_name);
if ($ludos_paradise_header_present) { 
	ludos_paradise_storage_set('current_sidebar', 'header');
	$ludos_paradise_header_wide = ludos_paradise_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($ludos_paradise_header_name) ) {
		dynamic_sidebar($ludos_paradise_header_name);
	}
	$ludos_paradise_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($ludos_paradise_widgets_output)) {
		$ludos_paradise_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $ludos_paradise_widgets_output);
		$ludos_paradise_need_columns = strpos($ludos_paradise_widgets_output, 'columns_wrap')===false;
		if ($ludos_paradise_need_columns) {
			$ludos_paradise_columns = max(0, (int) ludos_paradise_get_theme_option('header_columns'));
			if ($ludos_paradise_columns == 0) $ludos_paradise_columns = min(6, max(1, substr_count($ludos_paradise_widgets_output, '<aside ')));
			if ($ludos_paradise_columns > 1)
				$ludos_paradise_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($ludos_paradise_columns).' widget', $ludos_paradise_widgets_output);
			else
				$ludos_paradise_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($ludos_paradise_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$ludos_paradise_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($ludos_paradise_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'ludos_paradise_action_before_sidebar' );
				ludos_paradise_show_layout($ludos_paradise_widgets_output);
				do_action( 'ludos_paradise_action_after_sidebar' );
				if ($ludos_paradise_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$ludos_paradise_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>