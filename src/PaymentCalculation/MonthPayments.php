<?php

namespace PaymentCalculation;

class MonthPayments
{
    private $dateTime;

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    private function getBonusDate()
    {
        // Get 15th of month
        $clone = clone $this->dateTime;
        $bonusDate = $clone->modify('first day of this month')->modify('+14 days');

        // Pay bonus on following wednesday for weekends
        if ($this->isWeekend($bonusDate)) {
            $bonusDate = date_modify($bonusDate, 'next wednesday');
        }

        // Return null if bonus has already been paid this month
        if ($bonusDate < $this->dateTime) {
            return null;
        }

        return $bonusDate;
    }

    private function getSalaryDate()
    {
        // Get last day of month
        $clone = clone $this->dateTime;
        $lastDay = $clone->modify('last day of this month');

        // If last day of month is a weekend, pay the friday beforehand
        if ($this->isWeekend($lastDay)) {
            $lastDay = date_modify($lastDay, 'previous friday');
        }

        // Return null if salary has already been paid this month
        if ($lastDay < $this->dateTime) {
            return null;
        }

        return $lastDay;
    }

    private function isWeekend(\DateTime $dateTime)
    {
        $dayOfWeek = $dateTime->format('N');
        if ($dayOfWeek === '6' || $dayOfWeek === '7') {
            return true;
        }
        return false;
    }
}
