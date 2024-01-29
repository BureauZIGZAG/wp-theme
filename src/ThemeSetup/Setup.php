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

