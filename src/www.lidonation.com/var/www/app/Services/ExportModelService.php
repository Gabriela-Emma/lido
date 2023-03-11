<?php

namespace App\Services;

// use App\Contracts\ExportModel;
use App\Contracts\ProvidesModelExportService;
use App\Services\Providers\ExportModelProvider;
use Illuminate\Support\Facades\App;

class ExportModelService
{
    public function __construct()
    {
    }

    /**
     * Export model 
     *
     * @param $exportClass - export class object
     * @param $exportFileName - naming of the generated file in any format eg 'proposal.csv' or 'proposal.xlsx'
     */
    public function exportExcel($exportObj, string $exportFileName) 
    { 
        
        $exportName = $exportFileName . '.xlsx';
        return (new ExportModelProvider($exportObj))->export($exportName); 
    }

    public function exportCsv($exportObj, string $exportFileName) 
    { 
        $exportName = $exportFileName . '.csv';
        return (new ExportModelProvider($exportObj))->export($exportName);  
    }
}

