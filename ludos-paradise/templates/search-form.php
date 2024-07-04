<?php
$ludos_paradise_args = array_merge(array(
								'style' => 'normal',
								'class' => '',
								'ajax' => false
								), (array) get_query_var('ludos_paradise_search_args'));
?><div class="search_wrap search_style_<?php
								echo esc_attr($ludos_paradise_args['style']) 
									. (!empty($ludos_paradise_args['class']) ? ' '.esc_attr($ludos_paradise_args['class']) : '');
?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'ludos-paradise'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
			<button type="submit" class="search_submit icon-search"></button>
		</form>
	</div>
</div>