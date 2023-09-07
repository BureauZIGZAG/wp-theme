<?php

function run_docs() {

    add_action( 'rest_api_init', function () {
        $namespace = 'zigzag-engine/v1';
        $route     = '/docs/(?P<page>.+)';
        register_rest_route( $namespace, $route, [
            'methods'             => 'GET',
            'callback'            => function ( $request ) {
                $htmlContent = Freekattema\Wp\Admin\Docs\SiteAdminDocs::get_docs_rest( $request );

                return new WP_REST_Response(
                    [
                        'html' => $htmlContent,
                    ],
                    200
                );
            },
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    } );

    if ( ! function_exists( 'get_template_directory' ) ) {
        return;
    }

    $themeDir = get_template_directory();

    $docsDir = $themeDir . '/docs';

    if ( ! file_exists( $docsDir ) ) {
        return;
    }

    Freekattema\Wp\Admin\Docs\SiteAdminDocs::init();

}

run_docs();