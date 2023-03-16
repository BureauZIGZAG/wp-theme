<?php

namespace Freekattema\Wp\Admin\Docs;

class SiteAdminDocs {
	private static $instance = null;

	private function __construct() {
		try {
			$this->check_needed_functions();
		} catch ( \Exception $e ) {
			error_log( $e->getMessage() );
			return;
		}

		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public static function init() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
	}

	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( !empty( $screen ) && $screen->id === 'dashboard_page_site-help' ) {
			wp_enqueue_style( 'site-help', plugins_url( 'site-help.css', __FILE__ ), [], '1.0.0', 'all' );
			wp_enqueue_script( 'site-help', plugins_url( 'site-help.js', __FILE__ ), [], '1.0.0', true );
		}
	}

	public function add_admin_menu() {
		// add a new admin page for the docs
		// it should only be visible to admins
		add_dashboard_page( 'Site docs', 'Site docs', 'manage_options', 'site-help', [ $this, 'display_docs' ] );
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

		foreach ($needed_functions as $function) {
			if(!function_exists($function)) {
				throw new \Exception("Function $function is not available");
			}
		}
	}
}
