<?php

namespace PaymentCalculation;

class PaymentController
{
    private $yearPayments;

    public function __construct(YearPayments $yearPayments)
    {
        $this->yearPayments = $yearPayments;
    }

    public function getPayments(\DateTime $startDate = null)
    {
        return $this->yearPayments->getPayments($startDate);
    }
}
