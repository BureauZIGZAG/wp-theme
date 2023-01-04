<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;

class AcfTrueOrFalseField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'message' => 0,
		] );
	}

	/**
	 * @param string $message
	 *
	 * @return AcfTrueOrFalseField
	 */
	public function message( string $message ): AcfTrueOrFalseField {
		return $this->set_option( 'message', $message );
	}

	function get_type(): string {
		return 'true_false';
	}
}
