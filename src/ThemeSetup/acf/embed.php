<?php

if(!function_exists('get_embed')):
    function get_embed($fieldName)
    {
        if(get_field($fieldName)) {
            return get_field($fieldName);
        }
    }
endif;

if(!function_exists('get_sub_embed')):
    function get_sub_embed($fieldName)
    {
        if(get_sub_field($fieldName)) {
            return get_sub_field($fieldName);
        }
    }
endif;

if(!function_exists('render_embed')):
    function render_embed($iframe_html)
    {
        // use preg_match to find iframe src
        preg_match('/src="(.+?)"/', $iframe_html, $matches);
        $src = $matches[1];

        // add extra params to iframe src
        $params = array(
            //		'controls'    => 1,
            //		'hd'        => 1,
            //		'autohide'    => 1
            'loop' => 1
        );

        $new_src = add_query_arg($params, $src);

        $iframe = str_replace($src, $new_src, $iframe_html);

        // add extra attributes to iframe html
        $attributes = 'frameborder="0" class="lazyload"';
        // use preg_replace to change iframe src to data-src
        $iframe = preg_replace('~<iframe[^>]*\K(?=src)~i', 'data-', $iframe);
        $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

        // echo $iframe
        echo $iframe;
    }
endif;