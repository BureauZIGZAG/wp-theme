<?php

namespace Freekattema\Wp\Acf\FieldTypes;

final class AcfWysiwyg extends AcfFieldType {

    function get_additional(): array
    {
        return [];
    }

    function get_type(): string
    {
        return 'wysiwyg';
    }
}