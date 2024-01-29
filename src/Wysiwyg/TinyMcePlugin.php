<?php

namespace Freekattema\Wp\Wysiwyg;

class TinyMcePlugin {
    private static $registered_buttons = [];

    public static function GetButtons()
    {
        return self::$registered_buttons;
    }

}
