<?php

namespace Freekattema\Wp\Admin\DashboardWidget;

use Freekattema\Wp\Shared\Traits\AddAction;

final class DashboardWidget {
    use AddAction;

    private string $title;
    /** @var callable */
    private $callback;

    /** @var callable[] */
    private $conditions = [];

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

        wp_add_dashboard_widget(
            $this->get_slug(),
            $this->title,
            $this->callback
        );
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

    public static function create(string $title, callable $callback = null): DashboardWidget
    {
        return new DashboardWidget($title, $callback);
    }
}