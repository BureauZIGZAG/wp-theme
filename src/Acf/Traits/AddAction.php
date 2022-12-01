<?php

namespace Freekattema\Wp\Acf\Traits;

trait AddAction
{
    /**
     * @param string $name
     * @param callable|string $callback
     * @param int $priority
     * @param int $accepted_args
     * @return void
     */
    protected function add_action(string $name, $callback = null, int $priority = 10, int $accepted_args = 1): void
    {
        if($callback === null) {
            $callback = $name;
        }

        if(is_string($callback)) {
            $callback = [$this, $callback];
        }
        add_action($name, function () use($callback) {
            $args = func_get_args();
            call_user_func_array($callback, $args);
        }, $priority, $accepted_args);
    }

    /**
     * @param string[] $actions
     * @param callable|string $callback
     * @param int $priority
     * @param int $accepted_args
     * @return void
     */
    protected function add_actions(array $actions, $callback, int $priority = 10, int $accepted_args = 1): void
    {
        foreach ($actions as $action) {
            $this->add_action($action, $callback, $priority, $accepted_args);
        }
    }

    /**
     * @param string $name
     * @param callable|string $callback
     * @param int $priority
     * @param int $accepted_args
     * @return void
     */
    protected function add_filter(string $name, callable $callback, $priority = 10, $accepted_args = 1): void
    {
        add_filter($name, $callback, $priority, $accepted_args);
    }

    /**
     * @param string[] $filters
     * @param callable|string $callback
     * @param int $priority
     * @param int $accepted_args
     * @return void
     */
    protected function add_filters(array $filters, callable $callback, $priority = 10, $accepted_args = 1): void
    {
        foreach ($filters as $filter) {
            $this->add_filter($filter, $callback, $priority, $accepted_args);
        }
    }
}