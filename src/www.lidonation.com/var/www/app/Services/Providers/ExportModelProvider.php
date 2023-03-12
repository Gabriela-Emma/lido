<?php

namespace App\Services\Providers;

use App\Contracts\ProvidesModelExportService;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportModelProvider implements ProvidesModelExportService
{
    public function __construct(protected $exportObj)
    {}

    /**
     * Export model
     *
     * @param string $exportFileName - naming of the generated file in any format
     * @return BinaryFileResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(string $exportFileName): BinaryFileResponse
    {
        return Excel::download($this->exportObj, $exportFileName);
    }
}
