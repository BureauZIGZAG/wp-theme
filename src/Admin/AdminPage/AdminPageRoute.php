<?php

namespace Freekattema\Wp\Admin\AdminPage;

final class AdminPageRoute {
    private bool $rendered = false;
    public bool $default = false;
    public string $title;

    /** @var Callable|string */
    private $template;

    private function __construct(string $title) {
        $this->title = $title;
    }

    public function get_slug(): string {
        return strtolower(str_replace(' ', '-', $this->title));
    }

    public static function get(string $title): AdminPageRoute
    {
        return new AdminPageRoute($title);
    }

    public function default(): AdminPageRoute
    {
        $this->default = true;
        return $this;
    }

    public function render() {
        if($this->rendered) return;

        if (is_callable($this->template)) {
            call_user_func($this->template);
        } else {
            require_once $this->template;
        }

        $this->rendered = true;
    }

    /**
     * @param Callable|string $template
     * @return $this
     */
    public function set_template($template): AdminPageRoute
    {
        $this->template = $template;
        return $this;
    }
}