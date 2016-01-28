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
        $this->startDate = new \DateTime();
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
     * @param \DateTime $startDate
     * @return array
     */
    private function getRemainingMonths(\DateTime $startDate)
    {
        // TODO check for correct time (to prevent comparison breaking)
        $endDate = new \DateTime('first day of next year');
        $interval = new \DateInterval('P1M');

        // TODO change to explicit prevention of first month payment
        $periodStartDate = new \DateTime('first day of next month');
        $period = new \DatePeriod($periodStartDate, $interval, $endDate);
        $dateArray = [$startDate];
        foreach ($period as $dateTime) {
            $dateArray[] = $dateTime;
        }
        return $dateArray;
    }
}
