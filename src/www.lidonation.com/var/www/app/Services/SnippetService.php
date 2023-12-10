<?php

namespace App\Services;

use App\Models\Snippet;
use Illuminate\Support\Str;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\QueryException;

class SnippetService
{
    public function getSnippets(): Fluent
    {
        try {

            $snippets = Cache::remember('snippets', now()->addHours(12), function () {
                return Snippet::all(['name', 'content'])->map(function ($snippet) {
                    return [
                        Str::replace([',', '“', '.'], '', Str::camel($snippet->name)) => $snippet->content,
                    ];
                });
            });


            return new Fluent($snippets->collapse());
        } catch (QueryException $e) {
            report($e);
        }

        return new Fluent([]);
    }
}
