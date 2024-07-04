<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('ludos_paradise_trx_addons_get_mycss')) {
	add_filter('ludos_paradise_filter_get_css', 'ludos_paradise_trx_addons_get_mycss', 10, 4);
	function ludos_paradise_trx_addons_get_mycss($css, $colors, $fonts, $scheme='') {

        if (isset($css['fonts']) && $fonts) {
            $css['fonts'] .= <<<CSS
            .sc_button_simple,
            .nav-links-more,
            .wpb_widgetised_column .widget .widget_title,
            .sidebar[class*="scheme_"] .widget .widget_title,
            .sc_skills .sc_skills_total,
            .author-info,
            .sc_action_item_default .sc_action_item_subtitle,
            .sc_matches_item_score1,
            .sc_matches_other .sc_matches_item_score,
            .sc_matches_item_pair .sc_matches_item_score_value,
            .post-excerpt .excerpt-title .post_title,
            .trx_addons_dropcap {
                {$fonts['h1_font-family']}
            }
            aside .post_item .post_title,
            .widget_area .post_item .post_title, 
            .mejs-controls .mejs-time * {
                {$fonts['p_font-family']}
            }

CSS;
        }

        if (isset($css['colors']) && $colors) {
            $css['colors'] .= <<<CSS
            
            /* Inline colors */
            .trx_addons_accent,
            .trx_addons_accent_big,
            .trx_addons_accent > a,
            .trx_addons_accent > * {
                color: {$colors['text_link']};
            }
            .trx_addons_accent_hovered,
            .trx_addons_accent_hovered,
            .trx_addons_accent_hovered > a,
            .trx_addons_accent_hovered > * {
                color: {$colors['text_dark']};
            }
            .trx_addons_accent_bg {
                background-color: {$colors['text_link']};
                color: {$colors['inverse_link']};
            }

            
            /* Tooltip */
            .trx_addons_tooltip {
                color: {$colors['text_dark']};
                border-color: {$colors['text_dark']};
            }
            .trx_addons_tooltip:before {
                background-color: {$colors['text_dark']};
                color: {$colors['text_link2']};
            }
            .trx_addons_tooltip:after {
                border-top-color: {$colors['text_dark']};
            }
            
            
            /* Dropcaps */
            .trx_addons_dropcap_style_1 {
                background-color: {$colors['bg_color_0']};
                color: {$colors['text_link']};
            }
            .trx_addons_dropcap_style_2 {
                background-color: {$colors['bg_color_0']};
                color: {$colors['text_dark']};
            }
            
            /* Blockqoute */
            blockquote {
                color: {$colors['text_dark']};
                background-color: {$colors['bg_color_0']};
                border-left-color: {$colors['text_link']};
            }
            blockquote cite a,
            blockquote > a, blockquote > p > a,
            blockquote > cite, blockquote > p > cite {
                color: {$colors['text']};
            }
            blockquote cite a:hover,
            blockquote > a, blockquote > p > a:hover {
                color: {$colors['text_link']};
            }
            blockquote:before {
                color: {$colors['inverse_link']};
            }
            
            /* Images */
				.wp-block-gallery.has-nested-images figure.wp-block-image figcaption,
            figure figcaption,
            .wp-caption .wp-caption-text,
            .wp-caption .wp-caption-dd,
            .wp-caption-overlay .wp-caption .wp-caption-dd,
            .wp-caption-overlay .wp-caption .wp-caption-text,
            .wp-block-gallery .blocks-gallery-image figcaption,
			.wp-block-gallery .blocks-gallery-item figcaption,
			.blocks-gallery-grid .blocks-gallery-image figcaption,
			.blocks-gallery-grid .blocks-gallery-item figcaption {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
                background-image: linear-gradient(to bottom, {$colors['text_link3']} 0%, {$colors['bg_color_0']} 100%);
                border-color: {$colors['text_hover2']};
            }
            
            
            /* Lists */
            ul[class*="trx_addons_list"].trx_addons_list_square > li {
                color: {$colors['text_dark']};
            }
            ul[class*="trx_addons_list"].trx_addons_list_square > li:before {
                background-color: {$colors['text_link']};
            }
          
            
            /* Table */
            table th {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
                background-image: linear-gradient(to bottom, {$colors['text_link3']} 0%, {$colors['bg_color_0']} 100%);
            }
            table th, table th + th, table td + th  {
                border-color: {$colors['text_hover2']};
            }
            table td, table th + td, table td + td {
                color: {$colors['text']};
                border-color: {$colors['alter_bd_hover']};
            }
            table > tbody > tr:nth-child(2n+1) > td {
                background-color: {$colors['extra_bg_color']};
            }
            table > tbody > tr:nth-child(2n) > td {
                background-color: {$colors['alter_bg_hover']};
            }
            th a {
                color: {$colors['inverse_link']};
            }

            /* Main menu */
            .sc_layouts_menu_nav>li>a {
                color: {$colors['text']} !important;
            }
            .sc_layouts_menu_nav>li>a:hover,
            .sc_layouts_menu_nav>li.sfHover>a,
            .sc_layouts_menu_nav>li.current-menu-item>a,
            .sc_layouts_menu_nav>li.current-menu-parent>a,
            .sc_layouts_menu_nav>li.current-menu-ancestor>a {
                color: {$colors['text_hover3']} !important;
            }
            /* Dropdown menu */
            .sc_layouts_menu_nav>li ul {
                background-color: {$colors['alter_bg_hover']};
                border-color: {$colors['bd_color']};
            }
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li>a,
            .sc_layouts_menu_nav>li li>a {
                color: {$colors['text_dark']} !important;
            }
            .sc_layouts_menu_nav>li li>a:hover:after,
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li>a:hover,
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li.sfHover>a,
            .sc_layouts_menu_nav>li li>a:hover,
            .sc_layouts_menu_nav>li li.sfHover>a,
            .sc_layouts_menu_nav>li li.current-menu-item>a,
            .sc_layouts_menu_nav>li li.current-menu-parent>a,
            .sc_layouts_menu_nav>li li.current-menu-ancestor>a {
                color: {$colors['text_hover3']} !important;
                background-color: {$colors['bg_color_0']};
            }
            
            /* Breadcrumbs */
            .sc_layouts_title_caption {
                color: {$colors['text_dark']};
            }
            .sc_layouts_title_breadcrumbs,
            .sc_layouts_title_breadcrumbs a {
                color: {$colors['text_dark']} !important;
            }
            .breadcrumbs_item.current{
                color: {$colors['text_dark']} !important;
            }
            .sc_layouts_title_breadcrumbs a:hover {
                color: {$colors['text_hover']} !important;
            }
            
            /* Slider */
            .slider_container .slider_pagination_wrap .swiper-pagination-bullet,
            .slider_outer .slider_pagination_wrap .swiper-pagination-bullet,
            .swiper-pagination-custom .swiper-pagination-button {
                border-color: {$colors['text_hover']};
                background-color: {$colors['alter_bd_color']};
            }
            .swiper-pagination-custom .swiper-pagination-button.swiper-pagination-button-active,
            .slider_container .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
            .slider_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
            .slider_container .slider_pagination_wrap .swiper-pagination-bullet:hover,
            .slider_outer .slider_pagination_wrap .swiper-pagination-bullet:hover {
                border-color: {$colors['inverse_link']};
                background-color: {$colors['text_link']};
            }
            
            .sc_slider_controls .slider_controls_wrap > a,
            .slider_container.slider_controls_side .slider_controls_wrap > a,
            .slider_outer_controls_side .slider_controls_wrap > a {
                color: {$colors['text_dark']};
                background-color: {$colors['bg_color']};
                border-color: {$colors['bg_color']};
            }
            .sc_slider_controls .slider_controls_wrap > a:hover,
            .slider_container.slider_controls_side .slider_controls_wrap > a:hover,
            .slider_outer_controls_side .slider_controls_wrap > a:hover {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
                border-color: {$colors['text_hover']};
            }
            
            
            /* Layouts */
            .sc_layouts_logo .logo_text {
                color: {$colors['text_dark']};
            }
            

            /* Shortcodes */
            .sc_skills_pie.sc_skills_compact_off .sc_skills_total {
                color: {$colors['text_dark']};
            }
            .sc_skills_pie.sc_skills_compact_off .sc_skills_item_title {
                color: {$colors['text']};
            }
            .sc_countdown .sc_countdown_label{
                color: {$colors['text_dark']};
                background: {$colors['bg_color_0']};
            }
            .sc_countdown_default .sc_countdown_digits span {
                color: {$colors['text_hover']};
                background: {$colors['bg_color_0']};
            }
            
            /* Audio */
            .trx_addons_audio_player.without_cover,
            .format-audio .post_featured.without_thumb .post_audio {
                background-color: {$colors['alter_bg_hover']} !important;
                border-color: {$colors['bd_color']};
                background-image: linear-gradient(-160deg, {$colors['bd_color_05']} 0%, {$colors['bg_color_0']} 100%);
            }
            .format-audio .post_featured.without_thumb .mejs-controls,
            .trx_addons_audio_player.without_cover .mejs-controls {
                background: {$colors['bg_color_0']};
            }
            .format-audio .post_featured.without_thumb .mejs-container,
            .trx_addons_audio_player.without_cover .mejs-container {
                background: {$colors['bg_color_0']};
            }
            .format-audio .post_featured.without_thumb .post_audio_author,
            .trx_addons_audio_player.without_cover .audio_author {
                color: {$colors['text_hover']};
            }
            .format-audio .post_featured.without_thumb .mejs-controls .mejs-time,
            .trx_addons_audio_player.without_cover .mejs-time {
                color: {$colors['text_dark']};
            }
            .mejs-controls .mejs-button > button {
                background: {$colors['bg_color_0']} !important;
                color: {$colors['text_dark']}!important;
            }
            .mejs-controls .mejs-button > button:hover {
                background: {$colors['bg_color_0']} !important;
                color: {$colors['text_hover3']}!important;
            }
            .mejs-controls .mejs-horizontal-volume-total:before,
            .mejs-controls .mejs-time-rail .mejs-time-total,
            .mejs-controls .mejs-time-rail .mejs-time-loaded,
            .mejs-controls .mejs-volume-slider .mejs-volume-total,
            .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
                background: {$colors['text_dark_02']};
            }
            .mejs-controls .mejs-time-rail .mejs-time-hovered {
                background: {$colors['text_hover']};
            }
            .mejs-controls .mejs-time-rail .mejs-time-current,
            .mejs-controls .mejs-volume-slider .mejs-volume-current,
            .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
                background: {$colors['text_link']};
            }
            .format-audio .post_featured.without_thumb .post_audio:after,
            .trx_addons_audio_player.without_cover:after {
                background: {$colors['alter_bd_color']};
            }
            .format-audio .post_featured.without_thumb .post_audio:after, .trx_addons_audio_player.without_cover:after {
                background: {$colors['text_dark']};
            }
            
            /* Video */
            .trx_addons_video_player.with_cover .video_hover,
            .format-video .post_featured.with_thumb .post_video_hover {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
            }
            .trx_addons_video_player.with_cover .video_hover:hover,
            .format-video .post_featured.with_thumb .post_video_hover:hover {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover3']};
            }
            
            
            /* Price */
            .sc_price_item {
                color: {$colors['text_dark']};
                background-color: {$colors['alter_bg_color']};
                border-color: {$colors['extra_light']};
            }
            .sc_price_item:hover {
                color: {$colors['text_dark']};
                background-color: {$colors['alter_bg_color']};
                border-color: {$colors['extra_light']};
            }
            .sc_price_item:hover .sc_price_item_title,
            .sc_price_item .sc_price_item_title,
            .sc_price_item .sc_price_item_title a {
                color: {$colors['text_dark']};
            }
            .sc_price_item:hover .sc_price_item_title a {
                color: {$colors['text_link']};
            }
            .sc_price_item .sc_price_item_price {
                color: {$colors['text']};
            }
            .sc_price_item .sc_price_item_description{
                color: {$colors['text']};
            }
            .sc_price_item .sc_price_item_details {
                color: {$colors['text']};
            }
            .sc_price_item_price .sc_price_item_price_value {
                color: {$colors['text_link']};
            }
            .sc_icons .sc_icons_item_title,
            .comment-author-link {
                color: {$colors['text_dark']};
            }
            .widget_search form:before{
                background-color: {$colors['bd_color']};
            }
            .widget_area .post_item .post_info .post_info_posted:before {
                color: {$colors['text_link']};
            }
            .sc_icons .sc_icons_item_description,
            .sc_icons a,
            .nav-links-more a,
            .footer_wrap .sc_icons .sc_icons_icon,
            .wpb_widgetised_column .widget_recent_comments ul li > a,
            .sidebar .widget_recent_comments ul li > a {
                color: {$colors['text']};
            }
            .wpb_widgetised_column .widget_recent_comments ul li > a:hover,
            .sidebar .widget_recent_comments ul li > a:hover {
                color: {$colors['text_link']};
            }
            .sc_icons a:hover,
            .nav-links-more a:hover,
            .footer_wrap .sc_icons .sc_icons_item_linked:hover .sc_icons_item_title,
            .footer_wrap .sc_icons .sc_icons_item_linked:hover .sc_icons_icon {
                color: {$colors['text_hover3']};
            }
            .footer_wrap .sc_icons .sc_icons_columns_wrap  > div + div:before {
                background-color: {$colors['extra_bg_hover']};
            }
            .post_layout_excerpt .post_featured,
            .post_layout_excerpt.sticky .post_header,
            .sc_googlemap_wrap,
            .nav-links-more,
            .m-chart-container,
            .slider_wrap,
            .trx_addons_video_player {
                border-color: {$colors['bd_color']};
            }
            .sc_skills .sc_skills_item_title {
                color: {$colors['text_link']};
            }
            .sc_skills .sc_skills_total {
                color: {$colors['text_dark']};
            }
            .sc_icons.sc_align_left .sc_icons_item + .sc_icons_item:before{
                background-color: {$colors['bd_color']};
            }
            .post_layout_chess,
            .post_item_single.post_format_audio .mejs-container,
            .m-chart-container {
                background-color: {$colors['bg_color']};
            }
            .post_layout_excerpt.sticky .post_header {
                background-color: {$colors['alter_bg_hover']} !important;
                border-color: {$colors['bd_color']};
                background-image: linear-gradient(-160deg, {$colors['bd_color_05']} 0%, {$colors['bg_color_0']} 100%);
            }
            .post_categories > a {
                border-color: {$colors['text_hover2']};
            }
            .post_meta .post_meta_item.post_author:hover:before,
            .post_meta a.post_meta_item:hover:before,
            .post_meta .post_meta_item.post_date a:hover:before {
                color: {$colors['text_hover3']};
            }
            .post_meta .post_meta_item.post_author:before,
            .post_meta a.post_meta_item:before,
            .post_meta .post_meta_item.post_date a:before {
                color: {$colors['text_link']};
            }
            .author-info,
            .author_avatar,
            .comments_list_wrap .comment_author_avatar,
            .author-content,
            .comment-content,
            .comments_list_title,
            .comments_form_title,
            .related_wrap_title,
            .comment-form,
            .woocommerce form.checkout_coupon,
            .related_wrap .related-posts,
            .post-excerpt .excerpt-title .post_title,
            .post-excerpt .exerpt-body {
                border-color: {$colors['bd_color']};
                color: {$colors['text']};
            }
            .post_item_single .post_content > .post_meta_single:before{
                background-color: {$colors['bd_color']};
            }
            .related_wrap .related-posts,
            .author-content,
            .comment-content,
            .woocommerce form.checkout_coupon,
            .comment-form,
            .post-excerpt .exerpt-body {
                background-color: {$colors['alter_bg_hover']};
            }
            .comments_list_wrap .comment_posted,
            .related_wrap .related_item_style_2 .post_date a{
                color: {$colors['text']};
            }
            .related_wrap .related_item_style_2 .post_date:before,
            .related_wrap .related_item_style_2 .post_date a:hover{
                color: {$colors['text_link']};
            }
            .sc_content_light {
                background-color: {$colors['alter_bg_hover']} !important;
                border-color: {$colors['bd_color']};
                background-image: linear-gradient(-160deg, {$colors['bd_color_05']} 0%, {$colors['bg_color_0']} 100%);
            }
            .sc_team_default .sc_team_item {
                background-color: {$colors['bg_color_0']};
            }
            #sb_instagram .sbi_photo_wrap,
            .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register,
            .sc_team_default .post_featured {
                border-color: {$colors['bd_color']};
            }
            .widget_twitter .widget_content ul > li + li:after {
                background-color: {$colors['bd_color']};
            }
            .sc_team_default .sc_team_item:hover .post_featured {
                border-color: {$colors['text_link']};
            }
            .sc_team_default .sc_team_item_title a:hover{
                 color: {$colors['text_hover3']};
            }
            .sc_promo .sc_promo_descr,
            .sc_matches_main .sc_matches_item_score a {
                color: {$colors['text']};
            }
            .sc_matches_other .sc_matches_item_score,
            .sc_matches_item_pair .sc_matches_item_score_value,
            .sc_matches_main .sc_matches_item_score a:hover {
                color: {$colors['text_link']};
            }
            .sc_blogger_item_content,
            .sc_blogger_item,
            .sc_matches_other .sc_matches_item_link:hover .sc_matches_item_date,
            .sc_matches_other .sc_matches_item_link,
            .sc_matches_other .sc_matches_item_date {
                background-color: {$colors['bg_color_0']};
                color: {$colors['text']};
            }
            .sc_matches_other .sc_matches_item_link:hover .sc_matches_item_vs,
            .sc_matches_other .sc_matches_item_link:hover .sc_matches_item_title{
                color: {$colors['text_hover3']};
            }
            .sc_matches_events  .sc_matches_item_link .sc_matches_item_vs,
            .sc_matches_events  .sc_matches_item_link .sc_matches_item_title{
                color: {$colors['text_dark']};
            }
            .sc_blogger_default .sc_blogger_item + .sc_blogger_item,
            .post_item .post_thumb,
            .sc_blogger_default .sc_item_content + .sc_item_button,
            .sc_recent_news .post_item .post_featured,
            .sc_blogger_horizont .sc_blogger_item .sc_blogger_item_featured,
            .sc_promo_image,
            .sc_blogger_portfolio .sc_blogger_item .post_featured,
            .sc_layouts_row.sc_layouts_row_type_compact .sc_layouts_column_align_right .sc_layouts_item,
            .sc_blogger_horizont .sc_item_content + .sc_item_button,
            .sc_blogger_horizont .sc_blogger_item + .sc_blogger_item,
            .sc_action_item_default.with_image,
            .sc_countdown .sc_countdown_item,
            .sc_matches_other .sc_matches_item  {
                border-color: {$colors['bd_color']};
            }
            .sc_recent_news .post_item .post_featured .post_info .post_categories {
                background-color: {$colors['bg_color_0']};
            }
            .sc_recent_news .post_item .post_date a:hover,
            .sc_recent_news .post_item .post_date a,
            .sc_recent_news .post_counters_item {
                background-color: {$colors['bg_color_0']} !important;
                color: {$colors['text']};
            }
            .widget .post_item .post_info .post_info_posted:before,
            .sc_matches_item_score1,
            .sc_recent_news .post_counters_item:hover,
            .sc_recent_news .post_item .post_date a:hover,
            .sc_recent_news .post_counters_item:before,
            .sc_recent_news .post_item .post_date:before {
                color: {$colors['text_link']};
            }
            .sc_countdown_default .sc_countdown_digits span,
            .sc_countdown .sc_countdown_label {
                color: {$colors['text']};
            }
            .sc_layouts_row_type_compact .sc_layouts_cart:hover .sc_layouts_item_icon,
            .sc_action_item_description,
            .sc_action_item .sc_action_item_subtitle {
                color: {$colors['text_dark']};
            }
            .sc_layouts_row_type_compact .sc_layouts_item_icon {
                color: {$colors['text']};
            }
            h2.sc_item_title.sc_item_title_style_default:not(.sc_item_title_tag):before {
                background-color: {$colors['text_link']};
            }
            
CSS;
		}

		return $css;
	}
}
?>