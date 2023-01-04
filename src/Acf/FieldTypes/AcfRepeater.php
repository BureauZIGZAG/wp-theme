<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;

final class AcfRepeater extends AcfFieldType {
	use HasOptions;

	/** @var array */
	private $fields;

	function get_additional(): array {
		return $this->merge_with_options( [
			'layout'     => 'block',
			'sub_fields' => $this->get_fields(),
		] );
	}

	public function button_label( string $button_label ): AcfRepeater {
		return $this->set_option( 'button_label', $button_label );
	}

	public function max( int $max ): AcfRepeater {
		return $this->set_option( 'max', $max );
	}

	public function min( int $min ): AcfRepeater {
		return $this->set_option( 'min', $min );
	}

	private function get_fields(): array {
		return array_map( function ( $field ) {
			return $field->to_array();
		}, $this->fields );
	}

	function get_type(): string {
		return 'repeater';
	}

	public function add_field( AcfFieldType $field ): self {
		$this->fields[] = $field;

		return $this;
	}

	public function add_fields( array $fields ): self {
		foreach ( $fields as $field ) {
			$this->add_field( $field );
		}

		return $this;
	}
}
