<?php

namespace Payroll;

use Exporting\Exportable;

/**
 * This class represents salary and bonus payments which should be made for the current year
 * Class YearPayments
 */
class YearPayments implements Exportable
{
    /**
     * @var PaymentFactory
     */
    private $paymentFactory;
    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * The constructor sets the $startDate variable to the current date
     * @param PaymentFactory $paymentFactory
     */
    public function __construct(PaymentFactory $paymentFactory)
    {
        $this->paymentFactory = $paymentFactory;
    }

    /**
     * This method exports an array as specified by the Exportable interface
     * This array will be used by Exporter objects as data
     * @return array
     */
    public function getExportArray()
    {
        $monthDates = $this->getRemainingMonths($this->startDate);
        $payments = $this->paymentFactory->createPayments($monthDates);
        $exportArray = [];
        foreach ($payments as $payment) {
            $exportArray[] = $payment->getExportArray();
        }
        return $exportArray;
    }

    /**
     * This method retrieves DateTime objects for all months between the current date and the end of the year
     * @return array
     */
    private function getRemainingMonths()
    {
        $startDate = new \DateTime('midnight');
        $endDate = new \DateTime('first day of next year midnight');
        $interval = new \DateInterval('P1M');
        $periodStartDate = new \DateTime('first day of next month midnight');
        $period = new \DatePeriod($periodStartDate, $interval, $endDate);

        // Add current date as first element
        $dateArray = [$startDate];

        // Added every first day of the upcoming months
        foreach ($period as $dateTime) {
            $dateArray[] = $dateTime;
        }
        return $dateArray;
    }
}
