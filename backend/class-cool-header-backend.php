<?php

/**
 * Класс позволяет удобно работать с хуками с настройками плагина
 * Class created for work with settings of plugin
 * @author     Andrey Stolarchuk <barbocc@gmail.com>
 */

class Cool_Header_Backend {
	
	private $plugin_name;
	private $version;
	
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		
	}
	
	public function enqueue_styles() {
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );
	}
	
	public function enqueue_scripts() {
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lib.js', array( 'jquery' ), $this->version, false );
	}
	
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			'Cool Header', //Текст, который будет использован в теге title на странице, настроек.
			'Cool Header', //Текст, который будет использован в качестве называния для пункта меню.
			'cool_header_manage_options', //Название права доступа для пользователя, чтобы ему был показан этот пункт меню.
			$this->plugin_name,//Идентификатор меню. Нужно вписывать уникальную строку, пробелы не допускаются.
			array(
				$this,
				'display_options_page'
			) //Название функции, которая отвечает за код страницы этого пункта меню.
		);
	}
	
	public function display_options_page(){
		echo 'hello';
	}

}
