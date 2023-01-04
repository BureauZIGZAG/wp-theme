<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

class AcfNumber extends \Freekattema\Wp\Acf\FieldTypes\AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [

		] );
	}

	public function placeholder( string $value ): AcfNumber {
		return $this->set_option( 'placeholder', $value );
	}

	public function prepend( string $value ): AcfNumber {
		return $this->set_option( 'prepend', $value );
	}

	public function append( string $value ): AcfNumber {
		return $this->set_option( 'append', $value );
	}

	public function min( int $value ): AcfNumber {
		return $this->set_option( 'min', $value );
	}

	public function max( int $value ): AcfNumber {
		return $this->set_option( 'max', $value );
	}

	public function step( int $value ): AcfNumber {
		return $this->set_option( 'step', $value );
	}

	function get_type(): string {
		return 'number';
	}
}
