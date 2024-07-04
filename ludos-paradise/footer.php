<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */
			if(function_exists('bbpress')) {
			    if (ludos_paradise_get_theme_option('show_page_title') == '1' && !is_bbpress() && !is_singular('post')) {
			    ?></div><?php
			    }
			} else {
			    if (ludos_paradise_get_theme_option('show_page_title') == '1'  && !is_singular('post')) {
			    ?></div><?php
			    }
			}
				// Widgets area inside page content
				ludos_paradise_create_widgets_area('widgets_below_content');
				?>
			</div><!-- </.content> -->
			
			<?php
			// Show main sidebar
			get_sidebar();
			
			// Widgets area below page content
			ludos_paradise_create_widgets_area('widgets_below_page');
			
			$ludos_paradise_body_style = ludos_paradise_get_theme_option('body_style');
			if ($ludos_paradise_body_style != 'fullscreen') {
				?></div><!-- </.content_wrap> --><?php
			}
			?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$ludos_paradise_footer_type = ludos_paradise_get_theme_option("footer_type");
			if ($ludos_paradise_footer_type == 'custom' && !ludos_paradise_is_layouts_available())
				$ludos_paradise_footer_type = 'default';
			get_template_part( "templates/footer-{$ludos_paradise_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (ludos_paradise_is_on(ludos_paradise_get_theme_option('debug_mode')) && ludos_paradise_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(ludos_paradise_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>