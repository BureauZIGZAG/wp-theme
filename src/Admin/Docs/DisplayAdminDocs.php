<?php

namespace Freekattema\Wp\Admin\Docs;

use DOMDocument;
use cebe\markdown\GithubMarkdown;

class DisplayAdminDocs {
	private static $instance = null;

	private function __construct( $dir ) {
		$this->docsDir = $dir;

		$this->display_docs();
	}

	public static function init( $dir ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $dir );
		}
	}

	private function display_docs() {
		$current_page   = $this->get_current_page();
		$current_screen = get_current_screen();

		// get the content of the current markdown file
		$content = file_get_contents( $this->docsDir . '/' . $current_page );

		// convert the markdown to html
		$content = $this->markdown_to_html( $content );

		$doc = new DOMDocument();
		$doc->loadHTML( $content );

		$links = $doc->getElementsByTagName( 'a' );

		// if the link is relative transform into get parameter
		foreach ( $links as $link ) {
			$href = $link->getAttribute( 'href' );

			$isRelative = ! isset( parse_url( $href )['scheme'] );

			if ( $isRelative ) {
				$href = sprintf( "?page=%s&docs_screen=%s", $this->get_request_param( 'page' ), urlencode( $href ) );
				$link->setAttribute( 'href', $href );
				$link->setAttribute( 'data-current-screen', json_encode( $current_screen ) );
			}
		}

		// add stylesheet
		$style = $doc->createElement( 'link' );
		$style->setAttribute( 'rel', 'stylesheet' );
		$style->setAttribute( 'href', $this->get_style_url() );
		$doc->appendChild( $style );

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

		$doc->appendChild( $container );


		$content = $doc->saveHTML();

		echo $content;


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

	private function markdown_to_html( string $content ): string {
		$parser = new GithubMarkdown();

		return $parser->parse( $content );
	}

	private function get_request_param( $key, $default = null ) {
		// If not request set
		if ( ! isset( $_REQUEST[ $key ] ) || empty( $_REQUEST[ $key ] ) ) {
			return $default;
		}

		// Set so process it
		return strip_tags( (string) wp_unslash( $_REQUEST[ $key ] ) );
	}

	private function get_style_url() {
		$server_file = __DIR__ . '/DocsStyling.min.css';

		return str_replace( get_template_directory(), get_template_directory_uri(), $server_file );
	}
}
