<?php

function localizeRoute($routeName, $locale = null, $parameters = []): bool|string
{
    if (! $locale && Auth::user()) {
        $locale = Auth::user()->lang;
    }

    return $locale ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, route($routeName, $parameters, true)) : route($routeName, $parameters, true);
}

/**
 * Translate the given message.
 */
function ___(string $key = null, bool $oneLiner = true, array $replace = [], string $locale = null): array|string|null
{
    if (is_null($key)) {
        return $key;
    }

    $trans = trans($key, $replace, $locale);
    if (is_array($trans)) {
        return $trans;
    }
    //    $html = Markdow \GrahamCampbell\Markdown\Facades\Markdown::convert($trans);
    $html = app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($trans);

    if ($oneLiner) {
        $html = \Illuminate\Support\Str::remove(['<p>', '</p>'], $html);
    }

    return $html;
}

function previous_route_name(): string
{
    return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
}

function previous_route_url(): string
{
    $previousUrl = url()->previous();
    $currentUrl = url()->current();
    if ($previousUrl === $currentUrl) {
        return route('catalystExplorer.proposals');
    }

    return app('router')->getRoutes()
        ->match(
            app('request')->create(url()->previous())
        )->uri();
}

function previous_route_name_is(string $routeName): bool
{
    return previous_route_name() === $routeName;
}

function humanNumber($num, $precision = 1): string
{
    if ($num < 900) {
        // 0 - 900
        $n_format = number_format($num, $precision);
        $suffix = '';
    } elseif ($num < 900000) {
        // 0.9k-850k
        $n_format = number_format($num / 1000, $precision);
        $suffix = 'K';
    } elseif ($num < 900000000) {
        // 0.9m-850m
        $n_format = number_format($num / 1000000, $precision);
        $suffix = 'M';
    } elseif ($num < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($num / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($num / 1000000000000, $precision);
        $suffix = 'T';
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.'.str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format.$suffix;
}

function breakLongText($text, $length = 1000, $maxLength = 1100, $needle = '.'): array
{
    //Text length
    $textLength = strlen($text);

    //initialize empty array to store split text
    $splitText = [];

    //return without breaking if text is already short
    if (! ($textLength > $maxLength)) {
        $splitText[] = $text;

        return $splitText;
    }

    /*iterate over $text length
      as substr_replace deleting it*/
    while (strlen($text) > $length) {
        $end = strpos($text, $needle, $length);

        if ($end === false) {
            //Returns FALSE if the needle (in this case ".") was not found.
            $splitText[] = substr($text, 0);
            $text = '';
            break;
        }

        $end++;
        $splitText[] = substr($text, 0, $end);
        $text = substr_replace($text, '', 0, $end);
    }

    if ($text) {
        $splitText[] = substr($text, 0);
    }

    return $splitText;
}

/**
 * Removes characters from the middle of the string to ensure it is no more
 * than $maxLength characters long.
 *
 * Removed characters are replaced with "..."
 *
 * This method will give priority to the right-hand side of the string when
 * data is truncated.
 *
 * @return string
 */
function truncate_middle($string = '', $maxLength = 16): ?string
{
    // Early exit if no truncation necessary
    if (strlen($string) <= $maxLength) {
        return $string;
    }

    $numRightChars = ceil($maxLength / 2);
    $numLeftChars = floor($maxLength / 2) - 3; // to accommodate the "..."

    return sprintf('%s...%s', substr($string, 0, $numLeftChars), substr($string, 0 - $numRightChars));
}

function has_preview_access(): bool
{
    $user = auth()?->user();

    return (bool) $user && ($user->hasAnyRole(['delegator', 'admin', 'super admin']) || $user->hasAnyPermission(['preview_access']));
}
