<?php
/**
 * The "News Magazine" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$widget_args = get_query_var('trx_addons_args_recent_news');
$style = $widget_args['style'];
$number = $widget_args['number'];
$count = $widget_args['count'];
$columns = $widget_args['columns'];
$featured = $widget_args['featured'];
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

if ($number==$featured+1 && (int)$number > 1 && $featured < $count && $featured!=$columns-1) {
	?><div class="post_delimiter<?php if ((int)$columns > 1) echo ' '.esc_attr(trx_addons_get_column_class(1, 1)); ?>"></div><?php
}
if ((int)$columns > 1 && !($featured==$columns-1 && $number>$featured+1)) {
	?><div class="<?php
    if($number<=$featured)
        echo esc_attr(trx_addons_get_column_class(8,12));
    else
        echo esc_attr(trx_addons_get_column_class(4, 12));

    ?>"><?php
}
?><article 
	<?php post_class( 'post_item post_layout_'.esc_attr($style)
					.' post_format_'.esc_attr($post_format)
					.' post_accented_'.($number<=$featured ? 'on' : 'off') 
					.($featured == $count && $featured > $columns ? ' post_accented_border' : '')
					); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

    if (!is_singular() || have_comments() || comments_open()) {
        $post_comments = get_comments_number();
        $temp = '<a href="'. esc_url(get_comments_link())
            .'" class="post_meta_item post_counters_item post_counters_comments trx_addons_icon-comment"><span class="post_counters_number">'
            . esc_html($post_comments)
            .'</span></a>';
    }

	
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
												'post_info' => ('<div class="post_info"><span class="post_categories">'.trx_addons_get_post_categories().'</span></div>')
                                                    . '<div class="post-info-bottom">'. ( ($number<=$featured ? '<h2' : '<h4').' class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">' . wp_kses_post( get_the_title() ) . '</a>'.($number<=$featured ? '</h2>' : '</h4>') )
                                                    . '<span class="post_date"><a href="'.esc_url(get_permalink()).'">'.get_the_date().'</a></span>'
                                                    . $temp
                                                    .'</div>',
												'thumb_size' => trx_addons_get_thumb_size($number<=$featured ? 'magazine' : 'magazines')
												), 'recent_news-magazine')
								);
?>
</article><?php

if ((int)$columns > 1 && !($featured==$columns-1 && $featured<$number && $number<$count)) {
	?></div><?php
}
?>