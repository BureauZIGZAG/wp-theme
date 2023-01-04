<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TaxonomyFieldTypes;
use Freekattema\Wp\Acf\FieldTypes\Helpers\ReturnFormatIdOrObject;

class AcfTaxonomyReference extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'return_format' => 'id',
			'add_term'      => 0,
		] );
	}

	public function return_format( ReturnFormatIdOrObject $return_format ): AcfTaxonomyReference {
		return $this->set_option( 'return_format', $return_format->get() );
	}

	public function field_type( TaxonomyFieldTypes $field_type ): AcfTaxonomyReference {
		return $this->set_option( 'field_type', $field_type->get() );
	}

	public function add_term( $enable = true ): AcfTaxonomyReference {
		return $this->set_option( 'add_term', $enable ? 1 : 0 );
	}

	function get_type(): string {
		return 'taxonomy';
	}
}
