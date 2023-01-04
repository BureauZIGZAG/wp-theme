<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class ReturnFormatIdOrObject extends AcfFieldOptionsBaseClass {
	public static function ID(): self {
		return new self('id');
	}

	public static function OBJECT(): self {
		return new self('object');
	}
}
