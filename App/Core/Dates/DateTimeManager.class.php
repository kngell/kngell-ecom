<?php

declare(strict_types=1);

use DateTime;

class DateTimeManager
{
    public function monthList() : CollectionInterface
    {
        return new Collection([
            (object) ['value' => '01', 'month' => 'Januray'],
            (object) ['value' => '02', 'month' => 'February'],
            (object) ['value' => '03', 'month' => 'March'],
            (object) ['value' => '04', 'month' => 'April'],
            (object) ['value' => '05', 'month' => 'May'],
            (object) ['value' => '06', 'month' => 'June'],
            (object) ['value' => '07', 'month' => 'July'],
            (object) ['value' => '08', 'month' => 'August'],
            (object) ['value' => '09', 'month' => 'September'],
            (object) ['value' => '10', 'month' => 'October'],
            (object) ['value' => '11', 'month' => 'November'],
            (object) ['value' => '12', 'month' => 'December'],
        ]);
    }

    public function yearList() : CollectionInterface
    {
        return new Collection([
            (object) ['value' => '2022', 'year' => '2022'],
            (object) ['value' => '2023', 'year' => '2023'],
            (object) ['value' => '2024', 'year' => '2024'],
            (object) ['value' => '2025', 'year' => '2025'],
            (object) ['value' => '2026', 'year' => '2026'],
            (object) ['value' => '2027', 'year' => '2027'],
            (object) ['value' => '2028', 'year' => '2028'],
            (object) ['value' => '2029', 'year' => '2029'],
            (object) ['value' => '2030', 'year' => '2030'],

        ]);
    }

    public function add_business_days($startdate, $businessdays, $holidays, $dateformat)
    {
        $i = 1;
        $dayx = strtotime($startdate);

        while ($i <= $businessdays) {
            $day = date('N', $dayx);
            $date = date('Y-m-d', $dayx);
            if ($day < 6 && !in_array($date, $holidays)) {
                $i++;
            }
            $dayx = strtotime($date . ' +1 day');
        }

        return date($dateformat, strtotime(date('Y-m-d', $dayx) . ' -1 day'));
    }

    public function getFromInterface(DateTimeInterface $dateTimeInterface): DateTime
    {
        return new DateTime('@' . $dateTimeInterface->getTimestamp(), $dateTimeInterface->getTimezone());
    }
}
