<?php

namespace Freekattema\Wp\Components;

class ComponentLoader {
    private function __construct() {}

    public static function load($directory = null) {
        if(!$directory) {
            $directory = get_template_directory() . '/Components';
        }

        if(!is_dir($directory)) {
            return;
        }

        $folders = glob( $directory . '/*' , GLOB_ONLYDIR );

        foreach($folders as $folder) {
            $folderName = basename($folder);
            $componentFile = $folder . DIRECTORY_SEPARATOR . $folderName . '.php';

            if (file_exists($componentFile)) {
                include_once $componentFile;
            }
        }
    }
}