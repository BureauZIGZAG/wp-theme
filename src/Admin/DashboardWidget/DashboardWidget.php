<?php

namespace Freekattema\Wp\Admin\DashboardWidget;

use Freekattema\Wp\Shared\Traits\AddAction;

final class DashboardWidget {
    use AddAction;

    private string $title;
    /** @var callable */
    private $callback;

    /** @var callable[] */
    private array $conditions = [];
    private string $context = 'normal';
    private string $_priority = 'core';

    private function get_slug(): string {
        return 'zigzag-engine-dashboard-widget_' . sanitize_title($this->title);
    }

    private function __construct(string $title, callable $callback = null) {
        $this->title = $title;
        $this->callback = $callback;
        $this->add_action('wp_dashboard_setup', 'addDashboardWidget');
    }

    private function addDashboardWidget() {
        if(!$this->callback) {
            return;
        }

        if(!$this->checkConditions()) {
            return;
        }

        wp_add_dashboard_widget(
            $this->get_slug(),
            $this->title,
            $this->callback,
            null,
            null,
            $this->context,
            $this->_priority,

        );
    }

    public function column(int $column = 1): DashboardWidget
    {
        switch ($column) {
            case 1:
                $column = 'normal';
                break;
            case 2:
                $column = 'side';
                break;
            case 3:
                $column = 'column3';
                break;
            case 4:
                $column = 'column4';
                break;
            default:
                $column = 'normal';
        }
        $this->context = $column;
        return $this;
    }

    public function priority(int $priority = 1): DashboardWidget
    {
        switch ($priority) {
            case 1:
                $priority = 'high';
                break;
            case 2:
                $priority = 'core';
                break;
            case 3:
                $priority = 'default';
                break;
            case 4:
                $priority = 'low';
                break;
            default:
                $priority = 'core';
        }
        $this->_priority = $priority;
        return $this;
    }

    private function checkConditions(): bool {
        foreach ($this->conditions as $condition) {
            if (!$condition()) {
                return false;
            }
        }
        return true;
    }

    public function add_if(callable $condition): DashboardWidget
    {
        $this->conditions[] = $condition;
        return $this;
    }

    public function set_callback(callable $callback): DashboardWidget
    {
        $this->callback = $callback;
        return $this;
    }

    public function set_template(string $path, array $data = []): DashboardWidget
    {
        if(!file_exists($path)) {
            return $this;
        }

        $this->callback = function () use ($path, $data) {
            include $path;
        };
        return $this;
    }

    public static function create(string $title, callable $callback = null): DashboardWidget
    {
        return new DashboardWidget($title, $callback);
    }
}