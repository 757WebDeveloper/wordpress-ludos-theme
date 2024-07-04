<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.14
 */
$ludos_paradise_header_video = ludos_paradise_get_header_video();
$ludos_paradise_embed_video = '';
if (!empty($ludos_paradise_header_video) && !ludos_paradise_is_from_uploads($ludos_paradise_header_video)) {
	if (ludos_paradise_is_youtube_url($ludos_paradise_header_video) && preg_match('/[=\/]([^=\/]*)$/', $ludos_paradise_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$ludos_paradise_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($ludos_paradise_header_video) . '[/embed]' ));
			$ludos_paradise_embed_video = ludos_paradise_make_video_autoplay($ludos_paradise_embed_video);
		} else {
			$ludos_paradise_header_video = str_replace('/watch?v=', '/embed/', $ludos_paradise_header_video);
			$ludos_paradise_header_video = ludos_paradise_add_to_url($ludos_paradise_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$ludos_paradise_embed_video = '<iframe src="' . esc_url($ludos_paradise_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php ludos_paradise_show_layout($ludos_paradise_embed_video); ?></div><?php
	}
}
?>