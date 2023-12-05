<?php

namespace Freekattema\Wp\Components;

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

        if($this->is_twig) {
            $this->render_twig($data);
        } else {
            $this->render_php($data);
        }
    }

    private function render_twig(array $data)
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname($this->path));
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        if(Component::current_user_is_admin()) {
            $twig->addExtension(new DebugExtension());
        }


        echo $twig->render(basename($this->path), $data);
    }

    private function render_php(array $data)
    {
        ComponentData::_set_data(new ComponentData($data));
        try {
            $this->include_php();
        } catch (\Throwable $e) {
            // do nothing
        }
    }

    private function include_php()
    {
        include $this->path;
    }


}
