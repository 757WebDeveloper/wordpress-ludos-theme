<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.10
 */

// Footer sidebar
$ludos_paradise_footer_name = ludos_paradise_get_theme_option('footer_widgets');
$ludos_paradise_footer_present = !ludos_paradise_is_off($ludos_paradise_footer_name) && is_active_sidebar($ludos_paradise_footer_name);
if ($ludos_paradise_footer_present) { 
	ludos_paradise_storage_set('current_sidebar', 'footer');
	$ludos_paradise_footer_wide = ludos_paradise_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($ludos_paradise_footer_name) ) {
		dynamic_sidebar($ludos_paradise_footer_name);
	}
	$ludos_paradise_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($ludos_paradise_out)) {
		$ludos_paradise_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $ludos_paradise_out);
		$ludos_paradise_need_columns = true;	
		if ($ludos_paradise_need_columns) {
			$ludos_paradise_columns = max(0, (int) ludos_paradise_get_theme_option('footer_columns'));
			if ($ludos_paradise_columns == 0) $ludos_paradise_columns = min(4, max(1, substr_count($ludos_paradise_out, '<aside ')));
			if ($ludos_paradise_columns > 1)
				$ludos_paradise_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($ludos_paradise_columns).' widget', $ludos_paradise_out);
			else
				$ludos_paradise_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($ludos_paradise_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$ludos_paradise_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($ludos_paradise_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'ludos_paradise_action_before_sidebar' );
				ludos_paradise_show_layout($ludos_paradise_out);
				do_action( 'ludos_paradise_action_after_sidebar' );
				if ($ludos_paradise_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$ludos_paradise_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>