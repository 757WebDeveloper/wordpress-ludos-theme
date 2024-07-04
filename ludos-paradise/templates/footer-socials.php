<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.10
 */


// Socials
if ( ludos_paradise_is_on(ludos_paradise_get_theme_option('socials_in_footer')) && ($ludos_paradise_output = ludos_paradise_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php ludos_paradise_show_layout($ludos_paradise_output); ?>
		</div>
	</div>
	<?php
}
?>