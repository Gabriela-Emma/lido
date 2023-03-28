<?php

namespace App\Contracts;

interface ProvidesModelExportService
{
    /**
     * Export model
     *
     * @param $exportClass - relative class name to the exports directory i.e App\Exports
     * @param $exportFileName - naming of the generated file in any format
     */
    public function export(string $exportFileName);
}
