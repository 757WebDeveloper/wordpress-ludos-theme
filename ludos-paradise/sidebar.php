<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

if (ludos_paradise_sidebar_present()) {
	ob_start();
	$ludos_paradise_sidebar_name = ludos_paradise_get_theme_option('sidebar_widgets');
	ludos_paradise_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($ludos_paradise_sidebar_name) ) {
		dynamic_sidebar($ludos_paradise_sidebar_name);
	}
	$ludos_paradise_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($ludos_paradise_out)) {
		$ludos_paradise_sidebar_position = ludos_paradise_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($ludos_paradise_sidebar_position); ?> widget_area<?php if (!ludos_paradise_is_inherit(ludos_paradise_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(ludos_paradise_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'ludos_paradise_action_before_sidebar' );
				ludos_paradise_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $ludos_paradise_out));
				do_action( 'ludos_paradise_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>