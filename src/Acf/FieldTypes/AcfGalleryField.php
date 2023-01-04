<?php

namespace Freekattema\Wp\Acf\FieldTypes;

use Freekattema\Wp\Acf\Traits\HasOptions;

final class AcfGalleryField extends AcfFieldType {
	use HasOptions;

	function get_additional(): array {
		return $this->merge_with_options( [
			'min'        => 0,
			'max'        => 0,
			'insert'     => 'append',
			'min_width'  => 0,
			'min_height' => 0,
			'min_size'   => 0,
			'max_width'  => 0,
			'max_height' => 0,
			'max_size'   => 0,
			'mime_types' => '',
		] );
	}

	public function min( int $min ): AcfGalleryField {
		return $this->set_option( 'min', $min );
	}

	public function max( int $max ): AcfGalleryField {
		return $this->set_option( 'max', $max );
	}

	public function insert( string $insert ): AcfGalleryField {
		return $this->set_option( 'insert', $insert );
	}

	public function min_width( int $min_width ): AcfGalleryField {
		return $this->set_option( 'min_width', $min_width );
	}

	public function min_height( int $min_height ): AcfGalleryField {
		return $this->set_option( 'min_height', $min_height );
	}

	public function min_size( int $min_size ): AcfGalleryField {
		return $this->set_option( 'min_size', $min_size );
	}

	public function max_width( int $max_width ): AcfGalleryField {
		return $this->set_option( 'max_width', $max_width );
	}

	public function max_height( int $max_height ): AcfGalleryField {
		return $this->set_option( 'max_height', $max_height );
	}

	public function max_size( int $max_size ): AcfGalleryField {
		return $this->set_option( 'max_size', $max_size );
	}

	public function mime_types( array $mime_types ): AcfGalleryField {
		$mime_types = implode( ',', $mime_types );

		return $this->set_option( 'mime_types', $mime_types );
	}

	function get_type(): string {
		return 'gallery';
	}
}
