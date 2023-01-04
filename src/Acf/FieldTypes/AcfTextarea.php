<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

class AcfTextarea extends \Freekattema\Wp\Acf\FieldTypes\AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [

		] );
	}

	public function default_value( string $value ): AcfTextarea {
		return $this->set_option( 'default_value', $value );
	}

	public function placeholder( string $value ): AcfTextarea {
		return $this->set_option( 'placeholder', $value );
	}

	public function rows( int $value ): AcfTextarea {
		return $this->set_option( 'rows', $value );
	}

	public function maxLength( int $value ): AcfTextarea {
		return $this->set_option( 'maxlength', $value );
	}

	public function disabled( TrueOrFalse $value ): AcfTextarea {
		return $this->set_option( 'disabled', $value->get() );
	}

	public function readonly( TrueOrFalse $value ): AcfTextarea {
		return $this->set_option( 'readonly', $value->get() );
	}

	function get_type(): string {
		return 'textarea';
	}
}
