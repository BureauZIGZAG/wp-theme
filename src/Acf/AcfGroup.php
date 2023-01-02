<?php

namespace Freekattema\Wp\Acf;

use Freekattema\Wp\Acf\FieldTypes\AcfFieldType;
use Freekattema\Wp\Shared\Traits\AddAction;

class AcfGroup {
	use AddAction;

	/** @var string */
	private $key;
	/** @var string */
	private $title;
	/** @var AcfFieldType[] */
	private $fields = [];
	/** @var AcfLocation[]|AcfLocation[][] */
	private $location = [];

	/** @var int */
	private $menu_order = 0;
	/** @var string */
	private $position = 'normal';
	/** @var string */
	private $style = 'default';
	/** @var string */
	private $label_placement = 'top';
	/** @var string */
	private $instruction_placement = 'label';
	/** @var string */
	private $hide_on_screen = '';

	/**
	 * @param string $key
	 * @param string $title
	 * @param AcfFieldType $fields
	 * @param AcfLocation $location
	 */
	private function __construct(string $key, string $title, $fields = [], $location = []) {
		$this->key = $key;
		$this->title = $title;
		$this->fields = $fields;
		$this->location = $this->remove_null_values($location);

		$this->add_action('acf/init', 'register');
	}

	private function register() {
		$content = [
			'key' => $this->get_key(),
			'title' => $this->title,
			'fields' => $this->get_fields(),
			'location' => $this->get_locations(),
			'menu_order' => $this->menu_order,
			'position' => $this->position,
			'style' => $this->style,
			'label_placement' => $this->label_placement,
			'instruction_placement' => $this->instruction_placement,
			'hide_on_screen' => $this->hide_on_screen,
		];

		acf_add_local_field_group($content);
	}

	private function get_key(): string
	{
		// get key and make it lowercase
		$key = strtolower($this->key);

		// remove all non-alphanumeric characters
		$key = preg_replace('/[^a-z0-9]/', '', $key);

		$random_key = substr(md5($key), 0, 6);

		return 'zigzag_group_' . $random_key;
	}

	private function get_locations($locations = null):array {
		$output = [];

		$locations = $locations ?? $this->location;
		foreach($locations as $location) {
			if(is_array($location)) {
				$output[] = $this->get_locations($location);
			} else {
				$output[] = $location->to_array();
			}
		}

		return $output;
	}

	private function get_fields():array {
		return array_map(function($field) {
			return $field->to_array();
		}, $this->fields);
	}

	/**
	 * @param string $title
	 * @param array $fields
	 * @param AcfLocation[]|AcfLocation|AcfLocation[][] $location
	 * @return AcfGroup
	 */
	public static function create(string $title, array $fields = [], $location = []): AcfGroup {
		if(!is_array($location)) {
			$location = [[$location]];
		}

		return new static(self::generate_key($title), $title, $fields, $location);
	}

	private static function generate_key(string $title) {
		$option_name = 'zigzag_acf_group_key_' . $title;
		$key = get_option($option_name, false);
		if(!$key) {
			update_option($option_name, uniqid('auto_group_'));
			return self::generate_key($title);
		}
		return $key;
	}

	public function add_location(?AcfLocation $location): self
	{
		if($location !== null) {
			$this->location[] = [[$location]];
		}
		return $this;
	}

	/**
	 * @param AcfLocation[]|AcfLocation[][] $locations
	 *
	 * @return $this
	 */
	public function add_locations( array $locations): self
	{
		$locations = array_filter($locations, function($location) {
			return $location !== null;
		});

		$this->location = array_merge($this->location, $locations);
		return $this;
	}

	public function add_field(AcfFieldType $field): self
	{
		$this->fields[] = $field;
		return $this;
	}

	public function add_fields(array $fields): self
	{
		foreach($fields as $field) {
			$this->add_field($field);
		}
		return $this;
	}

	private function remove_null_values(array $array): array {
		return array_filter($array, function($value) {
			return $value !== null;
		});
	}
}
