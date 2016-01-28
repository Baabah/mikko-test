<?php

namespace PaymentCalculation;

use Exporting\Exportable;

/**
 * This class represents all payments for one single month, these can be exported via the Exportable interface
 * Class MonthPayments
 */
class MonthPayments implements Exportable
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * Constructs the MonthPayments object and sets the dateTime object
     * @param \DateTime $dateTime
     */
    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * This method is implemented to match the Exportable interface, which is used by Exporter objects to retrieve data
     * @return array
     */
    public function getExportArray()
    {
        $salaryDate = $this->getFormattedDate($this->getSalaryDate());
        $bonusDate = $this->getFormattedDate($this->getBonusDate());
        return [
            'monthName' => $this->dateTime->format('F'),
            'bonusDate' => $bonusDate,
            'salaryDate' => $salaryDate
        ];
    }

    /**
     * Retrieve the date on which bonuses should be paid for this specific month
     * Will return null if no bonuses should be paid
     * @return \DateTime|null
     */
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

    /**
     * Retrieve the date on which salaries should be paid for this specific month
     * Will return null if no salaries should be paid
     * @return \DateTime|null
     */
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

    /**
     * Checks wether a day is in the weekend or not
     * @param \DateTime $dateTime
     * @return bool
     */
    private function isWeekend(\DateTime $dateTime)
    {
        $dayOfWeek = $dateTime->format('N');
        if ($dayOfWeek === '6' || $dayOfWeek === '7') {
            return true;
        }
        return false;
    }

    /**
     * Formats a datetime to a readable string specifying day-month-year (eg. 01-02-2016)
     * @param $dateTime
     * @return string
     */
    private function getFormattedDate($dateTime)
    {
        if (is_null($dateTime)) {
            return '-';
        }
        return $dateTime->format('d-m-Y');
    }
}
