<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class AcfGroupStyle extends AcfFieldOptionsBaseClass {
	public static function DEFAULT(): AcfGroupStyle {
		return new self( 'default' );
	}

	public static function SEAMLESS(): AcfGroupStyle {
		return new self( 'seamless' );
	}
}
