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
            new \Twig\TwigFunction('acf_field', [$this, 'get_field']),
            new \Twig\TwigFunction('acf_sub_field', [$this, 'get_sub_field']),
            new \Twig\TwigFunction('acf_loop', [$this, 'get_loop']),
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

}
