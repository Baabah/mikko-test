<?php

namespace Payroll;

/**
 * This class tests the MonthPayment class for happy and unhappy paths
 * Class MonthPaymentsTest
 */
class MonthPaymentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test scenario where both salary and bonus are calculated normally
     */
    public function testSalaryAndBonus()
    {
        $expected = [
            'monthName' => 'January',
            'bonusDate' => '15-01-2016',
            'salaryDate' => '29-01-2016'
        ];
        $dateTime = new \DateTime('01-01-2016');
        $monthPayment = new MonthPayments($dateTime);
        $result = $monthPayment->getExportArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Test scenario where only salary will be paid
     */
    public function testSalaryOnly()
    {
        $expected = [
            'monthName' => 'January',
            'bonusDate' => '-',
            'salaryDate' => '29-01-2016'
        ];
        $dateTime = new \DateTime('28-01-2016');
        $monthPayment = new MonthPayments($dateTime);
        $result = $monthPayment->getExportArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Test scenario where neither salary nor bonus will be paid
     */
    public function testNeither()
    {
        $expected = [
            'monthName' => 'January',
            'bonusDate' => '-',
            'salaryDate' => '-'
        ];
        $dateTime = new \DateTime('31-01-2016');
        $monthPayment = new MonthPayments($dateTime);
        $result = $monthPayment->getExportArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Test scenario where bonus payment will be delayed
     */
    public function testDelayedBonus()
    {
        $expected = [
            'monthName' => 'May',
            'bonusDate' => '18-05-2016',
            'salaryDate' => '31-05-2016'
        ];
        $dateTime = new \DateTime('01-05-2016');
        $monthPayment = new MonthPayments($dateTime);
        $result = $monthPayment->getExportArray();
        $this->assertEquals($result, $expected);
    }

    /**
     * Test scenario where bonus should still be paid, even though it nearing the next day
     */
    public function testBonusEdge()
    {
        $expected = [
            'monthName' => 'January',
            'bonusDate' => '15-01-2016',
            'salaryDate' => '29-01-2016'
        ];
        $dateTime = new \DateTime('15-01-2016 23:59');
        $monthPayment = new MonthPayments($dateTime);
        $result = $monthPayment->getExportArray();
        $this->assertEquals($result, $expected);
    }
}
