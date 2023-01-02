<?php


namespace Freekattema\Wp\Acf\FieldTypes;

final class AcfPost extends AcfFieldType {
	function get_additional(): array {
		return [
			'post_type' => [],
			'return_format' => 'object',
		];
	}

	function get_type(): string {
		return 'post_object';
	}

	public function set_post_type( string $post_type ): self {
		$this->additional['post_type'][] = $post_type;
		return $this;
	}

	public function set_post_types( array $post_types ): self {
		$this->additional['post_type'] = $post_types;
		return $this;
	}

	public function return_id(): self {
		$this->additional['return_format'] = 'id';
		return $this;
	}

	public function return_object(): self {
		$this->additional['return_format'] = 'object';
		return $this;
	}

	public function multiple(): self {
		$this->additional['multiple'] = 1;
		return $this;
	}

	public function single(): self {
		$this->additional['multiple'] = 0;
		return $this;
	}
}
