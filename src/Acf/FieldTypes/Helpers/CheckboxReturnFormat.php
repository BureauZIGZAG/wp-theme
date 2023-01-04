<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class CheckboxReturnFormat extends AcfFieldOptionsBaseClass {
	public static function VALUE(): CheckboxReturnFormat {
		return new CheckboxReturnFormat( 'value' );
	}

	public static function LABEL(): CheckboxReturnFormat {
		return new CheckboxReturnFormat( 'label' );
	}

	public static function ARRAY(): CheckboxReturnFormat {
		return new CheckboxReturnFormat( 'array' );
	}
}
