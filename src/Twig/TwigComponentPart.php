<?php

namespace Freekattema\Wp\Twig;

use Freekattema\Wp\Components\ComponentPart;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigComponentPart extends AbstractExtension {
    public function getFunctions(): array
    {
        return [
            new TwigFunction('part', [$this, 'render_part'], ['is_safe' => ['html']]),
            new TwigFunction('component', [$this, 'render_component'], ['is_safe' => ['html']]),
            new TwigFunction('dump', [$this, 'dump'], ['is_safe' => ['html']]),
            new TwigFunction('get', [$this, 'get'], ['is_safe' => ['html']]),
        ];
    }

    public function render_part(string $path, array $data = []) {
        global $current_component;
        $current_template_dirname = dirname($current_component);
        $path = $current_template_dirname . '/parts/' . $path;
        $has_extension = str_ends_with($path, '.twig') || str_ends_with($path, '.php');
        if(!$has_extension) {
            $path .= '.twig';
        }
        $part = new ComponentPart($path);
        $part->render($data);
    }

    public function render_component(string $component, array $data = []) {
        if (!class_exists($component)) {
            throw new \Exception("Component class {$component} does not exist");
        }

        $component::display($data);
    }

    public function dump(...$args) {
        return var_export($args, true);
    }

    public function get($array, ...$path) {
        $current = $array;
        foreach($path as $key) {
            if(!isset($current[$key])) {
                return null;
            }
            $current = $current[$key];
        }
        return $current;
    }
}
