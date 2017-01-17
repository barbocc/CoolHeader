<?php

/**
 * Класс позволяет удобно работать с хуками плагина на фронте
 * Class created for work with settings of plugin
 * @author     Andrey Stolarchuk <barbocc@gmail.com>
 */

class Cool_Header_Frontend {
	
	private $plugin_name;
	private $version;
	
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}
	
	public function enqueue_styles(){
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );
	}
	
	public function enqueue_scripts(){
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lib.js', array( 'jquery' ), $this->version, false );
	}
	
}