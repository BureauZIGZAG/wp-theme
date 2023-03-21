<?php

namespace Freekattema\Wp\Components;

use Freekattema\Wp\Buffer\Buffer;

final class ComponentAssetsLoader
{
    private function __construct() {}

    public static function attach(string $component)
    {
	    $cssFile = '/dist/exports/' . $component . '.css';
	    if ( file_exists( get_stylesheet_directory() . $cssFile ) ) {
		    Buffer::add_css( get_stylesheet_directory_uri() . $cssFile );
	    }
    }
}
