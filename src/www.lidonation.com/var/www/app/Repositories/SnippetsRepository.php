<?php

namespace App\Repositories;

use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class SnippetsRepository
{
    public function __construct(protected Fluent $snippets){}

    public function __get($name): mixed
    {
        return $this->snippets?->$name ?? Str::of($name)->snake()->replace('_', ' ')->ucfirst();
    }


}
