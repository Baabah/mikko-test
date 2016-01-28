<?php

namespace Payroll;

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
    private $currentDate;

    /**
     * Constructs the MonthPayments object and sets the dateTime object
     * @param \DateTime $currentDate
     */
    public function __construct(\DateTime $currentDate)
    {
        $this->currentDate = $currentDate;
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
            'monthName' => $this->currentDate->format('F'),
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
        $clone = clone $this->currentDate;
        $bonusDate = $clone->modify('first day of this month')->modify('+14 days');

        // Pay bonus on following wednesday for weekends
        if ($this->isWeekend($bonusDate)) {
            $bonusDate = date_modify($bonusDate, 'next wednesday');
        }

        // Return null if bonus has already been paid this month
        if ($this->currentDate > $bonusDate) {
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
        $clone = clone $this->currentDate;
        $lastDay = $clone->modify('last day of this month');

        // If last day of month is a weekend, pay the friday beforehand
        if ($this->isWeekend($lastDay)) {
            $lastDay = date_modify($lastDay, 'previous friday');
        }

        // Return null if salary has already been paid this month
        if ($this->currentDate > $lastDay) {
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
