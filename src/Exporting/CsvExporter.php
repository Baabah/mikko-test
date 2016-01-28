<?php

namespace Exporting;

/**
 * This class exports Exportable objects to a csv file
 *
 * Class CsvExporter
 */
class CsvExporter implements Exporter
{
    /**
     * @var string
     */
    private $path;

    /**
     * The constructor creates and sets the output file path
     * @param $filename
     * @param $root
     */
    public function __construct($filename, $root)
    {
        // Set output path
        $this->path = $this->createPath($filename, $root);
    }

    /**
     * Export data retrieved from the exportable object to a csv file
     * @param Exportable $exportable
     * @return bool
     */
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

    /**
     * Create the output file path from a filename and the root dir
     * @param $filename
     * @param $root
     * @return string
     */
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
