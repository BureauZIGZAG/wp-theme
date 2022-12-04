<?php

namespace Freekattema\Wp\Shared;

class Image
{
    public string $url;
    public string $alt;

    public function __construct($url, $alt)
    {
        $this->url = $url;
        $this->alt = $alt;
    }

    public function render(string $classes = '', bool $lazy = false)
    {
        echo $this->get_html($classes, $lazy);
    }

    public function get_html(string $classes = '', bool $lazy = false): string
    {
        $classes = $classes ? ' class="' . $classes . '"' : '';
        $alt = $this->alt ? ' alt="' . $this->alt . '"' : '';
        $src = $lazy ? ' data-src="' . $this->url . '"' : ' src="' . $this->url . '"';
        return '<img' . $classes . $alt . $src . '>';
    }
}
