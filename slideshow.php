<?php
/*
Plugin Name: Headway Block: Slideshow
Plugin URI: http://niteco.se
Description: This block lets you easily create a slideshow block with headway.
Version: 0.5
Author: Niteco
Author URI: http://niteco.se
License: GNU GPL v2
*/

define('SLIDESHOW_BLOCK_VERSION', '0.1');

/**
 * Everything is ran at the after_setup_theme action to insure that all of Headway's classes and functions are loaded.
 **/
add_action('after_setup_theme', 'slideshow_block_register');
function slideshow_block_register() {
	if ( !class_exists('Headway') ) {
		return;
	}
	require_once 'block.php';
	require_once 'block-options.php';
	return headway_register_block('HeadwaySlideshowBlock', plugins_url(false, __FILE__));
}

/**
 * If you plan on adding your block to Headway Extend, then this will be the code that will enable auto-updates for the block/plugin.
 **/
add_action('init', 'slideshow_block_extend_updater');
function slideshow_block_extend_updater() {
	if ( !class_exists('HeadwayUpdaterAPI') )
		return;
	$updater = new HeadwayUpdaterAPI(array(
		'slug' => 'slider-block',
		'path' => plugin_basename(__FILE__),
		'name' => 'Slider',
		'type' => 'block',
		'current_version' => SLIDESHOW_BLOCK_VERSION
	));
}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Slideshow');
}