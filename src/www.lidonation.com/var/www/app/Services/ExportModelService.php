<?php

namespace App\Services;

// use App\Contracts\ExportModel;
use App\Contracts\ProvidesModelExportService;

class ExportModelService
{
    public function __construct(protected ProvidesModelExportService $exportModel)
    {
    }

    /**
     * Export model 
     *
     * @param $exportClass - relative class name to the exports directory i.e App\Exports
     * @param $exportFileName - naming of the generated file in any format
     */
    public function export(string $exportClass, string $exportFileName) 
    { 
        return $this->exportModel->export($exportClass, $exportFileName); 
    }
}

