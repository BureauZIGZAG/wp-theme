<?php

namespace Freekattema\Wp\Twig;

use Freekattema\Wp\Components\ComponentData;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class TwigRenderer {
    private static function get_env(LoaderInterface $loader) {
        $twig = new Environment($loader, [
            'cache' => false
        ]);
        $twig->addExtension(new TwigAcfExtension());
        $twig->addExtension(new TwigComponentPart());
        $twig->addExtension(new TwigWpExtension());
        return $twig;
    }

    public static function render(string $template, array $data = []) {
        $fullPath = $template;
        $loader = new FilesystemLoader(dirname($template));
        $template = basename($template);
        if(str_ends_with($template, '.php')) {
            ComponentData::_set_data(new ComponentData($data));
            include $fullPath;
        } else if (str_ends_with($template, '.twig')) {
            $twig = self::get_env($loader);
            $twig->display(basename($template), self::fill_default_data($data));
        } else {
            throw new \Exception("Template file {$template} has invalid extension");
        }
    }

    private static function fill_default_data(array $data): array {
        $data = array_merge([
            "is_admin" => is_user_logged_in() && current_user_can('administrator'),
            "is_logged_in" => is_user_logged_in(),
            "current_user" => wp_get_current_user(),
            "the_title" => get_the_title(),
            "the_content" => get_the_content(),
            "the_permalink" => get_the_permalink(),
            "the_excerpt" => get_the_excerpt(),
            "the_date" => get_the_date(),
            "the_author" => get_the_author(),
            "the_post_thumbnail" => get_thumbnail(),
            "the_post_type" => get_post_type(),
            "the_post" => get_post(),
        ], $data);
        $data = self::snake_keys($data);
        return \apply_filters("zigzag_twig_data", $data);
    }

    private static function snake_keys($data) {
        $output = [];
        foreach($data as $key => $value) {
            // replace - with _
            $key = str_replace('-', '_', $key);
            if (is_array($value)) {
                $value = self::snake_keys($value);
            }
            $output[$key] = $value;
        }
        return $output;
    }
}
