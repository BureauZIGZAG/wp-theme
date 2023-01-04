<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;
use Freekattema\Wp\Acf\FieldTypes\Helpers\AcfLayoutOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\CheckboxReturnFormat;

final class AcfRadioField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'choices'       => [],
			'other_choice'  => 0,
			'save_other_choice'   => 0,
			'layout'        => 'vertical',
		] );
	}

	/**
	 * @param array $choices
	 *
	 * @return AcfRadioField
	 */
	public function choices( array $choices ): AcfRadioField {
		return $this->set_option( 'choices', $choices );
	}

	/**
	 * @param TrueOrFalse $other_choice
	 *
	 * @return AcfRadioField
	 */
	public function other_choice( TrueOrFalse $other_choice ): AcfRadioField {
		return $this->set_option( 'other_choice', $other_choice->get() ? 1 : 0 );
	}

	/**
	 * @param TrueOrFalse $save_other_choice
	 *
	 * @return AcfRadioField
	 */
	public function save_other_choice( TrueOrFalse $save_other_choice ): AcfRadioField {
		return $this->set_option( 'save_other_choice', $save_other_choice->get() ? 1 : 0 );
	}

	public function layout(AcfLayoutOptions $layout): AcfRadioField {
		return $this->set_option('layout', $layout->get());
	}

	public function get_type(): string {
		return 'radio';
	}
}
