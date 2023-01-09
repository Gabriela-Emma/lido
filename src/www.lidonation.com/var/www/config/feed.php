<?php

$languages = ['en-US' => 'English', 'fr-FR' => 'Français', 'sw-KE' => 'Kiswahili', 'es-ES' => 'Español'];
$items = [
    'news' => [],
    'review' => [],
    'insight' => [],
];

$feeds = collect($items)->map(function ($item, $key) use ($languages) {
    return collect($languages)->map(function ($nativeName, $lang) use ($key) {
        $model = ucfirst($key);
        $feed = \Illuminate\Support\Str::camel("$key-$lang");

        return [$feed => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => ['App\Models\\'.$model, 'getFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => \Illuminate\Support\Str::slug(\Illuminate\Support\Str::plural($key)."-$lang"),

            'title' => "LIDO Nation $nativeName",

            'description' => 'LIDO Nation News RSS feed.',

            'language' => $lang,

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::atom',

            /*
             * The type to be used in the <link> tag
             */
            'type' => 'application/atom+xml',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'atom',
        ]];
    });
})->collapse()->collapse()->toArray();

return [
    'feeds' => $feeds,
];
