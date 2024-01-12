<?php

namespace Freekattema\Wp\Shared;

class Link {
    private $attributes = [];
    public string $title;

    public function __construct($url, $target, $title)
    {
        $this->set_attribute('href', $url);
        $this->set_attribute('target', $target);
        $this->title = $title;
    }

    public function set_attribute($key, $value)
    {
        $blacklist = ['href', 'target'];
        $in_blacklist = in_array($key, $blacklist);
        if($in_blacklist) {
            $is_already_set = array_key_exists($key, $this->attributes);
            if($is_already_set) {
                return $this;
            }
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string|array $attributes
     * @return void
     */
    public function render($attributes=[]): void
    {
        // echo the generated html
        echo $this->get_html($attributes);
    }

    public function get_html($attributes=[]): string
    {
        // parse the attributes
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->set_attribute($key, $value);
            }
        } else {
            $this->set_attribute('class', $attributes);
        }

        // build attribute html
        $attributesStrings = [];
        foreach ($this->attributes as $key => $value) {
            $attributesStrings[] = "$key=\"$value\"";
        }
        $attributesString = implode(' ', $attributesStrings);

        // return html
        return "<a $attributesString>$this->title</a>";
    }

    public function __get($name)
    {
        if($name === 'url') {
            return $this->attributes['href'];
        }
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }


}
