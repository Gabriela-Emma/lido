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
            $encoding = mb_detect_encoding($value);
            if ( $encoding === 'UTF-8') {
                return $value;
                // $value =  mb_convert_encoding($value,  'UTF-8', 'auto');
            }
            return Str::truncate($value, 16);
        }

        return $value;
    }
}
