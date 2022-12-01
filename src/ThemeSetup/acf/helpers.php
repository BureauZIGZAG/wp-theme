<?php

use Freekattema\Wp\Shared\AcfGroupHelper;

if (!function_exists('get_group')):

    function get_group(string $key, $post_id = false): ?AcfGroupHelper
    {
        $group = get_field($key, $post_id);

        if (is_array($group)) {
            return AcfGroupHelper::construct($group);
        }

        return null;
    }
endif;