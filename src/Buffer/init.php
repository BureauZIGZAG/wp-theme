<?php

add_action('init', function() {
    if(is_admin()) return;
    
    \Freekattema\Wp\Buffer\Buffer::init();
});