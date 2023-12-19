<?php

namespace Freekattema\Wp\Shared;

class Image
{
    public $url;
    public $alt;
    public $attachment_id;

    private $attributes = [];

    public function __construct($url, $alt, $id = null)
    {
        $this->url = $url;
        $this->alt = $alt;
    }

    public function render(string $classes = '', bool $lazy = true, $attributes = [])
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        echo $this->get_html($classes, $lazy);
    }

    public function get_html(string $classes = '', bool $lazy = true, $attributes = []): string
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->set_attribute('class', $classes);
        $this->set_attribute('alt', $this->alt);
        $this->set_attribute('srcset', $this->getSrcSet());
        return "<img {$this->get_attributes()} />";
    }

    public function getSrcSet()
    {
        if (!$this->attachment_id) {
            // try to find attachment id
            $in_uploads = strpos($this->url, '/wp-content/uploads/');

            if ($in_uploads) {
                $id = attachment_url_to_postid($this->url);
                if ($id) {
                    $this->attachment_id = $id;
                }
            }

            if (!$this->attachment_id) {
                // return normal src
                return $this->url;
            }
        }

        return wp_get_attachment_image_srcset($this->attachment_id, size: [
            'thumbnail',
            'medium',
            'large',
            'full',
        ]) ?: $this->url;
    }

    public function set_attribute(string $key, string $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    private function get_attributes(): string
    {
        $attributes = '';

        foreach ($this->attributes as $key => $value) {
            $value = is_array($value) ? implode(' ', $value) : $value;
            $attributes .= " $key=\"$value\"";
        }

        return $attributes;
    }
}
