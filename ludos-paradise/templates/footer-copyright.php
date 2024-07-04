<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!ludos_paradise_is_inherit(ludos_paradise_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(ludos_paradise_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				$ludos_paradise_copyright = ludos_paradise_get_theme_option('copyright');
				if (!empty($ludos_paradise_copyright)) {
					$ludos_paradise_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $ludos_paradise_copyright);
					$ludos_paradise_copyright = ludos_paradise_prepare_macros($ludos_paradise_copyright);
					echo wp_kses_data(nl2br($ludos_paradise_copyright));
				}
			?></div>
		</div>
	</div>
</div>
