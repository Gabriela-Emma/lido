<?php

namespace App\Services\Providers;

use App\Contracts\ProvidesModelExportService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\App;
// use App\Contracts\ProvidesModelExportService

class ExportModelProvider implements ProvidesModelExportService
{
    public function __construct(protected $exportObj)
    {

    }

    /**
     * Export model 
     *
     * @param $exportClass - relative class name to the exports directory i.e App\Exports
     * @param $exportFileName - naming of the generated file in any format
     */
    public function export(string $exportFileName) 
    {
        return Excel::download($this->exportObj, $exportFileName);
    }
} 