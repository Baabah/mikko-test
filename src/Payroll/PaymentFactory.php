<?php

namespace Payroll;

use Silex\Application;

/**
 * This class is used for creating MonthPayments objects
 * Class PaymentFactory
 */
class PaymentFactory
{
    /**
     * @var callable
     */
    private $closure;

    /**
     * Construct the factory by providing a closure, which can be called to create a MonthPayments object
     * @param callable $closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * Create a MonthPayments object for each DateTime element in the provided array
     * @param array $dateTimes
     * @return array
     */
    public function createPayments(array $dateTimes)
    {
        $payments = [];
        foreach ($dateTimes as $dateTime) {
            $closure = $this->closure;
            $payments[] = $closure($dateTime);
        }
        return $payments;
    }
}
