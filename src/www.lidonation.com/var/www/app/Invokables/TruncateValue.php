<?php

namespace App\Invokables;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TruncateValue
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke($value): ?string
    {
        if ((bool) $value && $this->request->isResourceIndexRequest()) {
            return Str::truncate($value, 16);
        }

        return $value;
    }
}
