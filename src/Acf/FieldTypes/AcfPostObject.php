<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

class AcfPostObject extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'return_format' => 'object',
		] );
	}

	/**
	 * @param string|string[] $post_type
	 *
	 * @return AcfPostObject
	 */
	public function post_type( $post_type ): AcfPostObject {
		$option = $this->get_options()['post_type'] ?? [];
		if ( is_array( $post_type ) ) {
			$option = array_merge( $option, $post_type );
		} else {
			$option[] = $post_type;
		}

		return $this->set_option( 'post_type', $option );
	}

	/**
	 * @param string|string[] $taxonomy
	 *
	 */
	public function taxonomy( $taxonomy ): AcfPostObject {
		$option = $this->get_options()['taxonomy'] ?? [];
		if ( is_array( $taxonomy ) ) {
			$option = array_merge( $option, $taxonomy );
		} else {
			$option[] = $taxonomy;
		}

		return $this->set_option( 'taxonomy', $option );
	}

	/**
	 * @param TrueOrFalse $allow_null
	 *
	 * @return AcfPostObject
	 */
	public function allow_null( TrueOrFalse $allow_null ): AcfPostObject {
		return $this->set_option( 'allow_null', $allow_null->get() ? 1 : 0 );
	}

	/**
	 * @param TrueOrFalse $multiple
	 *
	 * @return AcfPostObject
	 */
	public function multiple( TrueOrFalse $multiple ): AcfPostObject {
		return $this->set_option( 'multiple', $multiple->get() ? 1 : 0 );
	}

	function get_type(): string {
		return 'post_object';
	}
}
