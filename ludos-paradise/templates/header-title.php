<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

// Page (category, tag, archive, author) title

if ( ludos_paradise_need_page_title() ) {
	ludos_paradise_sc_layouts_showed('title', true);
	ludos_paradise_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
									'components' => ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('meta_parts')),
									'counters' => ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('counters')),
									'seo' => ludos_paradise_is_on(ludos_paradise_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$ludos_paradise_blog_title = ludos_paradise_get_blog_title();
							$ludos_paradise_blog_title_text = $ludos_paradise_blog_title_class = $ludos_paradise_blog_title_link = $ludos_paradise_blog_title_link_text = '';
							if (is_array($ludos_paradise_blog_title)) {
								$ludos_paradise_blog_title_text = $ludos_paradise_blog_title['text'];
								$ludos_paradise_blog_title_class = !empty($ludos_paradise_blog_title['class']) ? ' '.$ludos_paradise_blog_title['class'] : '';
								$ludos_paradise_blog_title_link = !empty($ludos_paradise_blog_title['link']) ? $ludos_paradise_blog_title['link'] : '';
								$ludos_paradise_blog_title_link_text = !empty($ludos_paradise_blog_title['link_text']) ? $ludos_paradise_blog_title['link_text'] : '';
							} else
								$ludos_paradise_blog_title_text = $ludos_paradise_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($ludos_paradise_blog_title_class); ?>"><?php
								$ludos_paradise_top_icon = ludos_paradise_get_category_icon();
								if (!empty($ludos_paradise_top_icon)) {
									$ludos_paradise_attr = ludos_paradise_getimagesize($ludos_paradise_top_icon);
									?><img src="<?php echo esc_url($ludos_paradise_top_icon); ?>" alt="Image" <?php if (!empty($ludos_paradise_attr[3])) ludos_paradise_show_layout($ludos_paradise_attr[3]);?>><?php
								}
								echo wp_kses_post($ludos_paradise_blog_title_text);
							?></h1>
							<?php
							if (!empty($ludos_paradise_blog_title_link) && !empty($ludos_paradise_blog_title_link_text)) {
								?><a href="<?php echo esc_url($ludos_paradise_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($ludos_paradise_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'ludos_paradise_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>