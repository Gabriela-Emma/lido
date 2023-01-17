<?php

namespace App\Shortcodes;

use App\Models\Interfaces\HasLink;
use App\Models\Link;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class LinkShortcode
{
    public function register($shortcode, $content, $compiler, $name, $viewData): string
    {
        $linkObject = null;
        if (! is_null($shortcode->model_type) && ! is_null($shortcode->id)) {
            $obj = '\App\Models\\'.ucfirst($shortcode->model_type);

            if (class_exists($obj)) {
                $linkObject = $obj::find($shortcode->id);

                if (! $linkObject instanceof HasLink && ! $linkObject instanceof Link) {
                    Log::error("$linkObject must implement HasLink.");
                }
            }
        } else {
            // @deprecated do not use or extend
            if (is_null($shortcode->link_id)) {
                $linkObject = Post::find($shortcode->post_id);
            } else {
                $linkObject = Link::find($shortcode->link_id);
            }
        }
        if (is_null($linkObject?->link)) {
            return $content;
        }

        return sprintf('<a target="_blank" href="%s" title="%s">%s</a>',
            $linkObject->link,
            $linkObject?->title,
            ! empty($content) ? $content : $linkObject?->title
        );
    }
}
