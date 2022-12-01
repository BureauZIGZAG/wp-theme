<?php

namespace Freekattema\Wp\Acf\FieldTypes;

final class AcfLink extends AcfFieldType
{
    function get_additional(): array
    {
        return [
            'return_format' => 'array',
        ];
    }

    function get_type(): string
    {
        return 'link';
    }
}