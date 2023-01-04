<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class AcfGroupLabelPlacement extends AcfFieldOptionsBaseClass {
	public static function TOP(): AcfGroupLabelPlacement {
		return new self( 'top' );
	}

	public static function LEFT(): AcfGroupLabelPlacement {
		return new self( 'left' );
	}
}
