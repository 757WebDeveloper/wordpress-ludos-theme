<?php
/**
 * The style "default" of the shortcode Matches (section "Other matches")
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.17
 */

$match = get_query_var('trx_addons_args_sc_matches_item');

$meta = $match['meta'];

?><div class="sc_matches_item"><a href="<?php the_permalink($match['id']); ?>" class="sc_matches_item_link"><?php
	// Match info
	?><div class="sc_matches_item_info"><?php
		// If competition's type is 'pair'
		if (isset($meta['player1'])) {
			$player1 = !empty($meta['player1']) ? get_the_title($meta['player1']) : '';
			$player1_meta = get_post_meta( $meta['player1'], 'trx_addons_options', true );
			$player2 = !empty($meta['player2']) ? get_the_title($meta['player2']) : '';
			$player2_meta = get_post_meta( $meta['player2'], 'trx_addons_options', true );

            ?><span class="sc_matches_item_match"><?php esc_html_e('Match', 'ludos-paradise'); ?></span><?php

			// First player
			?><span class="sc_matches_item_title"><?php echo esc_html($player1); ?></span><?php

            ?> <span class="sc_matches_item_vs"><?php esc_html_e('vs', 'ludos-paradise'); ?></span> <?php
            // Second player
            ?><span class="sc_matches_item_title"><?php echo esc_html($player2); ?></span><?php

		// If competition's type is 'pair'
		} else {
			// Name of the match
			?><span class="sc_matches_item_name"><?php echo esc_html($match['title']); ?></span><?php
		}
	?></div><?php
        // Match date
        ?><div class="sc_matches_item_date"><span class="sc_matches_item_date_wrap">
		<span class="sc_matches_item_day"><?php echo date_i18n("M d", strtotime($meta['date_start'])); ?></span>
	</span></div><?php
?></a></div>