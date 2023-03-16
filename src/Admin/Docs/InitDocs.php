<?php

if(!function_exists('get_template_directory')) {
	exit;
}

$themeDir = get_template_directory();

$docsDir = $themeDir . '/docs';

if(!file_exists($docsDir)) {
	mkdir($docsDir);
	// create a README.md file
	file_put_contents($docsDir . '/README.md', '## Welcome to your new site docs!');
}

Freekattema\Wp\Admin\Docs\SiteAdminDocs::init();
