<?php

namespace App\Services\Providers;

use App\Contracts\ProvidesModelExportService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\App;

class ExportModelProvider implements ProvidesModelExportService
{
    public function __construct()
    {
        
    }

    protected function getFullClassName(string $relativeName)
    {   
        $classRoot = 'App\Exports'; 
        $absoluteClassName = $classRoot.'\\'.$relativeName;
        return App::make($absoluteClassName);
    }

    /**
     * Export model 
     *
     * @param $exportClass - relative class name to the exports directory i.e App\Exports
     * @param $exportFileName - naming of the generated file in any format
     */
    public function export(string $exportClass, string $exportFileName) 
    { 
        $exportClassName = $this->getFullClassName($exportClass);
        return Excel::download(new $exportClassName, $exportFileName);
    }
} 