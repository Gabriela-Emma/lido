<?php

namespace App\Shortcodes;

use App\Models\Definition;

class DefinitionShortcode
{
    public function register($shortcode, $content, $compiler, $name, $viewData): string
    {
        // definition shortcode valid arguments
        $id = $shortcode->definition;
        $word = $shortcode->word ?? $content;

        // query db for definition object if id is provided.
        $def = Definition::find($id)?->content ?? $shortcode->text;

        return isset($def) ? view('shortcodes.definition', compact('word', 'def')) : $word;
    }
}
