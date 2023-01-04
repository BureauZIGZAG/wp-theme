<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class AcfLayoutOptions extends AcfFieldOptionsBaseClass {
	public static function VERTICAL(): AcfLayoutOptions {
		return new AcfLayoutOptions( 'vertical' );
	}

	public static function HORIZONTAL(): AcfLayoutOptions {
		return new AcfLayoutOptions( 'horizontal' );
	}
}
