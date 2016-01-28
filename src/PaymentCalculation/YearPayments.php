<?php

namespace PaymentCalculation;

class YearPayments
{
    private $paymentFactory;

    public function __construct(PaymentFactory $paymentFactory)
    {
        $this->paymentFactory = $paymentFactory;
    }

    public function getPayments(\DateTime $startDate = null)
    {
        if (is_null($startDate)) {
            $startDate = new \DateTime();
        }
        $monthDates = $this->getRemainingMonths($startDate);
        return $this->paymentFactory->createPayments($monthDates);
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
