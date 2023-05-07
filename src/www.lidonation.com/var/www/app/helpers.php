<?php

function localizeRoute($routeName, $locale = null, $parameters = []): bool|string
{
    if (! $locale && Auth::user()) {
        $locale = Auth::user()->lang;
    }

    return $locale ? LaravelLocalization::getLocalizedURL($locale, route($routeName, $parameters)) : route($routeName, $parameters);
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

function has_preview_access(): bool
{
    $user = auth()?->user();

    return (bool) $user && ($user->hasAnyRole(['delegator', 'admin', 'super admin']) || $user->hasAnyPermission(['preview_access']));
}
