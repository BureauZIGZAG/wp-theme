<?php

define('WPTHEMEDIR', get_template_directory_uri() . '/inc/vencdor/wp-theme');

include_once 'ajax/AjaxWrapper.php';
include_once 'checks.php';
include_once 'acf/index.php';
include_once 'counter.php';
include_once 'populate-posts.php';

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

add_theme_support('post-thumbnails');
the_post_thumbnail();
the_post_thumbnail('thumbnail');       // Thumbnail (default 150px x 150px max)
the_post_thumbnail('medium');          // Medium resolution (default 300px x 300px max)
the_post_thumbnail('large');           // Large resolution (default 640px x 640px max)
the_post_thumbnail('full');            // Original image resolution (unmodified)


function wp_theme_save_acf_json($path)
{
    $dir = get_template_directory() . '/inc/acf-json';
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    return $dir;
}
add_filter('acf/settings/save_json', 'wp_theme_save_acf_json');

function wp_theme_load_acf_json($paths)
{
    $paths[] = get_template_directory() . '/inc/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'wp_theme_load_acf_json');
