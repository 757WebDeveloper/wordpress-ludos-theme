<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('ludos_paradise_storage_get')) {
	function ludos_paradise_storage_get($var_name, $default='') {
		global $LUDOS_PARADISE_STORAGE;
		return isset($LUDOS_PARADISE_STORAGE[$var_name]) ? $LUDOS_PARADISE_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('ludos_paradise_storage_set')) {
	function ludos_paradise_storage_set($var_name, $value) {
		global $LUDOS_PARADISE_STORAGE;
		$LUDOS_PARADISE_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('ludos_paradise_storage_empty')) {
	function ludos_paradise_storage_empty($var_name, $key='', $key2='') {
		global $LUDOS_PARADISE_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($LUDOS_PARADISE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($LUDOS_PARADISE_STORAGE[$var_name][$key]);
		else
			return empty($LUDOS_PARADISE_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('ludos_paradise_storage_isset')) {
	function ludos_paradise_storage_isset($var_name, $key='', $key2='') {
		global $LUDOS_PARADISE_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($LUDOS_PARADISE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($LUDOS_PARADISE_STORAGE[$var_name][$key]);
		else
			return isset($LUDOS_PARADISE_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('ludos_paradise_storage_inc')) {
	function ludos_paradise_storage_inc($var_name, $value=1) {
		global $LUDOS_PARADISE_STORAGE;
		if (empty($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = 0;
		$LUDOS_PARADISE_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('ludos_paradise_storage_concat')) {
	function ludos_paradise_storage_concat($var_name, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (empty($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = '';
		$LUDOS_PARADISE_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('ludos_paradise_storage_get_array')) {
	function ludos_paradise_storage_get_array($var_name, $key, $key2='', $default='') {
		global $LUDOS_PARADISE_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($LUDOS_PARADISE_STORAGE[$var_name][$key]) ? $LUDOS_PARADISE_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($LUDOS_PARADISE_STORAGE[$var_name][$key][$key2]) ? $LUDOS_PARADISE_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('ludos_paradise_storage_set_array')) {
	function ludos_paradise_storage_set_array($var_name, $key, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if ($key==='')
			$LUDOS_PARADISE_STORAGE[$var_name][] = $value;
		else
			$LUDOS_PARADISE_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('ludos_paradise_storage_set_array2')) {
	function ludos_paradise_storage_set_array2($var_name, $key, $key2, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name][$key])) $LUDOS_PARADISE_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$LUDOS_PARADISE_STORAGE[$var_name][$key][] = $value;
		else
			$LUDOS_PARADISE_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('ludos_paradise_storage_merge_array')) {
	function ludos_paradise_storage_merge_array($var_name, $key, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if ($key==='')
			$LUDOS_PARADISE_STORAGE[$var_name] = array_merge($LUDOS_PARADISE_STORAGE[$var_name], $value);
		else
			$LUDOS_PARADISE_STORAGE[$var_name][$key] = array_merge($LUDOS_PARADISE_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('ludos_paradise_storage_set_array_after')) {
	function ludos_paradise_storage_set_array_after($var_name, $after, $key, $value='') {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if (is_array($key))
			ludos_paradise_array_insert_after($LUDOS_PARADISE_STORAGE[$var_name], $after, $key);
		else
			ludos_paradise_array_insert_after($LUDOS_PARADISE_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('ludos_paradise_storage_set_array_before')) {
	function ludos_paradise_storage_set_array_before($var_name, $before, $key, $value='') {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if (is_array($key))
			ludos_paradise_array_insert_before($LUDOS_PARADISE_STORAGE[$var_name], $before, $key);
		else
			ludos_paradise_array_insert_before($LUDOS_PARADISE_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('ludos_paradise_storage_push_array')) {
	function ludos_paradise_storage_push_array($var_name, $key, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($LUDOS_PARADISE_STORAGE[$var_name], $value);
		else {
			if (!isset($LUDOS_PARADISE_STORAGE[$var_name][$key])) $LUDOS_PARADISE_STORAGE[$var_name][$key] = array();
			array_push($LUDOS_PARADISE_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('ludos_paradise_storage_pop_array')) {
	function ludos_paradise_storage_pop_array($var_name, $key='', $defa='') {
		global $LUDOS_PARADISE_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($LUDOS_PARADISE_STORAGE[$var_name]) && is_array($LUDOS_PARADISE_STORAGE[$var_name]) && count($LUDOS_PARADISE_STORAGE[$var_name]) > 0) 
				$rez = array_pop($LUDOS_PARADISE_STORAGE[$var_name]);
		} else {
			if (isset($LUDOS_PARADISE_STORAGE[$var_name][$key]) && is_array($LUDOS_PARADISE_STORAGE[$var_name][$key]) && count($LUDOS_PARADISE_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($LUDOS_PARADISE_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('ludos_paradise_storage_inc_array')) {
	function ludos_paradise_storage_inc_array($var_name, $key, $value=1) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if (empty($LUDOS_PARADISE_STORAGE[$var_name][$key])) $LUDOS_PARADISE_STORAGE[$var_name][$key] = 0;
		$LUDOS_PARADISE_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('ludos_paradise_storage_concat_array')) {
	function ludos_paradise_storage_concat_array($var_name, $key, $value) {
		global $LUDOS_PARADISE_STORAGE;
		if (!isset($LUDOS_PARADISE_STORAGE[$var_name])) $LUDOS_PARADISE_STORAGE[$var_name] = array();
		if (empty($LUDOS_PARADISE_STORAGE[$var_name][$key])) $LUDOS_PARADISE_STORAGE[$var_name][$key] = '';
		$LUDOS_PARADISE_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('ludos_paradise_storage_call_obj_method')) {
	function ludos_paradise_storage_call_obj_method($var_name, $method, $param=null) {
		global $LUDOS_PARADISE_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($LUDOS_PARADISE_STORAGE[$var_name]) ? $LUDOS_PARADISE_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($LUDOS_PARADISE_STORAGE[$var_name]) ? $LUDOS_PARADISE_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('ludos_paradise_storage_get_obj_property')) {
	function ludos_paradise_storage_get_obj_property($var_name, $prop, $default='') {
		global $LUDOS_PARADISE_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($LUDOS_PARADISE_STORAGE[$var_name]->$prop) ? $LUDOS_PARADISE_STORAGE[$var_name]->$prop : $default;
	}
}
?>