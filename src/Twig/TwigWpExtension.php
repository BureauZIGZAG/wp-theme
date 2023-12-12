<?php

namespace Freekattema\Wp\Twig;

use Twig\Extension\AbstractExtension;
use function Freekattema\Wp\Components\get_permalink;
use function Freekattema\Wp\Components\get_post;
use function Freekattema\Wp\Components\get_post_meta;
use function Freekattema\Wp\Components\get_the_author_meta;
use function Freekattema\Wp\Components\get_the_content;
use function Freekattema\Wp\Components\get_the_date;
use function Freekattema\Wp\Components\get_the_excerpt;
use function Freekattema\Wp\Components\get_the_ID;
use function Freekattema\Wp\Components\get_the_post_thumbnail;
use function Freekattema\Wp\Components\get_the_post_thumbnail_url;
use function Freekattema\Wp\Components\get_the_title;

class TwigWpExtension extends AbstractExtension {
    public function getFunctions()
    {
        return [
            // get wp menu
            new \Twig\TwigFunction('wp_menu', [$this, 'get_menu'], ['is_safe' => ['html']]),
            // get post thumbnail
            new \Twig\TwigFunction('wp_thumbnail', [$this, 'get_thumbnail']),
            // get thumbnail src
            new \Twig\TwigFunction('wp_thumbnail_src', [$this, 'get_thumbnail_src']),
            // get thumbnail alt
            new \Twig\TwigFunction('wp_thumbnail_alt', [$this, 'get_thumbnail_alt']),
            // get thumbnail element
            new \Twig\TwigFunction('wp_thumbnail_element', [$this, 'get_thumbnail_element']),
            // get post
            new \Twig\TwigFunction('wp_post', [$this, 'get_post']),
            // get title
            new \Twig\TwigFunction('wp_title', [$this, 'get_title']),
            // get permalink
            new \Twig\TwigFunction('wp_permalink', [$this, 'get_permalink']),
            // get post date
            new \Twig\TwigFunction('wp_date', [$this, 'get_date']),
            // get post author
            new \Twig\TwigFunction('wp_author', [$this, 'get_author']),
            // get post excerpt
            new \Twig\TwigFunction('wp_excerpt', [$this, 'get_excerpt']),
            // get post content
            new \Twig\TwigFunction('wp_content', [$this, 'get_content']),
            ];
    }

    public function get_menu(string $menu_name, array $args = []) {
        $m = [
            'theme_location' => $menu_name,
        ];
        \wp_nav_menu(\array_merge($m, $args));
    }

    public function get_thumbnail(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_post_thumbnail($post_id, $size);
    }

    public function get_thumbnail_src(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_post_thumbnail_url($post_id, $size);
    }

    public function get_thumbnail_alt(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_post_meta(\get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
    }

    public function get_thumbnail_element(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_post_thumbnail($post_id, $size);
    }

    public function get_post(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_post($post_id);
    }

    public function get_title(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_title($post_id);
    }

    public function get_permalink(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_permalink($post_id);
    }

    public function get_date(string $format = 'd.m.Y', int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_date($format, $post_id);
    }

    public function get_author(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_author_meta('display_name', get_post_field('post_author', $post_id));
    }

    public function get_excerpt(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_excerpt($post_id);
    }

    public function get_content(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        echo \get_the_content($post_id);
    }
}