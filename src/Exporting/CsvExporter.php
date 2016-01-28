<?php

namespace Exporting;

class CsvExporter implements Exporter
{
    private $path;

    public function __construct($filename, $root)
    {
        // Set output path
        $this->path = $this->createPath($filename, $root);
    }

    public function export(Exportable $exportable)
    {
        // Retrieve data which will be exported
        $exportRows = $exportable->getExportArray();

        // Create csv file (or empty if already exists)
        $csvFile = fopen($this->path, 'w');

        // File couldn't be opened
        if ($csvFile === false) {
            return false;
        }

        // Write headings to file
        $headings = ['Month', 'Bonus date', 'Salary date'];
        fputcsv($csvFile, $headings, ';');

        // Write each row to file
        foreach ($exportRows as $exportRow) {
            fputcsv($csvFile, $exportRow, ';');
        }

        // Close stream
        return fclose($csvFile);
    }

    private function createPath($filename, $root)
    {

        // Add csv extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext !== 'csv') {
            $filename .= '.csv';
        }
        // Set output folder
        $outputDir = $root . 'output/';

        // Return output path
        return $outputDir . $filename;
    }
}
