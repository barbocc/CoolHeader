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
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cool-header-frontend.css?170', array(), $this->version, 'all' );
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
                         jQuery(document).on("scroll", onScroll);

                        //smoothscroll
                        jQuery('.cool-header-toc-elmnts a[href^="#"]').on('click', function (e) {
                            e.preventDefault();
                            jQuery(document).off("scroll");

                            jQuery('.cool-header-toc-elmnts ul li a').each(function () {
                                jQuery(this).removeClass('active');
                            });
                            
                            jQuery(this).addClass('active');
                            jQuery('#cool-header-text-toc').text(jQuery(this).text());
                            var target = this.hash,
                                menu = target;
                            target = jQuery(target);
                            /*$('html, body').stop().animate({
                             'scrollTop': $target.offset().top+2
                             }, 500, 'swing', function () {*/
                            window.location.hash = target.selector;
                            jQuery(document).on("scroll", onScroll);
                            //});
                        });
                          
                        function onScroll(event){
                            
                            var depth = jQuery(document).scrollTop();

                            if (depth > <?=$settings['scroll_depth']?>) {
                                jQuery('#cool_header_block').css('display', 'block');
                            }
                            else if (depth < <?=$settings['scroll_depth']?>) {
                                jQuery('#cool_header_block').css('display', 'none');
                                jQuery('.cool-header-toc-elmnts').removeClass('active');
                                jQuery('.cool-header-toc-elmnts').css('display', 'none');
                                
                                jQuery('#cool-header-text-toc').text("<?php global $post; echo $post->post_title;?>");

                            }
                            var padding = jQuery('#wpadminbar').css('height');
                            jQuery('#cool_header_block').css('top', padding);

                            var scrollPos = jQuery(document).scrollTop();
                            jQuery('.cool-header-toc-elmnts ul li a').each(function () {
                                var currLink = jQuery(this);
                                var refElement = jQuery(currLink.attr("href"));
                                if (refElement.position().top <= scrollPos && (refElement.position().top + refElement.height() > scrollPos)) {
                                    jQuery('.cool-header-toc-elmnts ul li a').removeClass("active");
                                    currLink.addClass("active");
                                    jQuery('#cool-header-text-toc').text(currLink.text());
                                    console.log('arc active');
                                }
                                /*else (){
                                    currLink.removeClass("active");
                                }*/
                            });
                        }


                    });
                    jQuery('#cool_header_up').on("click", function() {
                        jQuery('#cool_header_block').css('display', 'none');
                    });

                    //
                    jQuery(document).on("click", function(e) {
                        var container = jQuery("#cool-header-shbutton");
                        if (!container.is(e.target) // if the target of the click isn't the container...
                            && container.has(e.target).length === 0) // ... nor a descendant of the container
                        {
                            if (jQuery('.cool-header-toc-elmnts').hasClass('active')) {
                                console.log('remove active');
                                jQuery('.cool-header-toc-elmnts').removeClass('active');
                                jQuery('.cool-header-toc-elmnts').css('display', 'none');
                            }
                        }
                    });

                    jQuery('#cool-header-shbutton').on("click", function() {
                        jQuery('.cool-header-toc-elmnts').toggle();

                        if (jQuery('.cool-header-toc-elmnts').hasClass('active')){
                            jQuery('.cool-header-toc-elmnts').removeClass('active');
                            console.log('remove active');
                        }
                        else{
                            console.log('add active');
                            jQuery('.cool-header-toc-elmnts').addClass('active');
                        }
                    });
                    
                    
                });
            </script>
            <?php
        }
    }
    
    public function show_html_block(){
      
	    if ( !class_exists( 'toc_widget' )){
	        return;
	    }
	    
	    $toc = new toc_widget();
	    ob_start();
	        $toc->widget();
	    $str = ob_get_clean();
	    
	    if ( !$str){
		    return;
	    }
	    
        ?>
        <div id="cool_header_block">
            <div id="cool_header_block_content">
                <!--<div id="cool-header-logo">
                    <a href="/">
                        <img src="http://obustroeno.com/wp-content/themes/1brus_mag/img/nano_logo.svg">
                    </a>
                </div>-->
                <?php
                    //if ( class_exists( 'toc_widget' ) ) {
	                    global $post;
	                    
                        ?>
                        <div class="cool-header-toc">
                            <div class="cool-header-show-hide">
                                <a href="javascript:void(null);" rel="nofollow" id="cool-header-shbutton">
                                    <div id="cool-header-text-toc"><?=$post->post_title?></div>
                                    <div id="cool-header-arrow">
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="cool-header-toc-elmnts" style="display: none;">
                        <?php
                        
                           echo $str;
                           
                        $settings = get_option('cool_header_options');
                           if ( $settings['scroll_comment'] == null || $settings['scroll_comment']== ''){
                               ?>
                               <ul>
                                   <li>
                                       <a href="#<?=$settings['scroll_comment']?>" style="padding-bottom: 20px;">Коментарии</a>
                                   </li>
                               </ul>
                                <?
                           }
                        
                       ?>
                            </div>
                       </div>
                            <?php
                    //}
                ?>
                <div class="cool-header-up">
                    <a href="#" id="cool_header_up"><i class="fa fa-arrow-up"></i></a>
                </div>

                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div style="float: right; margin-top: 17px; margin-right: 25px;" class="ya-share2" data-services="vkontakte,facebook,odnoklassniki" data-counter=""></div>
                <?php
                if (function_exists('post_likes_view')){
	                post_likes_view();
                }
                ?>
                <?php
	                if ( $settings['ask_form'] !== null || $settings['ask_form'] !== '') {
                ?>
                        <div class="cool-header-question">
                            <a class="cool-header-ask" rel="nofollow" href="#<?= $settings['ask_form'] ?>">задать вопрос</a>
                        </div>
                <?php
	                }
                ?>
                
            </div>
        </div>
        
        <?php
    }
    
}