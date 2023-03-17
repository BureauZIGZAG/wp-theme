<?php

namespace Freekattema\Wp\Admin\Docs;

use DOMDocument;
use cebe\markdown\GithubMarkdown;

class DisplayAdminDocs {
	private static $instance = null;

	private function __construct( $dir, $is_rest = false ) {
		$this->docsDir = $dir;

		! $is_rest && $this->display_docs();
	}

	public static function init( $dir, $is_rest = false ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $dir, $is_rest );
		}

		return self::$instance;
	}


	private function display_docs() {
		$current_page = $this->get_current_page();
		$this->add_colors();

		$doc = new DOMDocument();

		// wrap all content in a div
		$div = $doc->createElement( 'div' );
		$div->setAttribute( 'class', 'markdown-content' );

		$rootElementCount = $div->childElementCount;
		while ( $doc->firstChild ) {
			$div->appendChild( $doc->firstChild );
		}

		$container = $doc->createElement( 'div' );
		$container->setAttribute( 'class', 'markdown-container' );
		$container->appendChild( $div );

		// create meta element for the current page
		$meta = $doc->createElement( 'meta' );
		$meta->setAttribute( 'id', 'current-page' );
		$meta->setAttribute( 'content', $current_page );
		$container->appendChild( $meta );

		$doc->appendChild( $container );

		echo $this->get_body_content( $doc );
	}

	public function markdownToHtml( $markDownFile ) {
		// get the content of the current markdown file
		$content = file_get_contents( $this->docsDir . '/' . $markDownFile );

		// convert the markdown to html
		$parser                 = new GithubMarkdown();
		$parser->html5          = true;
		$parser->enableNewlines = true;
		$content                = $parser->parse( $content );

//		$doc = new DOMDocument();
//		$doc->loadHTML( $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
//
//		$links = $doc->getElementsByTagName( 'a' );
//
//		// if the link is relative transform into get parameter
//		foreach ( $links as $link ) {
//			$href = $link->getAttribute( 'href' );
//
//			$isRelative = ! isset( parse_url( $href )['scheme'] );
//
//			if ( $isRelative ) {
//				$href = sprintf( "?page=%s&docs_screen=%s", ADMIN_DOCS_SLUG, urlencode( $href ) );
//				$link->setAttribute( 'href', $href );
//			}
//		}

		return htmlentities( $content );
	}

	private function get_body_content( $doc ) {
		$content = $doc->saveHTML();

		return preg_replace( '/.*<body[^>]*>(.*)<\/body>.*/is', '$1', $content );
	}

	private function get_current_page() {
		// get the current markdown file
		// if no file is set, use the index.md file
		$current_page = $_GET['docs_screen'] ?? 'index.md';

		// check if the file exists
		if ( ! file_exists( $this->docsDir . '/' . $current_page ) ) {
			// if not, use the index.md file
			$current_page = 'index.md';
		}

		return $current_page;
	}

	private function add_colors() {
		global $_wp_admin_css_colors;
		$current_color  = get_user_option( 'admin_color' );
		$current_colors = $_wp_admin_css_colors[ $current_color ];
		$colors         = [
			'wp-colors-1' => $current_colors->colors[0],
			'wp-colors-2' => $current_colors->colors[1],
			'wp-colors-3' => $current_colors->colors[2],
			'wp-colors-4' => $current_colors->colors[3],
		];

		// generate css variables from colors
		$css = '';
		foreach ( $colors as $name => $color ) {
			$css .= sprintf( '--%s: %s;', $name, $color );
		}

		// add css variables to the page
		echo sprintf( '<style>:root{%s}</style>', $css );
	}
}
