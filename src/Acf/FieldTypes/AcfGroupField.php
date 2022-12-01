<?php

namespace Freekattema\Wp\Acf\FieldTypes;

final class AcfGroupField extends AcfFieldType {
    /** @var array  */
    private $fields;

    function get_additional(): array
    {
        return [
            'layout' => 'block',
            'sub_fields' => $this->get_fields(),
        ];
    }

    private function get_fields(): array
    {
        return array_map(function($field) {
            return $field->to_array();
        }, $this->fields);
    }

    function get_type(): string
    {
        return 'group';
    }

    public function add_field(AcfFieldType $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function add_fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->add_field($field);
        }
        return $this;
    }
}