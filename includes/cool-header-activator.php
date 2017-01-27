<?php

/**
 * Created by PhpStorm.
 * User: barbocc
 * Date: 27.01.2017
 * Time: 13:39
 */
class Cool_Header_Activator
{
    public static function activate(){
        if (!get_option('cool_header_options')){

            $settings = array(
                'block_id' => 'toc_container',
                'scroll_depth' => '200',
                'scroll_comment' => null,
                'ask_form' => null
            );

            add_option( "cool_header_options", $settings, '', 'yes' );
        }
    }
}