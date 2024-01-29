<?php

use Freekattema\Wp\Wysiwyg\TinyMcePlugin;

//add_filter('mce_button_2', function($buttons) {
//   return array_merge($buttons, TinyMcePlugin::GetButtons());
//});

add_action('admin_head', 'zz_add_my_tc_button');

function zz_add_my_tc_button() {
    global $typenow;
    // Check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }

    // Check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'zz_add_tinymce_plugin');
        add_filter('mce_buttons', 'zz_register_my_tc_button');
    };
}

// Create the custom TinyMCE plugins
function zz_add_tinymce_plugin($plugin_array) {
    $plugin_array['zz_tc_simple'] =  WPTHEMEDIR . '/includes/zz-btns.js';
    $plugin_array['zz_tc_button'] =  WPTHEMEDIR . '/includes/zz-btns.js';
    $plugin_array['zz_tc_list'] =  WPTHEMEDIR . '/includes/zz-btns.js';
    return $plugin_array;
}
// Add the buttons to the TinyMCE array of buttons that display, so they appear in the WYSIWYG editor
function zz_register_my_tc_button($buttons) {
    array_push($buttons, 'zz_tc_simple');
    array_push($buttons, 'zz_tc_button');
    array_push($buttons, 'zz_tc_list');
    return $buttons;
}
