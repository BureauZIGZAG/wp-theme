<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;
use Freekattema\Wp\Acf\FieldTypes\Helpers\FileReturnFormat;

class AcfFileField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'return_format' => FileReturnFormat::ARRAY()->get(),
		] );
	}

	public function return_format( FileReturnFormat $return_format ): AcfFileField {
		return $this->set_option( 'return_format', $return_format->get() );
	}

	public function min_size( int $min_size ): AcfFileField {
		return $this->set_option( 'min_size', $min_size );
	}

	public function max_size( int $max_size ): AcfFileField {
		return $this->set_option( 'max_size', $max_size );
	}

	public function mime_types( array $mime_types ): AcfFileField {
		$mime_types = implode( ',', $mime_types );

		return $this->set_option( 'mime_types', $mime_types );
	}

	function get_type(): string {
		return 'file';
	}
}
