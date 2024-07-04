/* global jQuery:false */
/* global LUDOS_PARADISE_STORAGE:false */

//-------------------------------------------
// Theme Options fields manipulations
//-------------------------------------------
jQuery(document).ready(function() {
	"use strict";

	// Submit form
	jQuery('.ludos_paradise_options_button_submit').on('click', function() {
		jQuery(this).parents('form').submit();
	});

	// Toggle inherit button and cover
	jQuery('#ludos_paradise_options_tabs').on('click', '.ludos_paradise_options_inherit_lock,.ludos_paradise_options_inherit_cover', function (e) {
		var parent = jQuery(this).parents('.ludos_paradise_options_item');
		var inherit = parent.hasClass('ludos_paradise_options_inherit_on');
		if (inherit) {
			parent.removeClass('ludos_paradise_options_inherit_on').addClass('ludos_paradise_options_inherit_off');
			parent.find('.ludos_paradise_options_inherit_cover').fadeOut().find('input[type="hidden"]').val('');
		} else {
			parent.removeClass('ludos_paradise_options_inherit_off').addClass('ludos_paradise_options_inherit_on');
			parent.find('.ludos_paradise_options_inherit_cover').fadeIn().find('input[type="hidden"]').val('inherit');
			
		}
		e.preventDefault();
		return false;
	});

	// Refresh linked field
	jQuery('#ludos_paradise_options_tabs').on('change', '[data-linked] select,[data-linked] input', function (e) {
		var chg_name     = jQuery(this).parent().data('param');
		var chg_value    = jQuery(this).val();
		var linked_name  = jQuery(this).parent().data('linked');
		var linked_data  = jQuery('#ludos_paradise_options_tabs [data-param="'+linked_name+'"]');
		var linked_field = linked_data.find('select');
		var linked_field_type = 'select';
		if (linked_field.length == 0) {
			linked_field = linked_data.find('input');
			linked_field_type = 'input';
		}
		var linked_lock = linked_data.parent().parent().find('.ludos_paradise_options_inherit_lock').addClass('ludos_paradise_options_wait');
		// Prepare data
		var data = {
			action: 'ludos_paradise_get_linked_data',
			nonce: LUDOS_PARADISE_STORAGE['ajax_nonce'],
			chg_name: chg_name,
			chg_value: chg_value
		};
		jQuery.post(LUDOS_PARADISE_STORAGE['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: LUDOS_PARADISE_STORAGE['ajax_error_msg'] };
				console.log(response);
			}
			if (rez.error === '') {
				if (linked_field_type == 'select') {
					var opt_list = '';
					for (var i in rez.list) {
						opt_list += '<option value="'+i+'">'+rez.list[i]+'</option>';
					}
					linked_field.html(opt_list);
				} else {
					linked_field.val(rez.value);
				}
				linked_lock.removeClass('ludos_paradise_options_wait');
			}
		});
		e.preventDefault();
		return false;
	});
	
	
	// Check for dependencies
	//-----------------------------------------------------------------------------
	function ludos_paradise_options_start_check_dependencies() {
		jQuery( '.ludos_paradise_options .ludos_paradise_options_section' ).each(
			function () {
				ludos_paradise_options_check_dependencies( jQuery( this ) );
			}
		);
	}
	// Check all inner dependencies
	jQuery( document ).ready( ludos_paradise_options_start_check_dependencies );
	// Check external dependencies (for example, "Page template" in the page edit mode)
	jQuery( window ).on( 'load', ludos_paradise_options_start_check_dependencies );
	// Check dependencies on any field change
	jQuery( '.ludos_paradise_options .ludos_paradise_options_item_field [name^="ludos_paradise_options_field_"]' ).on(
		'change', function () {
			ludos_paradise_options_check_dependencies( jQuery( this ).parents( '.ludos_paradise_options_section' ) );
		}
	);

	// Return value of the field
	function ludos_paradise_options_get_field_value(fld, num) {
		var ctrl = fld.parents('.ludos_paradise_options_item_field');
		var val = fld.attr('type')=='checkbox' || fld.attr('type')=='radio' 
					? (ctrl.find('[name^="ludos_paradise_options_field_"]:checked').length > 0
						? (num === true
							? ctrl.find('[name^="ludos_paradise_options_field_"]:checked').parent().index()+1
							: (ctrl.find('[name^="ludos_paradise_options_field_"]:checked').val()!=''
								&& ''+ctrl.find('[name^="ludos_paradise_options_field_"]:checked').val()!='0'
									? ctrl.find('[name^="ludos_paradise_options_field_"]:checked').val()
									: 1
								)
							)
						: 0
						)
					: (num === true ? fld.find(':selected').index()+1 : fld.val());
		if (val===undefined || val===null) val = '';
		return val;
	}
	
	// Check for dependencies
function ludos_paradise_options_check_dependencies(cont) {
	if ( typeof ludos_paradise_dependencies == 'undefined' || LUDOS_PARADISE_STORAGE['check_dependencies_now'] ) {
		return;
	}
	LUDOS_PARADISE_STORAGE['check_dependencies_now'] = true;
	cont.find( '.ludos_paradise_options_item_field,.ludos_paradise_options_group[data-param]' ).each( function() {
		var ctrl = jQuery( this ),
			id = ctrl.data( 'param' );
		if (id === undefined) {
			return;
		}
		var depend = false, fld;
		for (fld in ludos_paradise_dependencies) {
			if (fld == id) {
				depend = ludos_paradise_dependencies[id];
				break;
			}
		}
		if (depend) {
			var dep_cnt    = 0, dep_all = 0;
			var dep_cmp    = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
			var dep_strict = typeof depend.strict != 'undefined';
			var val        = undefined;
			var name       = '', subname = '';
			var parts      = '', parts2 = '';
			var i;
			fld = null;
			for (i in depend) {
				if (i == 'compare' || i == 'strict') {
					continue;
				}
				dep_all++;
				name    = i;
				subname = '';
				if (name.indexOf( '[' ) > 0) {
					parts   = name.split( '[' );
					name    = parts[0];
					subname = parts[1].replace( ']', '' );
				}
				// If a name is a selector to the DOM-object 
				if (name.charAt( 0 ) == '#' || name.charAt( 0 ) == '.') {
					fld = jQuery( name );
					if ( fld.length > 0 ) {
						var panel = fld.closest('.edit-post-sidebar');
						if ( panel.length === 0 ) {
							if ( ! fld.hasClass('ludos_paradise_inited') ) {
								fld.addClass('ludos_paradise_inited').on('change', function () {
									jQuery('.ludos_paradise_options .ludos_paradise_options_section').each( function () {
										ludos_paradise_options_check_dependencies(jQuery(this));
									} );
								} );
							}
						} else {
							if ( ! panel.hasClass('ludos_paradise_inited') ) {
								panel.addClass('ludos_paradise_inited').on('change', fld, function () {
									jQuery('.ludos_paradise_options .ludos_paradise_options_section').each( function () {
										ludos_paradise_options_check_dependencies(jQuery(this));
									} );
								} );
							}
						}
					} else if ( name == '#page_template' || name == '.editor-page-attributes__template select' ) {
						if ( typeof wp == 'object' && typeof wp.data == 'object' ) {
							if ( typeof LUDOS_PARADISE_STORAGE['page_template'] == 'undefined' ) {
								var tpl = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );
								if ( tpl !== undefined ) {
									LUDOS_PARADISE_STORAGE['page_template'] = tpl;
								}
							}
							val = typeof LUDOS_PARADISE_STORAGE['page_template'] != 'undefined' ? LUDOS_PARADISE_STORAGE['page_template'] : '';
							var $body = jQuery( 'body' );
							if ( ! $body.hasClass( 'ludos_paradise_page_template_inited' ) ) {
								$body.addClass( 'ludos_paradise_page_template_inited' );
								// Call a check_dependencies() on a page template changed
								wp.data.subscribe( function() {
									var tpl = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );
									if ( tpl !== undefined && ( typeof LUDOS_PARADISE_STORAGE['page_template'] == 'undefined' || tpl != LUDOS_PARADISE_STORAGE['page_template'] ) ) {
										LUDOS_PARADISE_STORAGE['page_template'] = tpl;
										jQuery('.ludos_paradise_options .ludos_paradise_options_section').each( function () {
											ludos_paradise_options_check_dependencies(jQuery(this));
										} );
									}

								} );
							}
						}
					}
				// A name is a field from options
				} else {
					fld = cont.find( '[name="ludos_paradise_options_field_' + name + '"]' );
				}
				if ( val !== undefined || ( fld && fld.length > 0 ) ) {
					if ( val === undefined ) {
						val = ludos_paradise_options_get_field_value( fld );
					}
					if ( val == 'inherit' ) {
						dep_cnt = 0;
						dep_all = 1;
						var parent = ctrl,
							tag;
						if ( ! parent.hasClass('ludos_paradise_options_group') ) {
							parent = parent.parents('.ludos_paradise_options_item');
						}
						var lock = parent.find( '.ludos_paradise_options_inherit_lock' );
						if ( lock.length ) {
							if ( ! parent.hasClass( 'ludos_paradise_options_inherit_on' ) ) {
								lock.trigger( 'click' );
							}
						} else if ( ctrl.data('type') == 'select' ) {
							tag = ctrl.find('select');
							if ( tag.find('option[value="inherit"]').length ) {
								tag.val('inherit').trigger('change');
							}
						} else if ( ctrl.data('type') == 'radio' ) {
							tag = ctrl.find('input[type="radio"][value="inherit"]');
							if ( tag.length && ! tag.get(0).checked ) {
								ctrl.find('input[type="radio"]:checked').get(0).checked = false;
								tag.get(0).checked = true;
								tag.trigger('change');
							}
						}
						break;
					} else {
						if (subname !== '') {
							parts = val.split( '|' );
							for (var p = 0; p < parts.length; p++) {
								parts2 = parts[p].split( '=' );
								if (parts2[0] == subname) {
									val = parts2[1];
								}
							}
						}
						if ( typeof depend[i] != 'object' && typeof depend[i] != 'array' ) {
							depend[i] = { '0': depend[i] };
						}
						for (var j in depend[i]) {
							if (
								(depend[i][j] == 'not_empty' && val !== '')   // Main field value is not empty - show current field
								|| (depend[i][j] == 'is_empty' && val === '') // Main field value is empty - show current field
								|| (val !== '' && ( ! isNaN( depend[i][j] )   // Main field value equal to specified value - show current field
												? val == depend[i][j]
												: (dep_strict
														? val == depend[i][j]
														: ('' + val).indexOf( depend[i][j] ) === 0
													)
											)
								)
								|| (val !== '' && ("" + depend[i][j]).charAt( 0 ) == '^' && ('' + val).indexOf( depend[i][j].substr( 1 ) ) == -1)
																			// Main field value not equal to specified value - show current field
							) {
								dep_cnt++;
								break;
							}
						}
					}
				} else {
					dep_all--;
				}
				if (dep_cnt > 0 && dep_cmp == 'or') {
					break;
				}
			}
			if ( ! ctrl.hasClass('ludos_paradise_options_group') ) {
				ctrl = ctrl.parents('.ludos_paradise_options_item');
			}
			var section = ctrl.parents('.ludos_paradise_tabs_section'),
				tab = jQuery( '[aria-labelledby="' + section.attr('aria-labelledby') + '"]' );
			if (((dep_cnt > 0 || dep_all === 0) && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
				ctrl.slideDown().removeClass( 'ludos_paradise_options_no_use' );
				if ( section.find('>.ludos_paradise_options_item:not(.ludos_paradise_options_item_info),>.ludos_paradise_options_group[data-param]').length != section.find('.ludos_paradise_options_no_use').length ) {
					if ( tab.hasClass( 'ludos_paradise_options_item_hidden' ) ) {
						tab.removeClass('ludos_paradise_options_item_hidden');
					}
				}
			} else {
				ctrl.slideUp().addClass( 'ludos_paradise_options_no_use' );
				if ( section.find('>.ludos_paradise_options_item:not(.ludos_paradise_options_item_info),>.ludos_paradise_options_group[data-param]').length == section.find('.ludos_paradise_options_no_use').length ) {
					if ( ! tab.hasClass( 'ludos_paradise_options_item_hidden' ) ) {
						tab.addClass('ludos_paradise_options_item_hidden');
						if ( tab.hasClass('ui-state-active') ) {
							tab.parents('.ludos_paradise_tabs').find(' > ul > li:not(.ludos_paradise_options_item_hidden)').eq(0).find('> a').trigger('click');
						}
					}
				}
			}
		}

		// Individual dependencies
		//------------------------------------

		// Remove 'false' to disable color schemes less then main scheme!
		// This behavious is not need for the version with sorted schemes (leave false)
		if (false && id == 'color_scheme') {
			fld = ctrl.find( '[name="ludos_paradise_options_field_' + id + '"]' );
			if (fld.length > 0) {
				val     = ludos_paradise_options_get_field_value( fld );
				var num = ludos_paradise_options_get_field_value( fld, true );
				cont.find( '.ludos_paradise_options_item_field' ).each(
					function() {
						var ctrl2 = jQuery( this ), id2 = ctrl2.data( 'param' );
						if (id2 == undefined) {
							return;
						}
						if (id2 == id || id2.substr( -7 ) != '_scheme') {
							return;
						}
						var fld2 = ctrl2.find( '[name="ludos_paradise_options_field_' + id2 + '"]' ),
						val2     = ludos_paradise_options_get_field_value( fld2 );
						if (fld2.attr( 'type' ) != 'radio') {
							fld2 = fld2.find( 'option' );
						}
						fld2.each(
							function(idx2) {
								var dom_obj      = jQuery( this ).get( 0 );
								dom_obj.disabled = idx2 !== 0 && idx2 < num;
								if (dom_obj.disabled) {
									if (jQuery( this ).val() == val2) {
										if (fld2.attr( 'type' ) == 'radio') {
											fld2.each(
												function(idx3) {
													jQuery( this ).get( 0 ).checked = idx3 === 0;
												}
											);
										} else {
											fld2.each(
												function(idx3) {
													jQuery( this ).get( 0 ).selected = idx3 === 0;
												}
											);
										}
									}
								}
							}
						);
					}
				);
			}
		}
	} );
	LUDOS_PARADISE_STORAGE['check_dependencies_now'] = false;
}
});