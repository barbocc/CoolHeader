<?php

/**
 * Ключевой класс плагина
 * Core plugin's class
 * @author     Andrey Stolarchuk <barbocc@gmail.com>
 */
class Cool_Header {
	
	/**
	 * @var The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 */
	protected $loader;
	
	protected  $plugin_name;
	
	protected $version;
	
	private function load_dependencies(){
		
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-header-loader.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-header-i18n.php';
		require_once plugin_dir_path( __FILE__ ) . 'frontend/class-cool-header-frontend.php';
		require_once plugin_dir_path( __FILE__ ) . 'backend/class-cool-header-backend.php';
		
	}
	
	public function __construct() {
		
		$this->plugin_name = 'cool-header';
		$this->version = '1.0.0';
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
	}
	
	private function define_admin_hooks() {
		
		$plugin_admin = new Cool_Header_Backend( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		
	}
	
	private function define_public_hooks() {
		
		$plugin_public = new Online_Community_Frontend( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
	}
	
	public function run() {
		$this->loader->run();
	}
	
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	
	public function get_loader() {
		return $this->loader;
	}
	
	public function get_version() {
		return $this->version;
	}
	
	private function set_locale() {
		
		$plugin_i18n = new Cool_Header_i18n();
		
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
		
	}
	
}