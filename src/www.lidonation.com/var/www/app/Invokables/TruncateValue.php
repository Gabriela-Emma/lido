<?php
namespace App\Invokables;

use Illuminate\Support\Str;

class TruncateValue
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function __invoke($value)
    {
        if ((bool) $value && $this->request->isResourceIndexRequest()) {
            return Str::truncate($value, 16);
        }

        return $value;
    }
}
