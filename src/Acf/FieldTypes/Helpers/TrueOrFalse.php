<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

final class TrueOrFalse extends AcfFieldOptionsBaseClass {
	public static function TRUE(): self {
		return new self(true);
	}

	public static function FALSE(): self {
		return new self(false);
	}
}
