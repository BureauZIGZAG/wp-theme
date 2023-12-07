<?php

namespace Freekattema\Wp\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAcfExtension extends AbstractExtension {
    public function getFunctions()
    {
        return [
            // get acf field
            new TwigFunction('acf_field', [$this, 'get_field']),
            // get acf sub field
            new TwigFunction('acf_sub_field', [$this, 'get_sub_field']),
            // get acf loop
            new TwigFunction('acf_loop', [$this, 'get_loop']),
            // get acf image src
            new TwigFunction('acf_image_src', [$this, 'get_image_src']),
            // get acf image alt
            new TwigFunction('acf_image_alt', [$this, 'get_image_alt']),
            // get acf image element
            new TwigFunction('acf_image_element', [$this, 'get_image_element']),
            // get acf option
            new TwigFunction('acf_option', [$this, 'get_option']),
            // get acf option image
            new TwigFunction('acf_option_image', [$this, 'get_option_image']),
            ];
    }

    public function get_field(string $field_name, $post_id = null, bool $format_value = true) {
        if(!function_exists('get_field')) return "";
        return \get_field($field_name, $post_id, $format_value);
    }

    public function get_sub_field(string $field_name, bool $format_value = true) {
        if(!function_exists('get_sub_field')) return "";
        return \get_sub_field($field_name, $format_value);
    }

    public function get_loop(string $field_name, $post_id = null) {
        if(!function_exists('get_field')) return [];
        return \get_field($field_name, $post_id);
    }

    public function get_image_src(string $field_name, $post_id = null) {
        if(!function_exists('get_field')) return "";
        $image = \get_field($field_name, $post_id);
        if(!$image) return "";
        return $image['url'] ?? "";
    }

    public function get_image_alt(string $field_name, $post_id = null) {
        if(!function_exists('get_field')) return "";
        $image = \get_field($field_name, $post_id);
        if(!$image) return "";
        return $image['alt'] ?? "";
    }

    public function get_image_element(string $field_name, $post_id = null) {
        if(!function_exists('get_field')) return "";
        $image = \get_field($field_name, $post_id);
        if(!$image) return "";
        return "<img src='{$image['url']}' alt='{$image['alt']}' />";
    }

    public function get_option(string $option_name, $default = null) {
        if(!function_exists('get_field')) return "";
        return \get_field($option_name, 'option') ?? $default;
    }

    public function get_option_image(string $option_name, $field=null) {
        if(!function_exists('get_field')) return "";
        $image = \get_field($option_name, 'option');
        if(!$image) return "";
        if($field) {
            return $image[$field] ?? "";
        }
        return $image;
    }
}
