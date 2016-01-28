<?php

namespace PaymentCalculation;

/**
 * This class is used for creating MonthPayments objects
 * Class PaymentFactory
 */
class PaymentFactory
{
    /**
     * Create a MonthPayments object for each DateTime element in the provided array
     * @param array $dateTimes
     * @return array
     */
    public function createPayments(array $dateTimes)
    {
        $payments = [];
        foreach ($dateTimes as $dateTime) {
            $payments[] = new MonthPayments($dateTime);
        }
        return $payments;
    }
}
