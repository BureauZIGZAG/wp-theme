<?php

namespace Freekattema\Wp\Shared;

class Link {
    public string $url = '';
    public string $target = '';
    public string $title = '';

    public function __construct($url, $target, $title)
    {
        $this->url = $url;
        $this->target = $target;
        $this->title = $title;
    }

    public function render(string $classes = ''): void
    {
        echo $this->get_html($classes);
    }

    public function get_html(string $classes = ''): string
    {
        $target = $this->target ? ' target="' . $this->target . '"' : '';
        $title = $this->title ? ' title="' . $this->title . '"' : '';
        return '<a href="' . $this->url . '"' . $target . $title . '>' . $this->title . '</a>';
    }
}