<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

class AcfUserField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'role'       => [],
			'allow_null' => 0,
			'multiple'   => 0,
		] );
	}

	/**
	 * @param string|string[] $role
	 *
	 * @return AcfUserField
	 */
	public function role( $role ): AcfUserField {
		$role = is_array( $role ) ? $role : [ $role ];

		return $this->set_option( 'role', $role );
	}

	/**
	 * @param TrueOrFalse $allow_null
	 *
	 * @return AcfUserField
	 */
	public function allow_null( TrueOrFalse $allow_null ): AcfUserField {
		return $this->set_option( 'allow_null', $allow_null->get() ? 1 : 0 );
	}

	/**
	 * @param TrueOrFalse $multiple
	 *
	 * @return AcfUserField
	 */
	public function multiple( TrueOrFalse $multiple ): AcfUserField {
		return $this->set_option( 'multiple', $multiple->get() ? 1 : 0 );
	}

	function get_type(): string {
		return 'user';
	}
}
