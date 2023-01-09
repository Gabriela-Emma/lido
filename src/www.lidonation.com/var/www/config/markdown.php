<?php

use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;

return [
    'code_highlighting' => [
        /*
         * To highlight code, we'll use Shiki under the hood. Make sure it's installed.
         *
         * More info: https://spatie.be/docs/laravel-markdown/v1/installation-setup
         */
        'enabled' => true,

        /*
         * The name of or path to a Shiki theme
         *
         * More info: https://github.com/shikijs/shiki/blob/master/docs/themes.md
         */
        'theme' => 'material-darker',
    ],

    /*
     * When enabled, anchor links will be added to all titles
     */
    'add_anchors_to_headings' => true,

    /*
     * These options will be passed to the league/commonmark package which is
     * used under the hood to render markdown.
     *
     * More info: https://spatie.be/docs/laravel-markdown/v1/using-the-blade-component/passing-options-to-commonmark
     */
    'commonmark_options' => [
        'html_input' => 'strip',
        'allow_unsafe_links' => true,
        'renderer' => [
            'block_separator' => "\n",
            'inner_separator' => "\n",
            'soft_break' => "\n",
        ],
        'external_link' => [
            'internal_hosts' => [config('app.url'), 'lidonation.com', 'www.lidonation.com', 'test.lidonation.com'],
            'open_in_new_window' => true,
            'html_class' => 'external-link',
        ],
        'commonmark' => [
            'enable_em' => true,
            'enable_strong' => true,
            'use_asterisk' => true,
            'use_underscore' => true,
            'unordered_list_markers' => ['-', '*', '+'],
        ],
    ],

    /*
     * Rendering markdown to HTML can be resource intensive. By default
     * we'll cache the results.
     *
     * You can specify the name of a cache store here. When set to `null`
     * the default cache store will be used. If you do not want to use
     * caching set this value to `false`.
     */
    'cache_store' => false,

    /*
     * This class will convert markdown to HTML
     *
     * You can change this to a class of your own to greatly
     * customize the rendering process
     *
     * More info: https://spatie.be/docs/laravel-markdown/v1/advanced-usage/customizing-the-rendering-process
     */
    'renderer_class' => Spatie\LaravelMarkdown\MarkdownRenderer::class,

    /*
     * These extensions should be added to the markdown environment. A valid
     * extension implements League\CommonMark\Extension\ExtensionInterface
     *
     * More info: https://commonmark.thephpleague.com/2.1/extensions/overview/
     */
    'extensions' => [
        //        League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
        League\CommonMark\Extension\Table\TableExtension::class,
        League\CommonMark\Extension\ExternalLink\ExternalLinkExtension::class,
        GithubFlavoredMarkdownExtension::class,
        AttributesExtension::class,
        SmartPunctExtension::class,
        FootnoteExtension::class,
        MentionExtension::class,
    ],

    /*
     * These block renderers should be added to the markdown environment. A valid
     * renderer implements League\CommonMark\Renderer\NodeRendererInterface;
     *
     * More info: https://commonmark.thephpleague.com/2.1/customization/rendering/
     */
    'block_renderers' => [
        // ['class' => FencedCode::class, 'renderer' => new MyCustomCodeRenderer(), 'priority' => 0]
    ],

    /*
     * These inline renderers should be added to the markdown environment. A valid
     * renderer implements League\CommonMark\Renderer\NodeRendererInterface;
     *
     * More info: https://commonmark.thephpleague.com/2.1/customization/rendering/
     */
    'inline_renderers' => [
        // ['class' => FencedCode::class, 'renderer' => new MyCustomCodeRenderer(), 'priority' => 0]
    ],

    /*
     * These inline parsers should be added to the markdown environment. A valid
     * parser implements League\CommonMark\Renderer\InlineParserInterface;
     *
     * More info: https://commonmark.thephpleague.com/2.3/customization/inline-parsing/
     */
    'inline_parsers' => [
        // ['parser' => new MyCustomInlineParser(), 'priority' => 0]
    ],

    'external_link' => [
        'internal_hosts' => [config('app.url'), 'lidonation.com', 'www.lidonation.com', 'test.lidonation.com'],
        'open_in_new_window' => true,
        'html_class' => 'external-link',
    ],
];
