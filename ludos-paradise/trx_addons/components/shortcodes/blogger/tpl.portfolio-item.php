<?php
/**
 * The style "default" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_blogger');

if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ((int)$args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}

$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$post_link = empty($args['no_links']) ? get_permalink() : '';
$post_title = get_the_title();

?><div <?php post_class( 'sc_blogger_item post_format_'.esc_attr($post_format) . (empty($post_link) ? ' no_links' : '') ); ?>><?php

	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_blogger_item_featured',
														'hover' => 'zoomin',
														'no_links' => empty($post_link),
														'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($args['columns'] > 2 ? 'vertical' : 'big'), 'blogger-default')
														), 'blogger-default')
								);

ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
        'components' => 'categories',
        'counters' => '',
        'seo' => false
    ), 'excerpt', 1)
);

	// Post content
	?><div class="sc_blogger_item_content entry-content"><?php

		// Post title
		if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
			?><div class="sc_blogger_item_header entry-header"><?php
            do_action('ludos_paradise_action_before_post_title');

            // Post title
            the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );

            do_action('ludos_paradise_action_before_post_meta');

                ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
                        'components' => 'date,counters',
                        'counters' => 'comments',
                        'seo' => false
                    ), 'excerpt', 1)
                );
			?></div><!-- .entry-header --><?php
		}
		
	?></div><!-- .entry-content --><?php
	
?></div><!-- .sc_blogger_item --><?php

if ($args['slider'] || (int)$args['columns'] > 1) {
	?></div><?php
}
?>