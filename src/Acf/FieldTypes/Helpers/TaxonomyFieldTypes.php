<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

final class TaxonomyFieldTypes extends AcfFieldOptionsBaseClass {
	public static function CHECKBOX(): self {
		return new self('checkbox');
	}

	public static function MULTI_SELECT(): self {
		return new self('multi_select');
	}

	public static function RADIO(): self {
		return new self('radio');
	}

	public static function SELECT(): self {
		return new self('select');
	}
}
