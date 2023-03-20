<?php

namespace Freekattema\Wp\Admin\Docs;

use Exception;
use WP_REST_Request;

define( 'ADMIN_DOCS_SLUG', 'site-help' );

class SiteAdminDocs {
	private $docsDir;

	private static $instance = null;

	private function __construct() {
		try {
			$this->check_needed_functions();
		} catch ( Exception $e ) {
			error_log( $e->getMessage() );

			return;
		}

		$this->docsDir = self::get_docs_dir();

		add_action( 'init', function () {
			global $wp;
			$wp->add_query_var( 'docs_screen' );
			$wp->add_query_var( 'page' );
		} );
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public static function init() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
	}

	public function enqueue_scripts() {
		$screen = get_current_screen();


		// find uri of current dir
		$currentDir         = __DIR__;
		$currentTemplateUri = get_template_directory_uri();

		$currentDir = explode( '/wp-content/themes/', $currentDir )[1];
		// remove parent dir from current dir
		$currentDir = '/wp-content/themes/' . $currentDir;


		// add template uri to current dir
		$currentDirUrl = $currentDir;
		$scripts       = [
			'site-docs-script' => $currentDirUrl . '/assets/siteDocs.js',
			'highlight-lib'    => $currentDirUrl . '/assets/highlighter.js',
		];
		$styles        = [
			'site-docs-style' => $currentDirUrl . '/assets/DocsStyling.min.css',
			'highlight'       => $currentDirUrl . '/assets/github-dark.min.css',
		];

		foreach ( $scripts as $handle => $script ) {
			wp_enqueue_script( $handle, $script, [], '1.0.0', true );
		}

		foreach ( $styles as $handle => $style ) {
			wp_enqueue_style( $handle, $style, [], '1.0.0', 'all' );
		}

		wp_localize_script( 'site-docs-script', 'siteDocs', [
			'rest_root'     => esc_url_raw( rest_url() ),
			'rest_path'     => 'zigzag-engine/v1/docs',
			'nonce'         => wp_create_nonce( 'wp_rest' ),
			'currentScreen' => $screen->id,
			'currentSlug'   => ADMIN_DOCS_SLUG,
		] );
	}

	public function add_admin_menu() {
		// add a new admin page for the docs
		// it should only be visible to admins
		add_dashboard_page( 'Site docs', 'Site docs', 'manage_options', ADMIN_DOCS_SLUG, [ $this, 'display_docs' ] );
	}

	public function display_docs() {
		DisplayAdminDocs::init( $this->docsDir );
	}

	private function check_needed_functions() {
		$needed_functions = [
			'add_action',
			'add_dashboard_page',
			'get_current_screen',
			'plugins_url',
			'wp_enqueue_style',
			'wp_enqueue_script',
		];

		foreach ( $needed_functions as $function ) {
			if ( ! function_exists( $function ) ) {
				throw new Exception( "Function $function is not available" );
			}
		}
	}

	public static function get_docs_rest( WP_REST_Request $request ) {
		$page = $request->get_param( 'page' ) ?? 'index.md';

		$docs = DisplayAdminDocs::init( self::get_docs_dir(), true );

		$html = $docs->markdownToHtml( $page );

		return $html;
	}

	private static function get_docs_dir() {
		return get_template_directory() . '/docs';
	}
}
