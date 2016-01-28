<?php

namespace PaymentCalculation;

class PaymentFactory
{
    public function createPayments(array $monthDates)
    {
        $payments = [];
        foreach ($monthDates as $monthDate) {
            $payments[] = new MonthPayments($monthDate);
        }
        return $payments;
    }
}
