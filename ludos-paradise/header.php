<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(ludos_paradise_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php do_action( 'ludos_paradise_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap"><?php
			
			// Desktop header
			$ludos_paradise_header_type = ludos_paradise_get_theme_option("header_type");
			if ($ludos_paradise_header_type == 'custom' && !ludos_paradise_is_layouts_available())
				$ludos_paradise_header_type = 'default';
			get_template_part( "templates/header-{$ludos_paradise_header_type}");

			// Side menu
			if (in_array(ludos_paradise_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}
			
			// Mobile menu
			get_template_part( 'templates/header-navi-mobile');
			?>

			<div class="page_content_wrap">

				<?php if (ludos_paradise_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					ludos_paradise_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						ludos_paradise_create_widgets_area('widgets_above_content');

						if(function_exists('bbpress')) {
                            if(ludos_paradise_get_theme_option('show_page_title') == '1' && !is_bbpress() && !is_singular('post')) {
                            ?><div class="content-title"><?php
                                $ludos_paradise_blog_title = ludos_paradise_get_blog_title();
                                $ludos_paradise_blog_title_text = $ludos_paradise_blog_title_class = $ludos_paradise_blog_title_link = $ludos_paradise_blog_title_link_text = '';
                                if (is_array($ludos_paradise_blog_title)) {
                                    $ludos_paradise_blog_title_text = $ludos_paradise_blog_title['text'];
                                    $ludos_paradise_blog_title_class = !empty($ludos_paradise_blog_title['class']) ? ' '.$ludos_paradise_blog_title['class'] : '';
                                    $ludos_paradise_blog_title_link = !empty($ludos_paradise_blog_title['link']) ? $ludos_paradise_blog_title['link'] : '';
                                    $ludos_paradise_blog_title_link_text = !empty($ludos_paradise_blog_title['link_text']) ? $ludos_paradise_blog_title['link_text'] : '';
                                } else
                                    $ludos_paradise_blog_title_text = $ludos_paradise_blog_title;

                                echo wp_kses_data($ludos_paradise_blog_title_text);
                                ?></div><div class="content-body"><?php
                                }
                        } else {
                            if(ludos_paradise_get_theme_option('show_page_title') == '1'  && !is_singular('post')) {
                            ?><div class="content-title"><?php
                                $ludos_paradise_blog_title = ludos_paradise_get_blog_title();
                                $ludos_paradise_blog_title_text = $ludos_paradise_blog_title_class = $ludos_paradise_blog_title_link = $ludos_paradise_blog_title_link_text = '';
                                if (is_array($ludos_paradise_blog_title)) {
                                    $ludos_paradise_blog_title_text = $ludos_paradise_blog_title['text'];
                                    $ludos_paradise_blog_title_class = !empty($ludos_paradise_blog_title['class']) ? ' '.$ludos_paradise_blog_title['class'] : '';
                                    $ludos_paradise_blog_title_link = !empty($ludos_paradise_blog_title['link']) ? $ludos_paradise_blog_title['link'] : '';
                                    $ludos_paradise_blog_title_link_text = !empty($ludos_paradise_blog_title['link_text']) ? $ludos_paradise_blog_title['link_text'] : '';
                                } else
                                    $ludos_paradise_blog_title_text = $ludos_paradise_blog_title;

                                echo wp_kses_data($ludos_paradise_blog_title_text);
                                ?></div><div class="content-body"><?php
                                }
                        }


						?>