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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cool-header-frontend.css', array(), $this->version, 'all' );
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
		<div id="cool_header_block">
			<div id="cool_header_block_content">
                <div id="header-logo"><!-- Левый блок -->
                    <a href="/">
                        <img src="http://obustroeno.com/wp-content/themes/1brus_mag/img/min_logo.svg" style="width: 100px;">
                    </a>
                </div>
                <?php
		            if ( class_exists( 'toc_widget' ) ) {
		                $toc = new toc_widget();
		                ?>
                        <div class="cool-header-toc">
                            <div class="cool-header-show-hide">
                                Содержание
                            </div>
                            <div class="cool-header-toc-elmnts" style="display: none;">
                        <?php
			            $toc->widget();
			           ?>
                            </div>
		                </div>
	                        <?php
                    }
                ?>
                <div class="question">
		<?php if (is_user_logged_in()){
			echo ' <a class="bbp-topic-reply-link" style="font-family:sans-serif;" rel="nofollow" href="http://obustroeno.com/vopros">Задать вопрос</a>';
		}
		
		else {
			echo ' <a class="bbp-topic-reply-link bbp_ask_no" style="font-family:sans-serif;" href="javascript:void(null);" rel="nofollow">Задать вопрос</a>';
		}
		?>
                </div>
                <div class="cool-header-up">
                    <a href="#" id="cool_header_up">&uarr;</a>
                </div>
            </div>
		</div>
		
		<?php
	}
	
}