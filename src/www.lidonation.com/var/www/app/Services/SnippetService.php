<?php

namespace App\Services;

use App\Models\Snippet;
use Illuminate\Database\QueryException;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class SnippetService
{
    public function getSnippets(): Fluent
    {
        try {
            $snippets = Snippet::all(['name', 'content'])->map(function ($snippet) {
                return [
                    Str::replace([',', '“', '.'], '', Str::camel($snippet->name)) => $snippet->content,
                ];
            });

            return new Fluent($snippets->collapse());
        } catch (QueryException $e) {
            report($e);
        }

        return new Fluent([]);
    }
}
