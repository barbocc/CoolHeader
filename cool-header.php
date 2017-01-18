<?php

/**
Plugin Name: Cool Header
Description: Плагин добавляет всыплывющее меню при скроллинге
Version: 1.0
Author: Andrey Stolarchuk
Author URI: http://stolarchuk.ru
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require plugin_dir_path( __FILE__ ) . 'class-cool-header.php';

register_activation_hook( __FILE__, 'activate_cool_header' );
register_deactivation_hook( __FILE__, 'deactivate_cool_header' );

/**
 * The code that runs during plugin activation.
 */
function activate_cool_header() {
	/*
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-online-community-activator.php';
	Online_Community_Activator::activate();
	*/
	
}


/**
 * The code that runs during plugin deactivation.
 */
function deactivate_cool_header() {
	/*
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-online-community-deactivator.php';
	Online_Community_Deactivator::deactivate();
	*/
}

function run_cool_header() {
	
	$plugin = new Cool_Header();
	$plugin->run();
	return $plugin;
	
}

$cool_header_plugin = run_cool_header();