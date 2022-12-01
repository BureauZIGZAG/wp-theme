<?php

use Freekattema\Wp\Shared\Link;

if(!function_exists('get_link_object')):
    function get_link_object(...$args): ?Link
    {
        if(is_array($args[0])) {
            $cur = $args[0];

            if(!array_key_exists('url', $cur)) {
                return null;
            }

            return new Link($cur['url'], $cur['target'], $cur['title']);
        }

        $link = get_field(...$args);

        if(!$link) {
            return null;
        }

        return new Link(
            $link['url'],
            $link['target'],
            $link['title']
        );
    }
endif;

if(!function_exists('get_sub_link')):
    function get_sub_link(...$args): ?Link
    {
        if(is_array($args[0])) {
            $cur = $args[0];

            if(!array_key_exists('url', $cur)) {
                return null;
            }

            return new Link($cur['url'], $cur['target'], $cur['title']);
        }

        $link = get_sub_field(...$args);

        if(!$link) {
            return null;
        }

        return new Link(
            $link['url'],
            $link['target'],
            $link['title']
        );
    }
endif;