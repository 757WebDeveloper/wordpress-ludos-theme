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
	// Match date
	?><span class="sc_matches_item_date"><span class="sc_matches_item_date_wrap">
		<span class="sc_matches_item_day"><?php echo date_i18n("M d, Y", strtotime($meta['date_start'])); ?></span>
		<span class="sc_matches_item_time"><?php echo date_i18n("H:i (e)", strtotime($meta['time_start'])); ?></span>
	</span></span><?php
	// Match info
	?><span class="sc_matches_item_info"><?php
		// If competition's type is 'pair'
		if (isset($meta['player1'])) {
			$player1 = !empty($meta['player1']) ? get_the_title($meta['player1']) : '';
			$player1_meta = get_post_meta( $meta['player1'], 'trx_addons_options', true );
			$player1_logo = trx_addons_get_attachment_url( get_post_thumbnail_id( $meta['player1'] ), trx_addons_get_thumb_size('tiny') );
			if (!empty($player1_logo)) $player1_attr = trx_addons_getimagesize($player1_logo);
			$player2 = !empty($meta['player2']) ? get_the_title($meta['player2']) : '';
			$player2_meta = get_post_meta( $meta['player2'], 'trx_addons_options', true );
			$player2_logo = trx_addons_get_attachment_url( get_post_thumbnail_id( $meta['player2'] ), trx_addons_get_thumb_size('tiny') );
			if (!empty($player2_logo)) $player2_attr = trx_addons_getimagesize($player2_logo);
			// First player
			?><span class="sc_matches_item_name1">
				<h4 class="sc_matches_item_title"><?php echo esc_html($player1); ?></h4><?php
				if (!empty($player1_meta['club'])) {
					?><span class="sc_matches_item_club"><?php echo esc_html($player1_meta['club']); ?></span><?php
				}
			?></span><?php
            ?><span class="sc_matches_item_logo1"><img src="<?php echo esc_url($player1_logo); ?>" alt="Logo1" <?php if (!empty($player1_attr[3])) trx_addons_show_layout($player1_attr[3]);?>></span><?php

            // Score
			?><span class="sc_matches_item_score">
				<?php
					if (is_rtl())
					{
						if ( empty($meta['score']) )
						{
							echo esc_html__('vs', 'ludos-paradise');
						}
						else
						{
							$meta_score = explode(":", $meta['score']);
							echo esc_html($meta_score[1] . ":" . $meta_score[0]);
						}
					}
					else
					{
						echo empty($meta['score']) ? esc_html__('vs', 'ludos-paradise') : $meta['score'];
					}
				?>
			</span>
			<?php
			// Second player

			?><span class="sc_matches_item_logo2"><img src="<?php echo esc_url($player2_logo); ?>" alt="Logo2" <?php if (!empty($player2_attr[3])) trx_addons_show_layout($player2_attr[3]);?>></span><?php
            ?><span class="sc_matches_item_name2">
            <h4 class="sc_matches_item_title"><?php echo esc_html($player2); ?></h4><?php
            if (!empty($player2_meta['club'])) {
                ?><span class="sc_matches_item_club"><?php echo esc_html($player2_meta['club']); ?></span><?php
            }
            ?></span><?php
	
		// If competition's type is 'pair'
		} else {
			// Name of the match
			?><span class="sc_matches_item_name"><?php echo esc_html($match['title']); ?></span><?php
		}
	?></span><?php
?></a></div>