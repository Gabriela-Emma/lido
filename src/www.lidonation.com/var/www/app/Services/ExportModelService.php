<?php

namespace App\Services;

use App\Services\Providers\ExportModelProvider;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportModelService
{
    /**
     * Export model
     *
     * @param  string  $exportFileName - naming of the generated file in any format eg 'proposal.csv' or 'proposal.xlsx'
     *
     * @throws Exception
     */
    public function exportExcel($exportObj, string $exportFileName): BinaryFileResponse
    {
        $exportName = $exportFileName.'.xlsx';

        return (new ExportModelProvider($exportObj))->export($exportName);
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export($exportObj, string $exportFileName): BinaryFileResponse
    {
        return (new ExportModelProvider($exportObj))->export($exportFileName);
    }
}
