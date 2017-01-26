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
			'manage_options', //Название права доступа для пользователя, чтобы ему был показан этот пункт меню.
			$this->plugin_name,//Идентификатор меню. Нужно вписывать уникальную строку, пробелы не допускаются.
			array(
				$this,
				'display_options_page'
			) //Название функции, которая отвечает за код страницы этого пункта меню.
		);
		
		if (!get_option('cool_header_options') == null){
		    
			$settings = array(
				'block_id' => 'toc_container',
				'scroll_depth' => '200',
                'scroll_comment' => null,
                'ask_form' => null
            );
			
			add_option( "cool_header_options", $settings, '', 'yes' );
        
		}
	}
	
	public function register_plugin_options(){
	    
		register_setting(
			'cool_header_options',                 // Option group
			'cool_header_options',                 // Option name
            array($this,'sanitize_main_options')
		);
    }

    public function sanitize_main_options($input){
	    //var_dump($_POST);
	    //var_dump($input);
	    //$input['block_id'] = '123';
        return $input;
    }
    
	
	public function display_options_page(){
        
        //Fix of wordpress bug
       if (isset($_POST["cool_header_options"])){
           $validated = $this->sanitize_main_options($_POST["cool_header_options"]);
           update_option('cool_header_options', $validated);
       }
		?>

        <form method="post" action="<?php admin_url(''); ?>">
        <?php //settings_fields( 'cool_header_options' ); ?>
        <?php //do_settings_sections( 'cool_header_options' );

        $options = get_option('cool_header_options');
        ?>
		<h1>Настройка плагина Cool Header</h1>
		<div>
            <label for="cool_header_options[block_id]">ID блока
		        <p><input type="text" name="cool_header_options[block_id]" value="<?=$options['block_id']?>"/></p>
                <p class="description">При наличии этого блока на странице появляется панелька, без #</p>
            </label>
        </div>
        <div>
            <label for="cool_header_options[scroll_depth]">Глубина скроллинга от блока px
                <p><input type="text" name="cool_header_options[scroll_depth]" value="<?=$options['scroll_depth']?>"></p>
                <p class="description">На каком расстоянии от верха странице появляется панелька</p>
            </label>
        </div>
        <div>
            <label for="cool_header_options[scroll_comment]">ID блока коментариев
                <p><input type="text" name="cool_header_options[scroll_comment]" value="<?=$options['scroll_comment']?>"></p>
                <p class="description">Настройка ссылки на коментарии,  без #</p>
            </label>
        </div>
        <div>
            <label for="cool_header_options[ask_form]">ID блока задавания вопроса
                <p><input type="text" name="cool_header_options[ask_form]" value="<?=$options['ask_form']?>"></p>
                <p class="description">Настройка кнопки задать вопрос, без #</p>
            </label>
        </div>
        
	        <?php submit_button(); ?>
        </form>
<?php
	}

}
