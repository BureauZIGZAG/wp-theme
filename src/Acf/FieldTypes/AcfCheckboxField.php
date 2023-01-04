<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;
use Freekattema\Wp\Acf\FieldTypes\Helpers\AcfLayoutOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\CheckboxReturnFormat;

final class AcfCheckboxField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'choices'       => [],
			'allow_custom'  => 0,
			'save_custom'   => 0,
			'return_format' => 'value',
			'layout'        => 'vertical',
			'toggle'        => 0,
		] );
	}

	/**
	 * @param array $choices
	 *
	 * @return AcfCheckboxField
	 */
	public function choices( array $choices ): AcfCheckboxField {
		return $this->set_option( 'choices', $choices );
	}

	/**
	 * @param TrueOrFalse $allow_custom
	 *
	 * @return AcfCheckboxField
	 */
	public function allow_custom( TrueOrFalse $allow_custom ): AcfCheckboxField {
		return $this->set_option( 'allow_custom', $allow_custom->get() ? 1 : 0 );
	}

	/**
	 * @param TrueOrFalse $save_custom
	 *
	 * @return AcfCheckboxField
	 */
	public function save_custom( TrueOrFalse $save_custom ): AcfCheckboxField {
		return $this->set_option( 'save_custom', $save_custom->get() ? 1 : 0 );
	}

	public function return_format( CheckboxReturnFormat $return_format ): AcfCheckboxField {
		return $this->set_option( 'return_format', $return_format->get() );
	}

	public function layout( AcfLayoutOptions $layout ): AcfCheckboxField {
		return $this->set_option( 'layout', $layout->get() );
	}

	public function enableToggleAll( TrueOrFalse $toggle ): AcfCheckboxField {
		return $this->set_option( 'toggle', $toggle->get() ? 1 : 0 );
	}

	function get_type(): string {
		return 'checkbox';
	}
}
