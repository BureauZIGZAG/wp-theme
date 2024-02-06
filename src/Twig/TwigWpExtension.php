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
        $functions =[
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
            // get post_type
            new \Twig\TwigFunction('wp_post_type', [$this, 'get_post_type']),
            // get id
            new \Twig\TwigFunction('wp_id', [$this, 'get_id']),
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
            // get home url
            new \Twig\TwigFunction('wp_home_url', [$this, 'get_home_url']),
            // get site url
            new \Twig\TwigFunction('wp_site_url', [$this, 'get_site_url']),
            // set wp shortcode
            new \Twig\TwigFunction('wp_shortcode', [$this, 'set_shortcode']),
            // wp_uuid
            new \Twig\TwigFunction('wp_uuid', [$this, 'get_uuid']),
            // wp_header
            new \Twig\TwigFunction('wp_header', [$this, 'get_header']),
            // wp_footer
            new \Twig\TwigFunction('wp_footer', [$this, 'get_footer']),
        ];
        foreach(apply_filters('twig_functions', []) as $fn) {
            $functions[] = new \Twig\TwigFunction($fn[0], $fn[1]);
        }
        return $functions;
    }

    public function get_menu(string $menu_name, array $args = []) {
        $m = [
            'theme_location' => $menu_name,
            'echo' => false,
        ];
        return \wp_nav_menu(\array_merge($m, $args));
    }

    public function get_thumbnail(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return get_thumbnail($post_id);
    }

    public function get_thumbnail_src(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_post_thumbnail_url($post_id, $size);
    }

    public function get_thumbnail_alt(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_post_meta(\get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
    }

    public function get_thumbnail_element(int $post_id = null, string $size = 'thumbnail') {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_post_thumbnail($post_id, $size);
    }

    public function get_post(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_post($post_id);
    }

    public function get_title(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_title($post_id);
    }

    public function get_permalink(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_permalink($post_id);
    }

    public function get_date(string $format = 'd.m.Y', int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_date($format, $post_id);
    }

    public function get_author(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_author_meta('display_name', get_post_field('post_author', $post_id));
    }

    public function get_excerpt(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_excerpt($post_id);
    }

    public function get_content(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_the_content($post_id);
    }

    public function get_home_url() {
        return  \get_home_url();
    }

    public function get_site_url() {
        return  \get_site_url();
    }

    public function set_shortcode(string $shortcode) {
        return do_shortcode($shortcode);
    }

    public function get_post_type(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  \get_post_type($post_id);
    }

    public function get_id(int $post_id = null) {
        if($post_id === null) {
            $post_id = \get_the_ID();
        }
        return  $post_id;
    }

    public function get_uuid() {
        return \wp_generate_uuid4();
    }

    public function get_header() {
        return \get_header();
    }

    public function get_footer() {
        return \get_footer();
    }

}
