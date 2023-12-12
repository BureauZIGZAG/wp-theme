<?php

namespace Freekattema\Wp\Twig;

use Freekattema\Wp\Components\ComponentData;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class TwigRenderer {
    private static function get_env(LoaderInterface $loader) {
        $twig = new Environment($loader, [
            'cache' => false
        ]);
        $twig->addExtension(new TwigAcfExtension());
        $twig->addExtension(new TwigComponentPart());
        $twig->addExtension(new TwigWpExtension());
        return $twig;
    }

    public static function render(string $template, array $data = []) {
        $fullPath = $template;
        $loader = new FilesystemLoader(dirname($template));
        $template = basename($template);
        if(str_ends_with($template, '.php')) {
            ComponentData::_set_data(new ComponentData($data));
            include $fullPath;
        } else if (str_ends_with($template, '.twig')) {
            $twig = self::get_env($loader);
            $twig->display(basename($template), $data);
        } else {
            throw new \Exception("Template file {$template} has invalid extension");
        }
    }
}
