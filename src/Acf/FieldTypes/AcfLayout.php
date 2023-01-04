<?php

namespace Freekattema\Wp\Acf\FieldTypes;

final class AcfLayout extends AcfFieldType {
	/** @var array */
	private array $fields = [];

	function get_additional(): array {
		return [
			'display'    => 'block',
			'sub_fields' => $this->get_fields(),
		];
	}

	private function get_fields(): array {
		return array_map( function ( $field ) {
			return $field->to_array();
		}, $this->fields );
	}

	function get_type(): string {
		return 'layout';
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

	public static function from_field( AcfFieldType $field ): AcfLayout {
		$layout = AcfLayout::create( $field->get_label(), $field->get_name() );
		$layout->add_field( $field );

		return $layout;
	}

	public static function from_fields( string $label, string $name, array $fields ): AcfLayout {
		$layout = AcfLayout::create( $label, $name );
		$layout->add_fields( $fields );

		return $layout;
	}
}
