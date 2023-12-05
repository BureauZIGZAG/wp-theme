<?php

namespace Freekattema\Wp\Components;

use Freekattema\Wp\Twig\TwigComponentPart;
use Freekattema\Wp\Twig\TwigRenderer;
use Twig\Extension\DebugExtension;

class ComponentPart
{
    private string $path;
    private bool $is_twig = false;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->is_twig = str_ends_with($path, '.twig');
    }

    public function render(array $data = [])
    {
        if (!file_exists($this->path)) {
            throw new Exception("Template file {$this->path} does not exist");
        }

        TwigRenderer::render($this->path, $data);
    }
}
