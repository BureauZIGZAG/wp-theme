<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

class AcfText extends \Freekattema\Wp\Acf\FieldTypes\AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [

		] );
	}

	public function default_value( string $value ): AcfText {
		return $this->set_option( 'default_value', $value );
	}

	public function placeholder( string $value ): AcfText {
		return $this->set_option( 'placeholder', $value );
	}

	public function prepend( string $value ): AcfText {
		return $this->set_option( 'prepend', $value );
	}

	public function append( string $value ): AcfText {
		return $this->set_option( 'append', $value );
	}

	public function disabled( TrueOrFalse $value ): AcfText {
		return $this->set_option( 'disabled', $value->get() );
	}

	public function readonly( TrueOrFalse $value ): AcfText {
		return $this->set_option( 'readonly', $value->get() );
	}

	function get_type(): string {
		return 'text';
	}
}
