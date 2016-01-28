<?php

namespace PaymentCalculation;

use Exporting\Exportable;

class YearPayments implements Exportable
{
    private $paymentFactory;
    private $startDate;

    public function __construct(PaymentFactory $paymentFactory)
    {
        $this->paymentFactory = $paymentFactory;
        $this->startDate = new \DateTime();
    }

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
