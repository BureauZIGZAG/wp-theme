<?php

namespace Freekattema\Wp\Components;

use Exception;
use Twig\Extension\DebugExtension;

abstract class Component
{
    protected ComponentData $props;

    private string $template;

    protected function __construct(array $props = [])
    {
        $this->props = new ComponentData($props);

        $this->on_init();
    }

    final public static function get(array $props = [])
    {
        $component = new static($props);
        ComponentAssetsLoader::attach(get_class($component));
        return $component;
    }

    final public static function display($props = [])
    {
        static::get($props)->render();
    }

    final public function render()
    {
        $this->template = $this->get_template();

        if (!$this->before_render()) {
            return;
        }

        if (!file_exists($this->template)) {
            throw new Exception("Template file {$this->template} does not exist");
        }

        if(str_ends_with($this->template, '.php')) {
            ComponentData::_set_data($this->props);
            include $this->template;
        } else if (str_ends_with($this->template, '.twig')) {
            $this->render_twig();
        } else {
            throw new Exception("Template file {$this->template} has invalid extension");
        }
    }

    private function render_twig()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname($this->template));
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        $twig->addExtension(new  DebugExtension());

        $twig->display(basename($this->template), $this->props->get_all());
    }

    abstract function get_template(): string;

    protected function on_init()
    {
    }

    protected function before_render(): bool
    {
        return true;
    }
}