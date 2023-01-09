<?php

namespace App\Shortcodes;

use App\Exceptions\InvalidArgumentException;
use App\Models\Interfaces\HasLink;
use App\Models\Post;

class TweetLinkShortcode
{
    // public function register($shortcode, $content, $compiler, $name, $viewData)
    // {

    //     $post = Post::find($shortcode->post_id);
    //     $text = isset($shortcode->tweet) ? $shortcode->tweet : $content;
    //     $hashTags = $shortcode->hashtags;

    //     // // return sprintf('<a href="%s" class="squiggle">%s</a>', $twitterSvgUrl, $content);
    //     return view('shortcodes.tweet-share', compact('post', 'text', 'hashTags', 'content'));
    // }

    public function register($shortcode, $content, $compiler, $name, $viewData): string
    {
        $text = ! is_null($shortcode->tweet) ? $shortcode->tweet : $content;
        $hashTags = $shortcode->hashtags;

        $linkObject = null;
        if (! is_null($shortcode->object_type) && ! is_null($shortcode->id)) {
            $obj = '\App\Models\\'.ucfirst($shortcode->object_type);
            $linkObject = $obj::find($shortcode->id);
        } elseif ((bool) $shortcode?->post_id) {
            $linkObject = Post::find($shortcode->post_id);
        }

        // i
        if ($linkObject instanceof HasLink) {
            $link = $linkObject->link;
        } else {
            report(new InvalidArgumentException('Link Object must implement HasLink.'));
        }

        return isset($link) ? view('shortcodes.tweet-share', compact('link', 'text', 'hashTags', 'content')) : $content;
    }
}
