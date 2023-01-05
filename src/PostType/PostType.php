<?php

namespace Freekattema\Wp\PostType;

class PostType {
	private string $plural_name;
	private string $singular_name;
	private string $post_type;

	public function __construct( string $post_type, string $singular_name, string $plural_name, array $args = [] ) {
		$this->post_type     = $post_type;
		$this->singular_name = $singular_name;
		$this->plural_name   = $plural_name;

		$DEFAULT = [
			'labels'       => [
				'name'          => $plural_name,
				'singular_name' => $singular_name,
			],
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
		];

		$args = array_merge( $DEFAULT, $args );

		add_action( 'init', function () use ( $args ) {
			register_post_type( $this->post_type, $args );
		} );
	}

	public function get_post_type(): string {
		return $this->post_type;
	}

	public function get_singular_name(): string {
		return $this->singular_name;
	}

	public function get_plural_name(): string {
		return $this->plural_name;
	}

	public function create_post( string $title, string $content = '', string $status = 'publish' ): int {
		$post_id = wp_insert_post( [
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => $status,
			'post_type'    => $this->post_type,
		] );

		return $post_id;
	}
}
