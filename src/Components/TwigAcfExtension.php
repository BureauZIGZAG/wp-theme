<?php

namespace Freekattema\Wp\Components;

use \Twig\Environment;
use Twig\Extension\AbstractExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\Extension\DebugExtension;

class TwigAcfExtension extends AbstractExtension {
    public function getFunctions()
    {
        return [
            // get acf field
            new \Twig\TwigFunction('acf_field', [$this, 'get_field']),
            // get acf sub field
            new \Twig\TwigFunction('acf_sub_field', [$this, 'get_sub_field']),
            // get acf loop
            new \Twig\TwigFunction('acf_loop', [$this, 'get_loop']),
            // get acf image src
            new \Twig\TwigFunction('acf_image_src', [$this, 'get_image_src']),
            // get acf image alt
            new \Twig\TwigFunction('acf_image_alt', [$this, 'get_image_alt']),
            // get acf image element
            new \Twig\TwigFunction('acf_image_element', [$this, 'get_image_element']),
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

    public function get_image_src(string $field_name, $post_id = null, string $size = 'thumbnail') {
        if(!function_exists('get_field')) return "";
        $image = \get_field($field_name, $post_id);
        if(!$image) return "";
        return $image['sizes'][$size] ?? "";
    }

    public function get_image_alt(string $field_name, $post_id = null) {
        if(!function_exists('get_field')) return "";
        $image = \get_field($field_name, $post_id);
        if(!$image) return "";
        return $image['alt'] ?? "";
    }

    public function get_image_element(string $field_name, $post_id = null, string $size = 'thumbnail') {
        if(!function_exists('get_field')) return "";

    }
}
