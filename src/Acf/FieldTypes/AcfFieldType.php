<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

abstract class AcfFieldType {
	/** @var string */
	private string $label;

	/** @var string */
	private string $name;

	/** @var int */
	private int $width = 100;

	private array $standard_options = [];

	private function __construct( string $label, string $name ) {
		$this->label = $label;
		$this->name  = $name;
	}

	public static function create( string $label, string $name ) {
		return new static( $label, strtolower( $name ) );
	}

	public function to_array(): array {
		$DEFAULT = [
			'key'     => $this->get_key(),
			'label'   => $this->label,
			'name'    => $this->name,
			'type'    => $this->get_type(),
			'wrapper' => [
				'width' => $this->width,
			],
		];

		return array_merge( $DEFAULT, $this->standard_options, $this->get_additional() );
	}

	public function width( int $width ): AcfFieldType {
		// cap between 0 and 100
		$width       = max( 0, min( 100, $width ) );
		$this->width = $width;

		return $this;
	}

	public function get_key(): string {
		$name = strtolower( $this->name );

		$random_key = substr( md5( $name ), 0, 6 );

		return 'zigzag_field_' . $random_key;
	}

	public function required( TrueOrFalse $required ): AcfFieldType {
		$this->standard_options['required'] = $required->get() ? 1 : 0;

		return $this;
	}

	public function instructions( string $instructions ): AcfFieldType {
		$this->standard_options['instructions'] = $instructions;

		return $this;
	}

	public function default_value( $value ): AcfFieldType {
		$this->standard_options['default_value'] = $value;

		return $this;
	}

	abstract function get_additional(): array;

	abstract function get_type(): string;

	public function get_label(): string {
		return $this->label;
	}

	public function get_name(): string {
		return $this->name;
	}
}
