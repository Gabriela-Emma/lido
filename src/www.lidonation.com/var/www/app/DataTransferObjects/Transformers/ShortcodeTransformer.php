<?php

namespace App\DataTransferObjects\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;
use Webwizo\Shortcodes\Facades\Shortcode;

class ShortcodeTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): string
    {
        return Shortcode::compile($value);
    }
}
