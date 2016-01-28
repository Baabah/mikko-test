<?php

namespace PaymentCalculation;

class PaymentFactory
{
    public function createPayments(array $dateTimes)
    {
        $payments = [];
        foreach ($dateTimes as $dateTime) {
            $payments[] = new MonthPayments($dateTime);
        }
        return $payments;
    }
}
