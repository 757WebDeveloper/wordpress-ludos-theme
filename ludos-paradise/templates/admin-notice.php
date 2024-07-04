<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.1
 */
 
$ludos_paradise_theme_obj = wp_get_theme();
?>
<div class="update-nag" id="ludos_paradise_admin_notice">
	<h3 class="ludos_paradise_notice_title"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(__('Welcome to %1$s v.%2$s', 'ludos-paradise'),
				$ludos_paradise_theme_obj->name . (LUDOS_PARADISE_THEME_FREE ? ' ' . __('Free', 'ludos-paradise') : ''),
				$ludos_paradise_theme_obj->version
				));
	?></h3>
	<?php
	if (!ludos_paradise_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('Attention! Plugin "ThemeREX Addons is required! Please, install and activate it!', 'ludos-paradise')); ?></p><?php
	}
	?><p>
		<a href="<?php echo esc_url(admin_url().'themes.php?page=ludos_paradise_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(__('About %s', 'ludos-paradise'), $ludos_paradise_theme_obj->name));
		?></a>
		<?php
		if (ludos_paradise_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'ludos-paradise'); ?></a>
			<?php
		}
		if (function_exists('ludos_paradise_exists_trx_addons') && ludos_paradise_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'ludos-paradise'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'ludos-paradise'); ?></a>
		<span> <?php esc_html_e('or', 'ludos-paradise'); ?> </span>
        <a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'ludos-paradise'); ?></a>
        <a href="#" class="button ludos_paradise_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'ludos-paradise'); ?></a>
	</p>
</div>