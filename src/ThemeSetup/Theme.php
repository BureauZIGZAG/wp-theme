<?php

namespace Freekattema\Wp\ThemeSetup;

final class Theme
{
    private static $instance;
    
    public function get(): Theme
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        // do nothing
    }

    public function HideAdminPosts(): Theme
    {
        add_action('admin_menu', function () {
            remove_menu_page('edit.php');
        });

        return $this;
    }

    public function HideAdminComments(): Theme
    {
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        return $this;
    }

    public function HideAdminTools(): Theme
    {
        add_action('admin_menu', function () {
            remove_menu_page('tools.php');
        });

        return $this;
    }

    public function registerNavMenus($menus = []): Theme
    {
        add_action('init', function () use ($menus) {
            register_nav_menus($menus);
        });

        return $this;
    }


    public function removeDefaultWordpressStyling(): Theme
    {
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
        }, 100);

        return $this;
    }

    public function removeWordpressJquery(): Theme
    {
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_script('jquery');
        }, 100);

        return $this;
    }

    public function hideMustUsePlugins(): Theme
    {
        add_filter('views_plugins', function ($views) {
            unset($views['mustuse']);
            return $views;
        });

        return $this;
    }

    public function hideAdminDashboard(): Theme
    {
        add_action('admin_init', function () {
            remove_action('welcome_panel', 'wp_welcome_panel');
        });

        return $this;
    }

    public function hideAdminBar(): Theme
    {
        add_filter('show_admin_bar', '__return_false');

        return $this;
    }

    public function adminBarCleanup($exclude = []): Theme
    {
        add_action('wp_before_admin_bar_render', function() use ($exclude) {

            global $wp_admin_bar;
            $remove_items = [
                'wp-logo',
                'about',
                'wporg',
                'documentation',
                'support-forums',
                'feedback',
                'updates',
                'comments',
                'customize',
                'imagify',
            ];

            foreach ($remove_items as $item) {
                if (!in_array($item, $exclude)) {
                    $wp_admin_bar->remove_menu($item);
                }
            }
        });

        return $this;
    }


    public function hideAdminDashboardWidgets($exclude = []): Theme
    {
        $remove_boxes = [
            'normal' => [
                'dashboard_right_now',
                'dashboard_recent_comments',
                'dashboard_incoming_links',
                'dashboard_activity',
                'dashboard_plugins',
                'dashboard_site_health',
                'sendgrid_statistics_widget',
                'wpseo-dashboard-overview', // yoast
                'rg_forms_dashboard', // gravity forms
                'dashboard_rediscache',
                'dashboard_php_nag',
                'yith_dashboard_products_news', // all YITH plugins
                'yith_dashboard_blog_news', // all YITH plugins
            ],
            'side' => [
                'dashboard_quick_press',
                'dashboard_recent_drafts',
                'dashboard_primary',
                'dashboard_secondary',
            ],
        ];

        add_action('wp_dashboard_setup', function () use ($exclude, $remove_boxes) {
            foreach ($remove_boxes as $context => $boxes) {
                foreach ($boxes as $box) {
                    if (!in_array($box, $exclude)) {
                        remove_meta_box($box, 'dashboard', $context);
                    }
                }
            }
        });

        return $this;
    }
}