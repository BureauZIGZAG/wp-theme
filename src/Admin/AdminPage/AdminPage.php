<?php

namespace Freekattema\Wp\Admin\AdminPage;

class AdminPage {
    /** @var AdminPage[] */
    private static $instances = [];

    /** @var string  */
    private $title;
    /** @var string  */
    private $capability = 'manage_options';
    /** @var string  */
    private $icon = 'dashicons-admin-generic';
    /** @var int  */
    private $position = 100;
    /** @var bool  */
    private $is_options_page = false;

    private ?AdminPage $parent = null;

    /** @var AdminPageRoute[] */
    private array $routes = [];

    private function __construct(string $title, bool $is_options_page = false) {
        $this->title = $title;
        $this->is_options_page = $is_options_page;

        add_action('admin_menu', function () {$this->addAdminPage();});
    }

    private function slugFromTitle(): string {
        if(!$this->has_parent()):
        return strtolower(str_replace(' ', '-', $this->title));
        else:
        return $this->parent->slugFromTitle() . '-' . strtolower(str_replace(' ', '-', $this->title));
        endif;
    }

    public function set_icon($icon): self {
        $this->icon = $icon;
        return $this;
    }

    public function has_parent():bool {
        return $this->parent !== null;
    }

    private function addAdminPage(): void
    {
        if($this->is_options_page) {
            add_options_page(
                $this->title,
                $this->title,
                $this->capability,
                $this->slugFromTitle(),
                function () {$this->render();},
            );

            return;
        }

        if(!$this->has_parent()):
            add_menu_page(
                $this->title,
                $this->title,
                $this->capability,
                $this->slugFromTitle(),
                function () {
                    $this->render();
                },
                $this->icon,
                $this->position
            );

            add_submenu_page(
                $this->slugFromTitle(),
                $this->title,
                $this->title,
                $this->capability,
                $this->slugFromTitle(),
                function () {
                    $this->render();
                }
            );

            return;
        endif;

        add_submenu_page(
            $this->parent->slugFromTitle(),
            $this->title,
            $this->title,
            $this->capability,
            $this->slugFromTitle(),
            function () {
                $this->render();
            }
        );

    }

    private function render(): void
    {
        $route = $_GET['route'] ?? null;

        $pageRoute = $this->find_route($route);

        $pageRoute && $pageRoute->render();
    }

    private function find_route(?string $route_param): ?AdminPageRoute
    {
        foreach($this->routes as $route) {
            if ($route->get_slug() === $route_param) {
                return $route;
            }
        }

        return $this->no_rout_found();
    }

    public function add_route(AdminPageRoute $route): AdminPage
    {
        if($route->default) {
            foreach($this->routes as $route) {
                $route->default = false;
            }
        }
        $this->routes[] = $route;
        return $this;
    }

    /**
     * @param AdminPageRoute[] $routes
     * @return $this
     */
    public function add_routes(array $routes): AdminPage
    {
        foreach($routes as $route) {
            $this->add_route($route);
        }
        return $this;
    }

    private function get_default_route(): ?AdminPageRoute
    {
        foreach($this->routes as $route) {
            if ($route->default) {
                return $route;
            }
        }
        return null;
    }


    private function no_rout_found(): AdminPageRoute
    {
        $default_route = $this->get_default_route();
        if($default_route) {
            return $default_route;
        }

        $page = AdminPageRoute::get('No route found');
        $page->default = true;
        $page->set_template(function () {
            echo '<h1>No route found</h1>';
        });
        return $page;
    }

    public static function create(string $title, bool $is_options_page = false): AdminPage
    {
        $adminPage =  new static($title, $is_options_page);
        self::$instances[] = $adminPage;
        return $adminPage;
    }

    public static function get_active(): AdminPage {
        $page = $_GET['page'] ?? null;
        foreach(self::$instances as $instance) {
            if ($instance->slugFromTitle() === $page) {
                return $instance;
            }
        }
        return self::$instances[0];
    }

    public function add_sub_page($title): ?AdminPage
    {
        if($this->is_options_page) {
            return null;
        }

        $adminPage =  new static($title);
        $adminPage->parent = $this;
        self::$instances[] = $adminPage;
        return $adminPage;
    }

    public function get_link(string $route): ?string
    {
        return admin_url('admin.php?page=' . $this->slugFromTitle() . '&route=' . $route);
    }

    public static function goto(string $route = ''):string {
        $adminPage = self::get_active();
        return $adminPage->get_link($route);
    }

    public static function route(): AdminPageRoute {
        $page = self::get_active();
        $route = $_GET['route'] ?? null;
        return $page->find_route($route);
    }

}