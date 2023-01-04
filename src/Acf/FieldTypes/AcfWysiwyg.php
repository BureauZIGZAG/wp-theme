<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\TrueOrFalse;

final class AcfWysiwyg extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'toolbar'      => 'full',
			'media_upload' => 1,
			'tabs'         => 'all',
		] );
	}

	/**
	 * @param TrueOrFalse $media_upload
	 *
	 * @return AcfWysiwyg
	 */
	public function media_upload( TrueOrFalse $media_upload ): AcfWysiwyg {
		return $this->set_option( 'media_upload', $media_upload->get() ? 1 : 0 );
	}

	function get_type(): string {
		return 'wysiwyg';
	}
}
