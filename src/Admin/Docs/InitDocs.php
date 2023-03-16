<?php

if ( ! function_exists( 'get_template_directory' ) ) {
	exit;
}

$themeDir = get_template_directory();

$docsDir = $themeDir . '/docs';

if ( ! file_exists( $docsDir ) ) {
	exit;
}

Freekattema\Wp\Admin\Docs\SiteAdminDocs::init();
