<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;

class AcfOembedField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'width'  => 0,
			'height' => 0,
		] );
	}

	public function embed_width( int $width ): AcfOembedField {
		return $this->set_option( 'width', $width );
	}

	public function embed_height( int $height ): AcfOembedField {
		return $this->set_option( 'height', $height );
	}

	function get_type(): string {
		return 'oembed';
	}
}
