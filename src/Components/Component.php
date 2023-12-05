<?php

namespace Freekattema\Wp\Components;

use Exception;
use Freekattema\Wp\Twig\TwigComponentPart;
use Freekattema\Wp\Twig\TwigRenderer;
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
        global $current_component;
        $old_component = $current_component;
        $current_component = /** get current component */ $this->get_template();

        $this->template = $this->get_template();

        if (!$this->before_render()) {
            return;
        }

        if (!file_exists($this->template)) {
            $current_component = $old_component;
            throw new Exception("Template file {$this->template} does not exist");
        }

        TwigRenderer::render($this->template, $this->props->get_all());
        $current_component = $old_component;
    }

    public static function current_user_is_admin(): bool
    {
        return current_user_can('administrator');
    }

    abstract function get_template(): string;

    protected function on_init()
    {
    }

    protected function before_render(): bool
    {
        return true;
    }

    public static function Part(string $name): ComponentPart {
        // get dir of current component
        $reflector = new \ReflectionClass(static::class);
        $dir = dirname($reflector->getFileName());

        $possible_paths = [
            "{$dir}/parts/{$name}.php",
            "{$dir}/parts/{$name}.twig",
        ];

        foreach($possible_paths as $path) {
            if(file_exists($path)) {
                return new ComponentPart($path);
            }
        }
    }
}
