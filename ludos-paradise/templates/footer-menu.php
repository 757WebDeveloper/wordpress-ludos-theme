<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.10
 */

// Footer menu
$ludos_paradise_menu_footer = ludos_paradise_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($ludos_paradise_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php ludos_paradise_show_layout($ludos_paradise_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>