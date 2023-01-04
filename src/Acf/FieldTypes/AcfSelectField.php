<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

final class AcfSelectField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'allow_null'  => 0,
			'choices'     => [],
			'placeholder' => '',
			'multiple'    => 0,
		] );
	}

	/**
	 * @param string $placeholder
	 *
	 * @return AcfSelectField
	 */
	public function placeholder( string $placeholder ): AcfSelectField {
		return $this->set_option( 'placeholder', $placeholder );
	}

	/**
	 * @param TrueOrFalse $allow_null
	 *
	 * @return AcfSelectField
	 */
	public function allow_null( TrueOrFalse $allow_null ): AcfSelectField {
		return $this->set_option( 'allow_null', $allow_null->get() ? 1 : 0 );
	}

	/**
	 * @param array $choices
	 *
	 * @return AcfSelectField
	 */
	public function choices( array $choices ): AcfSelectField {
		return $this->set_option( 'choices', $choices );
	}

	/**
	 * @param TrueOrFalse $multiple
	 *
	 * @return AcfSelectField
	 */
	public function multiple( TrueOrFalse $multiple ): AcfSelectField {
		return $this->set_option( 'multiple', $multiple->get() ? 1 : 0 );
	}


	function get_type(): string {
		return 'select';
	}
}
