<?php

namespace Freekattema\Wp\Acf\Traits;

trait HasOptions {
    /** @var array */
    protected $options = [];

    protected function set_option(string $key, $value): self
    {
        $this->options[$key] = $value;
        return $this;
    }

    protected function get_options(): array
    {
        return $this->options;
    }

    protected function merge_with_options(array $array): array
    {
        return array_merge($array, $this->get_options());
    }
}