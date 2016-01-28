<?php

namespace Exporting;

/**
 * This class tests the CsvExporter
 * Class CsvExporterTest
 */
class CsvExporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $projectRoot;

    /**
     * @var string
     */
    private $path;
    /**
     * @var CsvExporter
     */
    private $csvExporter;
    /**
     * @var
     */
    private $paymentMock;

    /**
     * SetUp tests by creating a mock YearPayments object and instantiating a CsvExporter based on filename and root
     */
    public function setUp()
    {
        $this->filename = 'testfile';
        $this->projectRoot =  __DIR__ . '/../../';
        $this->path = $this->projectRoot . 'output/' . $this->filename . '.csv';
        $this->csvExporter = new CsvExporter($this->filename, $this->projectRoot);
        $this->paymentMock = $this->getMockBuilder('Payroll\YearPayments')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Delete testfile.csv when done testing
     */
    public function tearDown()
    {
        unlink($this->path);
    }

    /**
     * Export to .csv with data
     */
    public function testGoodExport()
    {
        $data = [[
            'monthName' => 'January',
            'bonusDate' => '-',
            'salaryDate' => '29-01-2016'
        ]];
        $expectedHeadings = [
            'Month',
            'Bonus date',
            'Salary date'
        ];
        $expectedFirstLine = [
            $data[0]['monthName'],
            $data[0]['bonusDate'],
            $data[0]['salaryDate']
        ];

        // Mock getExportArray method to return $data
        $this->paymentMock->expects($this->any())
            ->method('getExportArray')
            ->will($this->returnValue($data));

        // Check for errors when exporting
        $this->assertTrue($this->csvExporter->export($this->paymentMock));

        // Check if file is created
        $this->assertFileExists($this->path);

        // Check if file contents are correct
        $csvFile = fopen($this->path, 'r');
        $headings = fgetcsv($csvFile, null, ';');
        $this->assertEquals($headings, $expectedHeadings);
        $firstLine = fgetcsv($csvFile, null, ';');
        $this->assertEquals($firstLine, $expectedFirstLine);
    }

    /**
     * Export to .csv without data
     */
    public function testBadExport()
    {
        $data = [];
        $expectedHeadings = [
            'Month',
            'Bonus date',
            'Salary date'
        ];

        // Mock getExportArray method to return $data
        $this->paymentMock->expects($this->any())
            ->method('getExportArray')
            ->will($this->returnValue($data));

        // Check for errors when exporting
        $this->assertTrue($this->csvExporter->export($this->paymentMock));

        // Check if file is created
        $this->assertFileExists($this->path);

        // Check if file contents are correct
        $csvFile = fopen($this->path, 'r');
        $headings = fgetcsv($csvFile, null, ';');
        $this->assertEquals($headings, $expectedHeadings);
        $firstLine = fgetcsv($csvFile, null, ';');
        $this->assertFalse($firstLine);
    }
}
