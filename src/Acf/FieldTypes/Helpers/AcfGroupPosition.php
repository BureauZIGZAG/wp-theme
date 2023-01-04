<?php

namespace Freekattema\Wp\Acf\FieldTypes\Helpers;

class AcfGroupPosition extends AcfFieldOptionsBaseClass {
	public static function AFTER_TITLE(): AcfGroupPosition {
		return new self( 'acf_after_title' );
	}

	public static function NORMAL(): AcfGroupPosition {
		return new self( 'normal' );
	}

	public static function SIDE(): AcfGroupPosition {
		return new self( 'side' );
	}
}
