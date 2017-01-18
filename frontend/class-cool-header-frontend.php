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
	
	public function show_fading_script(){
		$settings = get_option('cool_header_options');
		
		$html = '';
		
		if ($settings['block_id'] && $settings['block_id']!== '' && $settings['scroll_depth'] && $settings['scroll_depth']!== '') {
			?>
			<script type="application/javascript">
				
				jQuery( document ).ready(function() {
                    $(function() {
                        jQuery(document).on("mousewheel", function() {
                            var depth = jQuery(document).scrollTop();
                            
                            if (depth > <?=$settings['scroll_depth']?>) {
                                jQuery('#cool_header_block').css('display', 'block');
                            }
                            else if (depth < <?=$settings['scroll_depth']?>) {
                                jQuery('#cool_header_block').css('display', 'none');
                            }
                            var padding = jQuery('#wpadminbar').css('height');
                            jQuery('#cool_header_block').css('top', padding);
                        });
                    });
					
                });
                
			</script>
			<?php
		}
	}
	
	public function show_html_block(){
		?>
		<div id="cool_header_block" style = "
		position: fixed; top: 0px; left: 0px;
		width: 100%;
		height: 50px;
		background: #fff;
		z-index: 1000;
		display: none;
		">
			<div style="margin: 0 auto;"></div>
			
		</div>
		
		<?php
	}
	
}