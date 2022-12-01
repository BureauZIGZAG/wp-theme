<?php


// Gravity forms dynamic dropdown events
add_filter('gform_pre_render', 'custom_gform_populate_posts');
add_filter('gform_pre_validation', 'custom_gform_populate_posts');
add_filter('gform_pre_submission_filter', 'custom_gform_populate_posts');
add_filter('gform_admin_pre_render', 'custom_gform_populate_posts');
if(!function_exists('custom_gform_populate_posts')):
    function custom_gform_populate_posts($form)
    {
        foreach($form['fields'] as &$field) {
            // check if the field is a dropdown
            if($field->type != 'select') continue;

            // regex for extracting the post type from the class attribute
            $regex = '/populate-(\w+)+/';

            // extract the post type
            preg_match($regex, $field->cssClass, $matches);

            // check if the post type was found
            if(!$matches) continue;
            if(!isset($matches[1])) continue;

            $post_type = $matches[1];

            // get posts using the post type
            $posts = get_posts([
                'post_type' => $post_type,
                'numberposts' => -1,
                'post_status' => 'publish'
            ]);

            // add the posts to the field's choices
            foreach($posts as $post) {
                $field->choices[] = array('text' => $post->post_title, 'value' => $post->post_title);
            }
        }

        return $form;
    }
endif;