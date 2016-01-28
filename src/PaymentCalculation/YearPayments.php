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
        // TODO change to actual implementation
        return ['01-2015', '02-2015'];
    }
}
