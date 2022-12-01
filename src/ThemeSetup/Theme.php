<?php

namespace Freekattema\Wp\ThemeSetup;

final class Theme {
    private function __construct() {
        // do nothing
    }

    public static function HideAdminPosts() {
        add_action('admin_menu', function() {
            remove_menu_page('edit.php');
        });
    }

    public static function HideAdminComments() {
        add_action('admin_menu', function() {
            remove_menu_page('edit-comments.php');
        });
    }

    public static function HideAdminTools() {
        add_action('admin_menu', function() {
            remove_menu_page('tools.php');
        });
    }

    public static function registerNavMenus($menus = []) {
        add_action('init', function() use ($menus) {
            register_nav_menus($menus);
        });
    }


    public static function removeDefaultWordpressStyling() {
        add_action('wp_enqueue_scripts',function() {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
        }, 100);
    }

    public static function removeWordpressJquery() {
        add_action('wp_enqueue_scripts',function() {
            wp_deregister_script('jquery');
        }, 100);
    }

    public static function hideMustUsePlugins() {
        add_filter('views_plugins',function($views) {
            unset($views['mustuse']);
            return $views;
        });
    }
}