<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

ludos_paradise_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	ludos_paradise_show_layout(get_query_var('blog_archive_start'));

	$ludos_paradise_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$ludos_paradise_sticky_out = ludos_paradise_get_theme_option('sticky_style')=='columns' 
							&& is_array($ludos_paradise_stickies) && count($ludos_paradise_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$ludos_paradise_cat = ludos_paradise_get_theme_option('parent_cat');
	$ludos_paradise_post_type = ludos_paradise_get_theme_option('post_type');
	$ludos_paradise_taxonomy = ludos_paradise_get_post_type_taxonomy($ludos_paradise_post_type);
	$ludos_paradise_show_filters = ludos_paradise_get_theme_option('show_filters');
	$ludos_paradise_tabs = array();
	if (!ludos_paradise_is_off($ludos_paradise_show_filters)) {
		$ludos_paradise_args = array(
			'type'			=> $ludos_paradise_post_type,
			'child_of'		=> $ludos_paradise_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $ludos_paradise_taxonomy,
			'pad_counts'	=> false
		);
		$ludos_paradise_portfolio_list = get_terms($ludos_paradise_args);
		if (is_array($ludos_paradise_portfolio_list) && count($ludos_paradise_portfolio_list) > 0) {
			$ludos_paradise_tabs[$ludos_paradise_cat] = esc_html__('All', 'ludos-paradise');
			foreach ($ludos_paradise_portfolio_list as $ludos_paradise_term) {
				if (isset($ludos_paradise_term->term_id)) $ludos_paradise_tabs[$ludos_paradise_term->term_id] = $ludos_paradise_term->name;
			}
		}
	}
	if (count($ludos_paradise_tabs) > 0) {
		$ludos_paradise_portfolio_filters_ajax = true;
		$ludos_paradise_portfolio_filters_active = $ludos_paradise_cat;
		$ludos_paradise_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters ludos_paradise_tabs ludos_paradise_tabs_ajax">
			<ul class="portfolio_titles ludos_paradise_tabs_titles">
				<?php
				foreach ($ludos_paradise_tabs as $ludos_paradise_id=>$ludos_paradise_title) {
					?><li><a href="<?php echo esc_url(ludos_paradise_get_hash_link(sprintf('#%s_%s_content', $ludos_paradise_portfolio_filters_id, $ludos_paradise_id))); ?>" data-tab="<?php echo esc_attr($ludos_paradise_id); ?>"><?php echo esc_html($ludos_paradise_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$ludos_paradise_ppp = ludos_paradise_get_theme_option('posts_per_page');
			if (ludos_paradise_is_inherit($ludos_paradise_ppp)) $ludos_paradise_ppp = '';
			foreach ($ludos_paradise_tabs as $ludos_paradise_id=>$ludos_paradise_title) {
				$ludos_paradise_portfolio_need_content = $ludos_paradise_id==$ludos_paradise_portfolio_filters_active || !$ludos_paradise_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $ludos_paradise_portfolio_filters_id, $ludos_paradise_id)); ?>"
					class="portfolio_content ludos_paradise_tabs_content"
					data-blog-template="<?php echo esc_attr(ludos_paradise_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(ludos_paradise_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($ludos_paradise_ppp); ?>"
					data-post-type="<?php echo esc_attr($ludos_paradise_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($ludos_paradise_taxonomy); ?>"
					data-cat="<?php echo esc_attr($ludos_paradise_id); ?>"
					data-parent-cat="<?php echo esc_attr($ludos_paradise_cat); ?>"
					data-need-content="<?php echo (false===$ludos_paradise_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($ludos_paradise_portfolio_need_content) 
						ludos_paradise_show_portfolio_posts(array(
							'cat' => $ludos_paradise_id,
							'parent_cat' => $ludos_paradise_cat,
							'taxonomy' => $ludos_paradise_taxonomy,
							'post_type' => $ludos_paradise_post_type,
							'page' => 1,
							'sticky' => $ludos_paradise_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		ludos_paradise_show_portfolio_posts(array(
			'cat' => $ludos_paradise_cat,
			'parent_cat' => $ludos_paradise_cat,
			'taxonomy' => $ludos_paradise_taxonomy,
			'post_type' => $ludos_paradise_post_type,
			'page' => 1,
			'sticky' => $ludos_paradise_sticky_out
			)
		);
	}

	ludos_paradise_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>