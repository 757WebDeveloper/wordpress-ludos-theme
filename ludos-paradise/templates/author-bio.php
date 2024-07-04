<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */
?>

<div class="author_info scheme_dark author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">
    <div class="author-info"><?php esc_html_e('About Author','ludos-paradise');?></div>
    <div class="author-content">
        <div class="author_avatar" itemprop="image">
            <?php
            $ludos_paradise_mult = ludos_paradise_get_retina_multiplier();
            echo get_avatar( get_the_author_meta( 'user_email' ), 120*$ludos_paradise_mult );
            ?>
        </div><!-- .author_avatar -->

        <div class="author_description">
            <h3 class="author_title" itemprop="name"><?php
                // Translators: Add the author's name in the <span>
                echo wp_kses_data(sprintf(__('%s', 'ludos-paradise'), '<span class="fn">'.get_the_author().'</span>'));
            ?></h3>

            <div class="author_bio" itemprop="description">
                <?php echo wp_kses(wpautop(get_the_author_meta( 'description' )), 'ludos_paradise_kses_content'); ?>
            </div><!-- .author_bio -->

        </div><!-- .author_description -->
    </div>

</div><!-- .author_info -->
