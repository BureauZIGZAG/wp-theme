<?php

namespace Freekattema\Wp\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigUtils extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('aos_*_*', [$this, 'aos']),
        ];
    }

    public function aos(string $type, string $value, mixed $options = null): string{
        $attrs = ["data-aos=\"$type-$value\""];
        if($options) {
            if(isset($options['duration'])) {
                $attrs[] = "data-aos-duration=\"{$options['duration']}\"";
            }
            if(isset($options['delay'])) {
                $attrs[] = "data-aos-delay=\"{$options['delay']}\"";
            }
            if(isset($options['offset'])) {
                $attrs[] = "data-aos-offset=\"{$options['offset']}\"";
            }
            if(isset($options['anchor'])) {
                $attrs[] = "data-aos-anchor-placement=\"{$options['anchor-placement']}\"";
            }
        }
        return implode(' ', $attrs);
    }

}
