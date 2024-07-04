<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_seo = ludos_paradise_is_on(ludos_paradise_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post-excerpt post_type_'.esc_attr(get_post_type())
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($ludos_paradise_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(ludos_paradise_get_markup_schema()); ?>"
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('ludos_paradise_action_before_post_data');
    // Post title
    if (!ludos_paradise_sc_layouts_showed('title')) {
        the_title( '<div class="excerpt-title"><h3 class="post_title entry-title"'.($ludos_paradise_seo ? ' itemprop="headline"' : '').'>', '</h3></div>' );
    }
    ?><div class="exerpt-body"><?php
	// Structured data snippets
	if ($ludos_paradise_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( ludos_paradise_is_off(ludos_paradise_get_theme_option('hide_featured_on_single'))
			&& !ludos_paradise_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('ludos_paradise_action_before_post_featured'); 
		ludos_paradise_show_post_featured();
		do_action('ludos_paradise_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!ludos_paradise_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('ludos_paradise_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post meta
			if (!ludos_paradise_sc_layouts_showed('postmeta') && ludos_paradise_is_on(ludos_paradise_get_theme_option('show_post_meta'))) {
				ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
					'components' => ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('meta_parts')),
					'counters' => ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('counters')),
					'seo' => ludos_paradise_is_on(ludos_paradise_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('ludos_paradise_action_after_post_title'); 
	}

	do_action('ludos_paradise_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('ludos_paradise_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'ludos-paradise' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ludos-paradise' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );


    // Taxonomies and share
    if (is_single() && !is_attachment()) {

        do_action('ludos_paradise_action_before_post_meta');

        ?>
        <div class="post_meta post_meta_single"><?php

        // Share
        if (ludos_paradise_is_on(ludos_paradise_get_theme_option('show_share_links'))) {
            ludos_paradise_show_share_links(array(
                'type' => 'block',
                'caption' => '',
                'before' => '<span class="post_meta_item post_share">',
                'after' => '</span>'
            ));
        }

        // Post taxonomies
        the_tags('<span class="post_meta_item post_tags">', ' ', '</span>');

        ?></div><?php

        do_action('ludos_paradise_action_after_post_meta');
    }

		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('ludos_paradise_action_after_post_content'); 


	?></div>
</article>
<?php
// Author bio.
if ( ludos_paradise_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {	
    do_action('ludos_paradise_action_before_post_author');
    get_template_part( 'templates/author-bio' );
    do_action('ludos_paradise_action_after_post_author');
}
?>