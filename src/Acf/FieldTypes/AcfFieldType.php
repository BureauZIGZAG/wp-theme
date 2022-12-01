<?php

namespace Freekattema\Wp\Acf\FieldTypes;

abstract class AcfFieldType {
    /** @var string  */
    private $label;
    /** @var string  */
    private $name;
    /** @var int  */
    private $width = 100;

    private function __construct(string $label, string $name) {
        $this->label = $label;
        $this->name = $name;
    }

    public static function create(string $label, string $name)
    {
        return new static($label, strtolower($name));
    }

    public function to_array(): array
    {
        $DEFAULT = [
            'key' => $this->get_key(),
            'label' => $this->label,
            'name' => $this->name,
            'type' => $this->get_type(),
            'wrapper' => [
                'width' => $this->width,
            ]
        ];

        return array_merge($DEFAULT, $this->get_additional());
    }

    public function width(int $width): AcfFieldType
    {
        // cap between 0 and 100
        $width = max(0, min(100, $width));
        $this->width = $width;
        return $this;
    }

    public function get_key(): string
    {
        $name = strtolower($this->name);

        $random_key = substr(md5($name), 0, 6);

        return 'zigzag_field_' . $random_key;
    }

    abstract function get_additional(): array;
    abstract function get_type(): string;

    public function get_label()
    {
        return $this->label;
    }

    public function get_name()
    {
        return $this->name;
    }
}