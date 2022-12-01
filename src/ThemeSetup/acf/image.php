<?php

use Freekattema\Wp\Shared\Image;

if(!function_exists('get_image')):
    function get_image(...$args): ?Image
    {
        if(is_array($args[0])) {
            $cur = $args[0];

            if(!array_key_exists('url', $cur)) {
                return null;
            }

            return new Image($cur['url'], $cur['alt']);
        }

        $image = get_field(...$args);

        if(!$image) {
            return null;
        }

        return new Image(
            $image['url'],
            $image['alt']
        );
    }
endif;

if(!function_exists('get_sub_image')):
    function get_sub_image(...$args): ?Image
    {
        if(is_array($args[0])) {
            $cur = $args[0];

            if(!array_key_exists('url', $cur)) {
                return null;
            }

            return new Image($cur['url'], $cur['alt']);
        }

        $image = get_sub_field(...$args);

        if(!$image) {
            return null;
        }

        return new Image(
            $image['url'],
            $image['alt']
        );
    }
endif;

if(!function_exists('get_thumbnail')):
    function get_thumbnail(int $post_ID = null): ?Image
    {
        if($post_ID === null) {
            $post_ID === get_the_ID();
        }

        $id = get_the_post_thumbnail($post_ID);
        $url = get_the_post_thumbnail_url($post_ID, 'full');
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true);

        if($url === false) {
            return null;
        }

        return new Image($url, $alt);
    }
endif;