<?php

namespace Freekattema\Wp\Shared;

class AcfGroupHelper
{
    /** @var array  */
    private $data = [];

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function construct(array $data): AcfGroupHelper
    {
        return new static($data);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }
}