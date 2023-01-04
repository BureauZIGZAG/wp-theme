<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class FileReturnFormat extends AcfFieldOptionsBaseClass {
	public static function ARRAY(): self {
		return new self('array');
	}

	public static function URL(): self {
		return new self('url');
	}

	public static function ID(): self {
		return new self('id');
	}
}
